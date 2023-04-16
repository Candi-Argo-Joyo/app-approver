<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Level extends Controller
{
    public function index()
    {
        \LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return view('pages/level/index');
    }
}
