<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateMemo extends Controller
{
    public function index()
    {
        return view('pages/createMemo/index');
    }

    public function add()
    {
        $data = [
            'selected' => 'createMemo'
        ];
        return view('pages/createMemo/add', $data);
    }
}
