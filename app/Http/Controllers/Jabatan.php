<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Jabatan extends Controller
{
    public function index()
    {
        return view('pages/jabatan/index');
    }

    public function save(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/')->with('error', 'access prohibited..!');
        }

        if ($request->param) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'param' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ]);
            }

            DB::table('position')->where('id', $request->param)->update([
                'name' => $request->name,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ]);
            }

            DB::table('position')->insert([
                'name' => $request->name,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        DB::beginTransaction();
        try {
            DB::commit();
            $msg = [
                'success' => 'Position saved successfully'
            ];
        } catch (\Throwable $e) {
            DB::rollback();
            $msg = ['error' => ['msg' => 'Position failed to save']];
        }

        return response()->json($msg);
    }

    public function edit(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/')->with('error', 'access prohibited..!');
        }

        $validasi = DB::table('position')->where('id', $request->param)->first();

        if (!$validasi) {
            return response()->json(['error' => ['msg' => 'Position not found']]);
        }

        return response()->json(['success' => ['data' => $validasi]]);
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/')->with('error', 'access prohibited..!');
        }

        $validasi = DB::table('position')->where('id', $request->param)->first();

        if (!$validasi) {
            return response()->json(['error' => ['msg' => 'Position not found']]);
        }

        DB::table('position')->where('id', $request->param)->delete();
        return response()->json(['success' => ['msg' => 'Position deleted successfully']]);
    }
}
