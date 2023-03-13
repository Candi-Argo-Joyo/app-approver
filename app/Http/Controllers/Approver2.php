<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Approver2 extends Controller
{
    public function index()
    {
        $data = [
            'setPage' => 'Approver 2'
        ];
        return view('pages/approver/index', $data);
    }
}
