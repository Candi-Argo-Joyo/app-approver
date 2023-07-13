<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DigitalAsign extends Controller
{
    public function index()
    {
        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        $data = [
            'users' => DB::table('users')->whereIn('role', ['manager', 'validator'])->get()
        ];
        return view('pages/digitalAsign/index', $data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:2048',
                'user' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        $imageName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $imageName);

        DB::table('digital_asign')->insert([
            'id_user' => $request->user,
            'image' => $imageName,
        ]);

        return response()->json(['success' => 'Digital asign successfully saved']);
    }

    public function delete(Request $request)
    {
        $validate = DB::table('digital_asign')->where('id', $request->param)->first();
        if ($validate) {
            unlink('uploads/' . $validate->image);
            DB::table('digital_asign')->where('id', $request->param)->delete();
            return response()->json(['success' => 'Digital asign successfully removed']);
        }
        return response()->json(['error' => 'Digital asign failed to delete']);
    }
}
