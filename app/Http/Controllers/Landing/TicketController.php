<?php

namespace App\Http\Controllers\Landing;

use App\Enums\RoleType;
use App\Enums\TicketStatus;
use App\Enums\TicketTaskStatus;
use App\Enums\TicketType;
use App\Facades\Audit;
use App\Http\Controllers\Controller;
use App\Mail\Ticket\Open as TicketOpen;
use App\Mail\Ticket\PendingAction as TicketPendingAction;
use App\Models\Attachment;
use App\Models\Authorization\Role;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('landing.ticket.create', [
            'page_title' => __('module.ticket'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'summary' => 'required|string|max:255',
            'details' => 'nullable',
            'requested_by_name' => 'required|string|max:255',
            'requested_by_email' => 'required|string|email|max:255',
            'requested_date' => 'nullable|date',
        ], [], [
            'summary' => __('app.summary'),
            'details' => __('app.details'),
            'requested_by_name' => __('app.name'),
            'requested_by_email' => __('app.email'),
            'requested_date' => __('app.date'),
        ]);

        $audit_data = json_encode([
            'summary' => $request->summary,
            'requested_by_name' => $request->requested_by_name,
            'requested_by_email' => $request->requested_by_email,
            'requested_date' => $request->requested_date,
        ]);

        DB::beginTransaction();

        $organization_id = null;
        $ticket_requested_at = !empty($request->requested_date) ? dateTime_Parse($request->requested_date) : dateTime_Now();

        try {
            $user = User::where('email', $request->requested_by_email)->first();
            if ($user == null) {
                $user = new User;
                $user->username = setUsernameFromEmail($request->requested_by_email);
                $user->email = $request->requested_by_email;
                $user->email_verified_at = dateTime_Now();
                $user->password = Hash::make(Str::random(8));
                $user->is_active = true;
            }
            $user->name = $request->requested_by_name;
            $user->save();

            $user->roles()->sync(getEndUserRoleID());

            $role = Role::find(getEndUserRoleID());
            if ($role && !empty($role->organization_id)) {
                $organization_id = $role->organization_id;
                if (!$user->isInOrganization($role->organization_id)) {
                    $subscription = new Subscription;
                    $subscription->object_id = $role->organization_id;
                    $subscription->object_type = 'organization_unit';
                    $subscription->subscriber_id = $user->id;
                    $subscription->subscriber_type = 'user';
                    $subscription->start_at = dateTime_Now();
                    $subscription->save();
                }
            }

            $ticket = new Ticket;
            $ticket->organization_id = $organization_id;
            $ticket->type = TicketType::INCIDENT;
            $ticket->ref = generateReferenceNo(config('ticket.incident.prefix'), app(Ticket::class)->getTable());
            $ticket->summary = $request->summary;
            $ticket->details = !empty(strip_tags($request->details)) ? $request->details : null;
            $ticket->status = TicketStatus::OPEN;
            $ticket->requested_by = $user->id;
            $ticket->requested_by_name = $user->name;
            $ticket->requested_at = $ticket_requested_at;
            $ticket->created_by = $user->id;
            $ticket->updated_by = $user->id;
            $ticket->save();

            if ($request->hasFile('attachment')) {
                foreach ($request->file('attachment') as $attachment) {
                    $attachment_name = $attachment->getClientOriginalName();
                    $attachment_ext = $attachment->getClientOriginalExtension();
                    $attachment_size = $attachment->getSize();

                    if (Storage::disk('public')->exists('ticket/'.$ticket->id.'/'.$ticket->uuid.'/'.$attachment_name)) {
                        // Look for a number before the extension; add one if there isn't already
                        if (preg_match('/(.*?)(\(\d+\))/', str_replace('.'.$attachment_ext, '', $attachment_name), $match)) {
                            // Have a number; get it
                            $name = trim($match[1]);
                            $number = intVal(str_replace(array('(', ')'), '', $match[2]));
                        } else {
                            // No number; pretend we found a zero
                            $name = str_replace('.'.$attachment_ext, '', $attachment_name);
                            $number = 0;
                        }

                        // Remove or replace characters that could break the URL
                        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Keep only letters, numbers, and hyphens

                        // Choose a name with an incremented number until a file with that name
                        // doesn't exist
                        do {
                            $attachment_name = $name.' ('.++$number.').'.$attachment_ext;
                        } while (Storage::disk('public')->exists('ticket/'.$ticket->id.'/'.$ticket->uuid.'/'.$attachment_name));
                    }

                    $attachment->storeAs('ticket/'.$ticket->id.'/'.$ticket->uuid, $attachment_name, 'public');

                    $attachment_file = new Attachment;
                    $attachment_file->uuid = $this->generateUuidAttachment();
                    $attachment_file->organization_id = $organization_id;
                    $attachment_file->object_id = $ticket->id;
                    $attachment_file->object_type = 'ticket';
                    $attachment_file->name = $attachment_name;
                    $attachment_file->slug = Str::slug($attachment_name);
                    $attachment_file->ext = $attachment_ext;
                    $attachment_file->size = $attachment_size;
                    $attachment_file->path = 'ticket/'.$ticket->id.'/'.$ticket->uuid;
                    $attachment_file->uploaded_by = $user->id;
                    $attachment_file->save();
                }
            }

            addTask('Tiket dicipta', TicketTaskStatus::OPEN, $ticket->id, 'ticket', getFirstLevelRoleID(), null, null, null, null, null, $ticket_requested_at, $organization_id);

            Audit::log('incident_ticket', Audit::CREATE, $audit_data);
            DB::commit();

            // send email notification to user that open the ticket
            Mail::to($user)->send(new TicketOpen($ticket, $user->name));

            // send email notification to first level user
            $users_first_level = getUsers([RoleType::LEVEL1], 'name', true, null, null, null, $organization_id);
            if ($users_first_level->isNotEmpty()) {
                if ($users_first_level->count() == 1) {
                    $user_first_level = $users_first_level->first();
                    Mail::to($user_first_level)->send(new TicketPendingAction($ticket, $user_first_level->name, 'open'));
                } else {
                    $user_first_level_emails = $users_first_level->pluck('email')->toArray();
                    Mail::to($user_first_level_emails)->send(new TicketPendingAction($ticket, 'All', 'open'));
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            Audit::log('incident_ticket', Audit::CREATE, $audit_data, $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('sa_error', __('app.error_occured'));
        }

        return redirect()->back()
            ->with('sa_success', __('app.data_submitted', [
                'type' => __('module.ticket'),
            ]));
    }

    private function generateUuidAttachment()
    {
        do {
            $uuid = (string) Str::orderedUuid();
        } while (Attachment::where('uuid', $uuid)->exists());

        return $uuid;
    }
}
