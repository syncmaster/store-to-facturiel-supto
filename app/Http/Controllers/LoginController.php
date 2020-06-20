<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class LoginController extends Controller
{
    public function index() {
        if (auth()->user()) {
            return redirect('/factoriel');
        }
        return view('welcome');
    }

    public function login(Request $request) {
        $userData = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );
    
        if(Auth::attempt($userData)) {
            return redirect('/factoriel');
        } else { 
            return view('welcome')->with('error', 'Грешни данни за вход');
        }   
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
    }
}
