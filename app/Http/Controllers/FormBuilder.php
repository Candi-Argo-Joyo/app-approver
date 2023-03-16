<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FormBuilder extends Controller
{
    public function index()
    {
        return view('pages/formBuilder/index');
    }

    public function add()
    {
        return view('pages/formBuilder/add');
    }
}
