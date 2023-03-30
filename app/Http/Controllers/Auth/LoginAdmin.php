<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LoginAdmin extends Controller
{
    public function index()
    {
        return view('login/admin');
    }
}
