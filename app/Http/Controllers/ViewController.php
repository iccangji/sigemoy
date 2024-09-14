<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    //
    public function login(){
        return view('admin.login');
    }
    
    public function DashboardAdmin(){
        return view('admin.DashboardAdmin');
    }
    
    public function DataPemilih(){
        return view('admin.Data-pemilih');
    }
}
