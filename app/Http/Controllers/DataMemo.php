<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataMemo extends Controller
{
    public function index()
    {
        return view('pages/dataMemo/index');
    }
}
