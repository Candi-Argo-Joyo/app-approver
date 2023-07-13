<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return view('pages/dashboard/index');
    }

    public function count(Request $request)
    {
        $user = DB::table('users')->where('role', '!=', 'administrator')->count('*');
        $form = DB::table('html_form')->count('*');
        $position = DB::table('position')->count('*');
        $division = DB::table('division')->count('*');
        return response()->json([
            'total' => [
                'user' => $user,
                'form' => $form,
                'position' => $position,
                'division' => $division,
            ]
        ]);
    }
}
