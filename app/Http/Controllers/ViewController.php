<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{

    public function DashboardAdmin()
    {
        return view('admin.dashboard');
    }

    public function DataPemilih()
    {
        return view('admin.pemilih');
    }
}
