<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        if (auth()->user()->level == "admin") {
        } else if (auth()->user()->level == "viewer") {
        } else if (auth()->user()->level == "penginput") {
        }
    }
}
