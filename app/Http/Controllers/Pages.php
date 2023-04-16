<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Pages extends Controller
{
    public function index(Request $request)
    {
        if (!$request->menu) {
            return redirect('/')->with('error', 'Param is invalid..!');
        }

        if ($request->menu && !$request->form && !$request->detail) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            $data = $this->dataArray($request);
            return view('pages/dinamispage/index', $data);
        }

        if ($request->menu && $request->form) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            $data = $this->dataForm($request);
            return view('pages/dinamispage/form/forminput', $data);
        }

        if ($request->menu && $request->detail) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            $data = $this->detailData($request);
            return view('pages/dinamispage/details/detail', $data);
        }
    }

    private function dataArray($request)
    {
        $page = DB::table('menu')->where('slug', $request->menu)->first();
        $data = [
            'menu' => $page,
            'parent' => DB::table('menu')->where('id', $page->parent)->first(),
        ];

        return $data;
    }

    private function dataForm($request)
    {
        $page = DB::table('menu')->where('slug', $request->menu)->first();
        $data = [
            'menu' => $page,
            'parent' => DB::table('menu')->where('id', $page->parent)->first(),
            'table_header' => DB::table('form_field')->where('id_html_form', $page->id_html_form)->whereNotIn('type', ['title'])->limit(5)->get(),
            'form' => DB::table('html_form')->where('id', $request->form)->first()
        ];

        return $data;
    }

    private function detailData($request)
    {
        $page = DB::table('menu')->where('slug', $request->menu)->first();
        $output = [];

        $field = DB::table('form_field')->where('id_html_form', $page->id_html_form)->get();
        foreach ($field as $f) {
            $value = DB::table('insert_form')->where('id_html_form', $page->id_html_form)->where('label', $f->field_name)->first();
            $layout = DB::table('form_layout')->where('id_html_form', $page->id_html_form)->where('id', $f->id_form_layout)->first();
            if ($f->type != 'title') {
                array_push($output,  [
                    'label' => $f->field_name,
                    'type' => $f->type,
                    'value' => $value->value,
                    'layout' => $layout->jenis
                ]);
            }

            if ($f->type == 'title') {
                array_push($output,  [
                    'label' => $f->field_name,
                    'type' => $f->type,
                    'value' => $f->original_name,
                    'layout' => $layout->jenis
                ]);
            }
        }

        $data = [
            'menu' => $page,
            'parent' => DB::table('menu')->where('id', $page->parent)->first(),
            'output' => $output,
            'layout' => DB::table('form_layout')->where('id_html_form', $page->id_html_form)->get(),
            'approver' => DB::table('approver_for_form')->where('id_html_form', $page->id_html_form)->get()
        ];

        return $data;
    }

    public function save(Request $request)
    {
        $field = DB::table('form_field')->where('id_html_form', $request->form)->get();
        $form = DB::table('html_form')->where('id', $request->form)->first();
        $validate = [];
        foreach ($field as $f) {
            if ($f->type != 'title') {
                $validate[$f->field_name] = 'required';
            }
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

        $approverCondition = DB::table('approver_for_form')->where('id_html_form', $request->form)->where('rule', 'true')->first();
        if ($approverCondition) {
            $namefield = DB::table('form_field')->where('id_html_form', $request->form)->where('id', $approverCondition->id_form_field)->first();
            switch ($approverCondition->comparison) {
                case '>':
                    if ($request->input($namefield->field_name) > $approverCondition->amount) {
                        $status = 'draft';
                    } else {
                        $status = 'approve';
                    }
                    break;
                case '<':
                    if ($request->input($namefield->field_name) < $approverCondition->amount) {
                        $status = 'approve';
                    } else {
                        $status = 'draft';
                    }
                    break;
                default:
                    $status = 'draft';
                    break;
            }
        } else {
            $status = 'draft';
        }

        foreach ($field as $value) {
            if ($value->type != 'title') {
                DB::table('insert_form')->insert([
                    'id_html_form' => $request->form,
                    'id_user' => Auth::user()['id'],
                    'user_name' => Auth::user()['name'],
                    'form_name' => $form->form_name,
                    'uid' => date('YmdHis'),
                    'field_name' => $value->original_name,
                    'label' => $value->field_name,
                    'value' => $request->input($value->field_name),
                    'status' => $status,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        return response()->json(['success' => 'Data is successfully saved']);
    }

    public function deleteInsertForm(Request $request)
    {
        $validate = DB::table('insert_form')->where('uid', $request->param)->get();
        if ($validate) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            DB::table('insert_form')->where('uid', $request->param)->delete();
            return response()->json(['success' => 'Data deleted successfully']);
        }

        return response()->json(['error' => ['msg' => 'Data failed to delete']]);
    }
}
