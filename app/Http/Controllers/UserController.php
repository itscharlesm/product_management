<?php

namespace App\Http\Controllers;

use App\Events\UserRegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register(Request $request){
        $data = $request -> validate([

            'name' => 'required',
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200'],

        ],[
            'password.min' => 'The password field must be at least 8 characters.'
        ]);

        event(new UserRegisterEvent($data['name']));

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        auth()->login($user);
        return redirect('/');
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request){
        $data = $request->validate([
            'login-email' => 'required', 
            'login-password' => 'required', 
        ],[

            'login-email.required' => 'The email field is required.',
            'login-password.required' => 'The password field is required.'

        ]);

        if (auth()->attempt(['email' => $data['login-email'], 'password' => $data['login-password']])){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return redirect()->back()->withErrors([
            'login-email' => 'Invalid credentials. Please try again.',
        ]);
    }
}
