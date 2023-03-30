<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingWeb extends Controller
{
    public function index()
    {
        $data = [
            'ldap' => json_decode(file_get_contents('ldap.json'), true)
        ];
        return view('pages/settingweb/index', $data);
    }

    public function saveLdap(Request $request)
    {
        # code...
    }
}
