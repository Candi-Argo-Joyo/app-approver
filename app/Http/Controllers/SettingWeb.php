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
        $data = [
            'default' => [
                'hosts' => "$request->hosts",
                'username' => "$request->username",
                'password' => "$request->password",
                'port' => intval($request->port),
                'base_dn' => "$request->base_dn",
                'timeout' => intval($request->timeout),
                'use_ssl' => $request->use_ssl == 'false' ? false : true,
                'use_tls' => $request->use_tls == 'false' ? false : true
            ]
        ];
        unlink('ldap.json');
        file_put_contents("ldap.json", json_encode($data));
        return response()->json(['success' => true]);
    }
}
