<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class zool extends Controller
{
    public function index()
    {
     return view('admin.index');
    }
}
