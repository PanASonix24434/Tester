<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CodeMaster;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Audit;
use Helper;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $userTypes = CodeMaster::where('type','user_type')
        ->whereNotIn('code', ['5'])
        ->orderBy('order','ASC')->get();

        return view('auth.register',[
            'userTypes' => $userTypes
        ]);    
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate(
        [
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:12|max:12|unique:users,username,NULL,NULL,deleted_at,NULL',
            'email' => 'required|string|email|max:50|unique:users,email,NULL,NULL,deleted_at,NULL',
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
            'username.required' => 'No Kad Pengenalan diperlukan.',
            'username.min' => 'No Kad Pengenalan mestilah 12 digit.',
            'username.max' => 'No Kad Pengenalan mestilah 12 digit.',
            'name.required' => 'Nama Penuh diperlukan.',
            'email.required' => 'Emel diperlukan.',
            'email.email' => 'Format emel yang dimasukkan tidak sah.',
            'password.min' => 'Kata Laluan mesti sekurang-kurangnya 12 aksara.',
            'password.regex' => 'Minimum 1 huruf kecil, 1 huruf besar, 1 nombor dan 1 simbol.',
            'password.confirmed' => 'Kata Laluan dan Pengesahan Kata Laluan tidak sepadan.',
        ]);

        Auth::login($user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->selUserType,
        ]));

        event(new Registered($user));

        $audit_details = json_encode([ 
            'name' => $user->name,
            'username' => $user->username, 
            'email' => $user->email,
            'user_type' => $request->selUserType,
            'status' => $user->is_active ? 'active' : 'inactive',
        ]);
        Audit::log('register', 'register', $audit_details);

        return redirect(RouteServiceProvider::HOME);
    }
}
