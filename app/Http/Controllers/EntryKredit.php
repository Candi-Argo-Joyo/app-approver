<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EntryKredit extends Controller
{
    public function index()
    {
        return view('pages/entrykredit/index');
    }

    public function add()
    {
        $data = [
            'selected' => 'kredit'
        ];

        return view('pages/entrykredit/add', $data);
    }
}
