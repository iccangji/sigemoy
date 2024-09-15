<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemilihController extends Controller
{
    public function index()
    {
        return view(
            'pages.pemilih',
            [
                'page' => 'pemlih',
                'user' => auth()->user()->user,
                'level' => auth()->user()->level
            ]
        );
    }
}
