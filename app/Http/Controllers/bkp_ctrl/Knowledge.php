<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Knowledge extends Controller
{
    public function index()
    {
        return view('pages/knowledge/index');
    }
}
