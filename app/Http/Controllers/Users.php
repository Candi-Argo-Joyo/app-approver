<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Users extends Controller
{
    public function index()
    {
        return view('pages/users/index');
    }

    public function getUsers()
    {
        $data = User::where('is_mapping', 'true')->whereIn('role', ['manager', 'validator', 'user'])->get();
        return response()->json(['data' => $data]);
    }

    public function save(Request $request)
    {

        if ($request->param) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'username' => 'required|alpha_num:ascii|unique:users,username,' . $request->param,
                    'email' => 'required|email|unique:users,email,' . $request->param,
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'username' => 'required|alpha_num:ascii|unique:users,username',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        if ($request->param) {
            $user = DB::table('users')->where('id', $request->param)->whereNull('guid')->first();
            if ($request->password) {
                $password = bcrypt($request->password);
            } else {
                $password = $user->password;
            }

            DB::table('users')->where('id', $request->param)->whereNull('guid')->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $password,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => 'User successfully updated'
            ]);
        } else {
            DB::table('users')->insert([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => 'User saved successfully'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $validasi = DB::table('users')->where('id', $request->param)->whereNull('guid')->first();
        if ($validasi) {
            return response()->json([
                'success' => $validasi
            ]);
        }

        return response()->json([
            'error' => 'User not found / source user from ldap (active directory)'
        ]);
    }

    public function delete(Request $request)
    {
        $validasi = DB::table('users')->where('id', $request->param)->first();
        if ($validasi) {
            DB::table('users')->where('id', $request->param)->delete();
            return response()->json([
                'success' => 'User successfully deleted'
            ]);
        }

        return response()->json([
            'error' => 'User failed to delete'
        ]);
    }
}
