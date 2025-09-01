<?php

namespace App\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\User;

use Auth;
use Audit;
use Hash;
use DB;
use Exception;
use Carbon\Carbon;
use PDF;
use Storage;
use Image;
use Helper;

class ChangePasswordController extends Controller
{

    //public function changepassword(Request $request, string $id)
    public function changepassword(Request $request)
    {
        $userId = Auth::id();

        $user = User::where('users.id', $userId)
        ->get();

        return view('app.admin.user.changepassword', [
            'userId' => $userId,
            'user' => $user,
        ]);
    }

    public function updatepassword(Request $request, string $id)
    {
        $this->validate($request, [
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:12', // Minimum length of 12 characters
                //'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/', // At least one uppercase, one number, one special character
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#,.])[A-Za-z\d@$!%*?&#,.]{12,}$/',
            ],
            'password_confirmation' => 'required|string',
        ],
        [
            'password.min' => 'Kata Laluan mesti sekurang-kurangnya 12 aksara.',
            'password.regex' => 'Minimum 1 huruf kecil, 1 huruf besar, 1 nombor dan 1 simbol.',
            'password.confirmed' => 'Kata Laluan dan Pengesahan Kata Laluan tidak sepadan.',
        ]);

        DB::beginTransaction();

        try {

            $user = User::find($id);

            //dd($id);

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();
            //dd('update');
            return redirect()->action('Systems\ChangePasswordController@changepassword')->with('alert', 'Pengesahan Kata Laluan berjaya !!');
    
        }
        catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }
       
    }


}