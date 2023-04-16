<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Divisi extends Controller
{
    public function index()
    {
        \LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return view('pages/divisi/index');
    }

    public function save(Request $request)
    {
        if ($request->param) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:division,name,' . $request->param,
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:division,name',
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        if ($request->param) {
            DB::table('division')->where('id', $request->param)->update([
                'name' => $request->name,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('division')->insert([
                'name' => $request->name,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        \LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return response()->json([
            'success' => 'Division successfully saved'
        ]);
    }

    public function edit(Request $request)
    {
        $validasi = DB::table('division')->where('id', $request->param)->first();
        if ($validasi) {
            \LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            return response()->json([
                'success' => $validasi
            ]);
        }

        return response()->json([
            'error' => 'Division not found'
        ]);
    }

    public function delete(Request $request)
    {
        $validasi = DB::table('division')->where('id', $request->param)->first();
        if ($validasi) {
            \LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            DB::table('division')->where('id', $request->param)->delete();

            return response()->json([
                'success' => 'Division successfully deleted'
            ]);
        }

        return response()->json([
            'error' => 'Failed division removed / Division not found'
        ]);
    }
}
