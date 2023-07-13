<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail as FacadesMail;

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

        // $field = DB::table('form_field')->where('id_html_form', $page->id_html_form)->get();
        // foreach ($field as $f) {
        //     $value = DB::table('insert_form')->where('id_html_form', $page->id_html_form)->where('label', $f->field_name)->first();
        //     $layout = DB::table('form_layout')->where('id_html_form', $page->id_html_form)->where('id', $f->id_form_layout)->first();
        //     if ($f->type != 'title') {
        //         array_push($output,  [
        //             'label' => $f->field_name,
        //             'type' => $f->type,
        //             'value' => $value->value,
        //             'layout' => $layout->jenis
        //         ]);
        //     }

        //     if ($f->type == 'title') {
        //         array_push($output,  [
        //             'label' => $f->field_name,
        //             'type' => $f->type,
        //             'value' => $f->original_name,
        //             'layout' => $layout->jenis
        //         ]);
        //     }
        // }

        $data = [
            'menu' => $page,
            'parent' => DB::table('menu')->where('id', $page->parent)->first(),
            'output' => $output,
            'layout' => DB::table('form_layout')->where('id_html_form', $page->id_html_form)->get(),
            'approver' => DB::table('validation')->where('id_html_form', $page->id_html_form)->get()
        ];

        return $data;
    }

    public function getItem(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 'Access is not allowed']);
        }

        $validate = DB::table('items')->where('id_group_item', $request->group)->get();

        if ($validate->isNotEmpty()) {
            return response()->json([
                'success' => [
                    'data' => $validate
                ]
            ]);
        } else {
            return response()->json([
                'error' => [
                    'msg' => 'Item not found'
                ]
            ]);
        }
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

        $getValidator = DB::table('validation')->where('id_html_form', $request->form)->get();
        if ($getValidator->isEmpty()) {
            return response()->json([
                'error' => [
                    'validator' => 'Validator is empty'
                ]
            ]);
        }

        $idUserValidator = '';

        foreach ($getValidator as $v) {
            $idUserValidator .= $v->id_user . ',';
        }

        foreach ($field as $value) {
            if ($value->type != 'title') {
                DB::table('insert_form')->insert([
                    'id_html_form' => $request->form,
                    'id_user' => Auth::user()['id'],
                    'id_user_validator' => $idUserValidator,
                    'user_name' => Auth::user()['name'],
                    'form_name' => $form->form_name,
                    'uid' => date('YmdHis'),
                    'field_name' => $value->original_name,
                    'label' => $value->field_name,
                    'value' => $request->input($value->field_name),
                    'on_step' => 1,
                    'status' => 'under-review',
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

    public function validateData(Request $request)
    {
        $approverCondition = DB::table('approver_for_form')->where('id_html_form', $request->form)->where('rule', 'true')->first();
        $user_id_approver = DB::table('approver_for_form')->where('id_html_form', $request->form)->where('type', 'Approver')->first();
        // dd($user_id_approver);
        $email = DB::table('users')->where('id', $user_id_approver->id_user_approver)->first();
        if ($approverCondition) {
            $namefield = DB::table('form_field')->where('id_html_form', $request->form)->where('id', $approverCondition->id_form_field)->first();
            $nominal = DB::table('insert_form')->where('label', $namefield->field_name)->first();
            if ($nominal) {
                switch ($approverCondition->comparison) {
                    case '>':
                        if ($nominal->value > $approverCondition->amount) {
                            FacadesMail::to($email->email)->send(new NotifyMail());
                            $status = 'validated';
                        } else {
                            $status = 'approve';
                        }
                        break;
                    case '<':
                        if ($nominal->value < $approverCondition->amount) {
                            $status = 'approve';
                        } else {
                            FacadesMail::to($email->email)->send(new NotifyMail());
                            $status = 'validated';
                        }
                        break;
                    default:
                        FacadesMail::to($email->email)->send(new NotifyMail());
                        $status = 'validated';
                        break;
                }
            } else {
                FacadesMail::to($email->email)->send(new NotifyMail());
                $status = 'validated';
            }
        } else {
            FacadesMail::to($email->email)->send(new NotifyMail());
            $status = 'validated';
        }

        if (FacadesMail::failures()) {
            $msg = ['msg' => 'Sorry! Email failed to send to manager'];
        } else {
            $msg = ['msg' => 'Great! Email sent successfully to manager'];
        }

        $validate = DB::table('insert_form')->where('uid', $request->param)->first();
        if ($validate) {
            DB::table('insert_form')->where('uid', $request->param)->update([
                'status' => $status,
                'validate_by' => Auth::user()['name'],
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json(['success' => 'Data successfully validated', 'mail' => $msg]);
        }

        return response()->json(['error' => 'Data failed validated', 'mail' => $msg]);
    }

    public function approveData(Request $request)
    {
        $validate = DB::table('insert_form')->where('uid', $request->param)->first();
        if ($validate) {
            DB::table('insert_form')->where('uid', $request->param)->update([
                'status' => 'approve',
                'on_step' => ($validate->on_step + 1),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json(['success' => 'Data has been successfully approve']);
        }

        return response()->json(['error' => ['msg' => 'Data failed to approve']]);
    }
}
