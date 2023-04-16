<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;


class Log extends Controller
{
    public function logActivity()
    {
        return view('pages.logs');
    }
}
