<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function auth()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'user' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            return back()->with('loginError', 'User atau Password salah');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function index(){
        $data = User::where('level','viewer')->orWhere('level','penginput')->get();
        $countUser = User::count();
        return view(
            'pages.datauser',
            [
                'page' => 'user',
                'title' => 'Data User',
                'user' => auth()->user()->user,
                'level' => auth()->user()->level,
                'data' => $data,
                'count' => $countUser
            ]
        );
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required|min:8',
            'level' => 'required',
        ]);
        if($data){
            User::create([
                'user' => $request->username,
                'password' => Hash::make($request->password),
                'level' => $request->level,
            ]);
            return back()->with('success', 'User berhasil ditambahkan');
        }
        return back()->with('error', 'User gagal ditambahkan, pastikan password berisi 8 karakter atau lebih');
    }

    public function update(Request $request, $id)
    {
        
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required|min:8',
            'level' => 'required',
        ]);
        if($data){
            $item = User::findOrFail($id);
            $item->update([
                'user' => $request->username,
                'password' => Hash::make($request->password),
                'level' => $request->level,
            ]);
            return back()->with('success', 'User berhasil diubah');
        }
        return back()->with('error', 'User gagal diubah, pastikan password berisi 8 karakter atau lebih');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}
