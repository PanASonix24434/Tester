<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Helper;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            //return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
	    return redirect('/logout2');
        }

        if ($request->user()->markEmailAsVerified()) {

            //NELAYAN LAUT
            if($request->user()->user_type == 1){
                $request->user()->roles()->attach(Helper::getRoleIdByRoleName('PEMOHON LESEN VESEL (NELAYAN LAUT)'));
            }
            //NELAYAN DARAT
            elseif($request->user()->user_type == 2){
                $request->user()->roles()->attach(Helper::getRoleIdByRoleName('PEMOHON LESEN VESEL (NELAYAN DARAT)'));
            }
            //PENGUSAHA SKL
            elseif($request->user()->user_type == 3){
                $request->user()->roles()->attach(Helper::getRoleIdByRoleName('PENGUSAHA SKL'));
            }
            //PENTADBIR HARTA
            elseif($request->user()->user_type == 4){
                $request->user()->roles()->attach(Helper::getRoleIdByRoleName('PENTADBIR HARTA'));
            }
             //PEWARIS
            elseif($request->user()->user_type == 6){
                $request->user()->roles()->attach(Helper::getRoleIdByRoleName('PEWARIS'));
            }
            //PENGURUS VESEL
            elseif($request->user()->user_type == 5){
                $request->user()->roles()->attach(Helper::getRoleIdByRoleName('PENGURUS VESEL'));
            }

            event(new Verified($request->user()));
        }

        //return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        return redirect('/logout2');
    }
}