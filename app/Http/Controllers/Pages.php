<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Pages extends Controller
{
    public function index(Request $request)
    {
        if (!$request->menu) {
            return redirect('/')->with('error', 'Param is invalid..!');
        }

        $page = DB::table('menu')->where('slug', $request->menu)->first();
        $data = [
            'menu' => $page,
            'parent' => DB::table('menu')->where('id', $page->parent)->first()
        ];
        return view('pages/dinamispage/index', $data);
    }
}
