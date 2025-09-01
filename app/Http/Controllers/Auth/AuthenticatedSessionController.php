<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Audit;

use App\Models\Announcement;

use Hash;
use DB;
use Exception;
use Carbon\Carbon;
use PDF;
use Storage;
use Image;
use Helper;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Audit::log('logout', 'logout');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    //Register redirect to login
    public function destroy2(Request $request)
    {
        Audit::log('logout', 'logout');

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function welcome()
    {
        $todayDate = Carbon::now()->format('Y-m-d');

        $annTexts = Announcement::whereNull('deleted_by')
        ->where('announcement_type', 1)
        ->where('announcement_status', 1)
        //->where('start_date', '<=', $todayDate)
        //->where('end_date', '>=', $todayDate)
        ->whereDate('start_date', '<=', Carbon::now())
        ->whereDate('end_date', '>=', Carbon::now())
        ->orderBy('start_date', 'DESC')
        //->take(5)
        ->get();

        //dd(count($annTexts));
        //dd($todayDate);

        return view('welcome',[
            'annTexts' => $annTexts,
            'annTextsCount' => count($annTexts),
        ]);
    }
}
