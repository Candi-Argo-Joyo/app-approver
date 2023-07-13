<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Items extends Controller
{
    public function index()
    {
        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return view('pages/items/index');
    }

    public function save_group(Request $request)
    {
        if ($request->param) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:group_item,name,' . $request->param,
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:group_item,name',
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        if ($request->param) {
            DB::table('group_item')->where('id', $request->param)->update([
                'name' => $request->name,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('group_item')->insert([
                'name' => $request->name,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return response()->json([
            'success' => 'Item successfully saved'
        ]);
    }

    public function edit(Request $request)
    {
        $validasi = DB::table('group_item')->where('id', $request->param)->first();
        if ($validasi) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            return response()->json([
                'success' => $validasi
            ]);
        }

        return response()->json([
            'error' => 'Group item not found'
        ]);
    }

    public function delete(Request $request)
    {
        $validasi = DB::table('group_item')->where('id', $request->param)->first();
        if ($validasi) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            DB::table('group_item')->where('id', $request->param)->delete();
            return response()->json([
                'success' => 'Group item successfully deleted'
            ]);
        }

        return response()->json([
            'error' => 'Failed Group item removed / Group item not found'
        ]);
    }

    public function getAllGroupItems()
    {
        $data = DB::table('group_item')->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function save_item(Request $request)
    {
        if ($request->param_item) {
            $validator = Validator::make(
                $request->all(),
                [
                    'group_item' => 'required|integer|regex:/^([0-9]+)$/|not_in:0|exists:group_item,id',
                    'name_item' => 'required|unique:items,name,' . $request->param_item,
                    'unit' => 'required'
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'group_item' => 'required|integer|regex:/^([0-9]+)$/|not_in:0|exists:group_item,id',
                    'name_item' => 'required|unique:items,name',
                    'unit' => 'required'
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        if ($request->param_item) {
            DB::table('items')->where('id', $request->param_item)->update([
                'id_group_item' => $request->group_item,
                'name' => $request->name_item,
                'unit' => $request->unit,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('items')->insert([
                'id_group_item' => $request->group_item,
                'name' => $request->name_item,
                'unit' => $request->unit,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return response()->json([
            'success' => 'Item successfully saved'
        ]);
    }

    public function editItem(Request $request)
    {
        $validasi = DB::table('items')->where('id', $request->param)->first();
        if ($validasi) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            return response()->json([
                'success' => $validasi
            ]);
        }

        return response()->json([
            'error' => 'Group item not found'
        ]);
    }

    public function deleteItem(Request $request)
    {
        $validasi = DB::table('items')->where('id', $request->param)->first();
        if ($validasi) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            DB::table('items')->where('id', $request->param)->delete();
            return response()->json([
                'success' => 'Item successfully deleted'
            ]);
        }

        return response()->json([
            'error' => 'Failed item removed / Item not found'
        ]);
    }
}
