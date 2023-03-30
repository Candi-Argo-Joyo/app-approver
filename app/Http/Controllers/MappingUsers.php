<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MappingUsers extends Controller
{
    public function index()
    {
        return view('pages/mappinguser/index');
    }
}
