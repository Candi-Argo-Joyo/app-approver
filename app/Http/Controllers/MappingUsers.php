<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MappingUsers extends Controller
{
    public function index()
    {
        \LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return view('pages/mappinguser/index');
    }

    public function saveMapping(Request $request)
    {
        $validate = [];
        for ($i = 0; $i < count($request->select); $i++) {
            $validate["select.$i"] = 'required|integer|regex:/^([0-9]+)$/|not_in:0';
            $validate["role.$i"] = 'required';
            $validate["position.$i"] = 'required|integer|regex:/^([0-9]+)$/|not_in:0';
            $validate["division.$i"] = 'required|integer|regex:/^([0-9]+)$/|not_in:0';
        }

        $validator = Validator::make(
            $request->all(),
            $validate
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        $id = $request->select;
        $id_jabatan = $request->position;
        $id_divisi = $request->division;
        $role = $request->role;
        for ($i = 0; $i < count($request->select); $i++) {
            $jabatan = DB::table('position')->where('id', $id_jabatan[$i])->first();
            $divisi = DB::table('division')->where('id', $id_divisi[$i])->first();

            DB::table('users')->where('id', $id[$i])->update([
                'id_jabatan' => $id_jabatan[$i],
                'jabatan_name' =>  $jabatan->name,
                'id_divisi' => $id_divisi[$i],
                'divisi_name' => $divisi->name,
                'role' => $role[$i],
                'is_mapping' => 'true'
            ]);
        }

        \LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return response()->json([
            'success' => 'The user mapping has been successfully saved'
        ]);
    }

    public function rollback(Request $request)
    {
        $validate = DB::table('users')->where('id', $request->param)->first();
        if ($validate) {
            DB::table('users')->where('id', $request->param)->update([
                'id_jabatan' => NULL,
                'jabatan_name' =>  NULL,
                'id_divisi' => NULL,
                'divisi_name' => NULL,
                'role' => 'user',
                'is_mapping' => 'false'
            ]);

            \LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            return response()->json([
                'success' => 'User ' . $validate->name . ' successfully rollback'
            ]);
        }

        return response()->json([
            'error' => 'Failed to rollback'
        ]);
    }
}
