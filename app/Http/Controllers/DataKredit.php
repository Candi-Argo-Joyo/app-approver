<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataKredit extends Controller
{
    public function index()
    {
        return view('pages/datakredit/index');
    }

    public function detail()
    {
        $data = [
            'selected' => 'detailKredit'
        ];
        return view('pages/datakredit/detail', $data);
    }
}
