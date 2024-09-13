<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'user' => '',
            'password' => '',
        ]);
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->with('loginError', 'User atau Password salah');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
