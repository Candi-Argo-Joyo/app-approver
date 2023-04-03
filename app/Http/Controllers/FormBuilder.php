<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FormBuilder extends Controller
{
    public function index()
    {
        $data = [
            'forms' => DB::table('html_form')->orderBy('id', 'desc')->get()
        ];
        return view('pages/formbuilder/index', $data);
    }

    public function add(Request $request)
    {
        $data = [
            'selected' => 'form_builder',
            'html' => isset($request->form) ? DB::table('html_form')->where('id', $request->form)->first() : DB::table('html_form')->where('status', 'draft')->first(),
            'page' => DB::table('menu')->where('parent', 0)->where('status', 'active')->get(),
        ];
        return view('pages/formbuilder/addform', $data);
    }

    public function createForm(Request $request)
    {
        try {

            $html_form_id = DB::table('html_form')->insertGetId([
                'form_name' => $request->input('form_name'),
                'html_builder' => $request->html,
                'created_by' => 0,
                'status' => 'draft',
            ]);

            $html = '<div>
                        <input class="form-name" type="text" value="' . $request->input('form_name') . '" name="form_name" placeholder="Form Name">
                        <input type="text" hidden id="html_form" value="' . $html_form_id . '">
                    </div>
                    <div data-save-html>
                        <div data-final>
                            <div data-inner-layout>
                            </div>
                            <div id="script">
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#myModal"
                                        class="btn btn-primary text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                        + Add Layout
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="del-form btn btn-danger text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right">
                                        Delete Form
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="next-form btn btn-success text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right">
                                        Next
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>';

            $msg = [
                'success' => [
                    'data' => $html,
                    'param' => $html_form_id
                ]
            ];
        } catch (\Throwable $e) {
            $msg = [
                'error' => [
                    'msg' => $e
                ]
            ];
        }

        return json_encode($msg);
    }

    public function updateFormHtml(Request $request)
    {
        if (isset($request->html_preview)) {
            $prev = $request->html_preview;
            $html_preview = '';
            for ($i = 0; $i < count($request->html_preview); $i++) {
                $html_preview .= $prev[$i];
            }

            $data = [
                'form_name' => $request->form_name,
                'html_final' => $html_preview,
                'status' => 'publish'
            ];
        } else {
            $data = [
                'html_builder' => $request->html
            ];
        }

        DB::table('html_form')->where('id', $request->param_html)->update($data);

        return json_encode(['success' => true]);
    }

    public function delForm(Request $request)
    {
        $validate = DB::table('html_form')->where('id', $request->param)->first();
        if ($validate) {
            DB::table('html_form')->where('id', $request->param)->delete();
            DB::table('form_layout')->where('id_html_form', $request->param)->delete();
            DB::table('form_field')->where('id_html_form', $request->param)->delete();
        }
    }

    public function getLayout(Request $request)
    {
        $layoutLength = $request->input('length') == 0 ? 1 : $request->input('length');
        if ($request->input('length') >= 1) {
            $layoutLength++;
        }

        switch ($request->input('jenis')) {
            case 'column 1':
                $id_layout = DB::table('form_layout')->insertGetId([
                    'id_html_form' => $request->param_html,
                    'jenis' => 'column-1',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="mt-4" data-count-layout>
                                <div class="d-flex align-items-end flex-column">
                                    <a href="javascript:void(0)" id-layout="' . $id_layout . '" data-no-urut="layout-' . $layoutLength . '" class="btn btn-danger del-layout">x</a>
                                </div>
                                <div
                                    class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray bg-layout" data-css data-form-final>
                                    <div class="row" id="layout-' . $layoutLength . '">
                                        <div class="col-md-12" id="section-1">
                                            <div class="mb-3" data-iner>

                                            </div>
                                            <div class="col-md-12" data-action>
                                                <div class="d-flex align-items-end flex-column">
                                                    <a href="javascript:void(0)" x-field data-bs-toggle="modal"
                                                        id-layout="' . $id_layout . '" data-layout="layout-' . $layoutLength . '" data-section="section-1" data-bs-target="#fields"
                                                        class="btn btn-primary text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                break;
            case 'column 2':
                $id_layout = DB::table('form_layout')->insertGetId([
                    'id_html_form' => $request->param_html,
                    'jenis' => 'column-2',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="mt-4" data-count-layout>
                                <div class="d-flex align-items-end flex-column">
                                    <a href="javascript:void(0)" id-layout="' . $id_layout . '" data-no-urut="layout-' . $layoutLength . '"  class="btn btn-danger del-layout">x</a>
                                </div>
                                <div
                                    class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray bg-layout" data-css data-form-final>
                                    <div class="row" id="layout-' . $layoutLength . '">
                                        <div class="col-md-6" id="section-1">
                                            <div class="mb-3" data-iner>
                                            
                                            </div>
                                            <div class="col-md-12" data-action>
                                                <div class="d-flex align-items-end flex-column">
                                                    <a href="javascript:void(0)" x-field data-bs-toggle="modal"
                                                        id-layout="' . $id_layout . '" data-layout="layout-' . $layoutLength . '" data-section="section-1" data-bs-target="#fields"
                                                        class="btn btn-primary text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="section-2">
                                            <div class="mb-3" data-iner>
                                            
                                            </div>
                                            <div class="col-md-12" data-action>
                                                <div class="d-flex align-items-end flex-column">
                                                    <a href="javascript:void(0)" x-field data-bs-toggle="modal"
                                                        id-layout="' . $id_layout . '" data-layout="layout-' . $layoutLength . '" data-section="section-2" data-bs-target="#fields"
                                                        class="btn btn-primary text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                break;
            case 'column 3':
                $id_layout = DB::table('form_layout')->insertGetId([
                    'id_html_form' => $request->param_html,
                    'jenis' => 'column-2',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="mt-4" data-count-layout>
                                <div class="d-flex align-items-end flex-column">
                                    <a href="javascript:void(0)" id-layout="' . $id_layout . '" data-no-urut="layout-' . $layoutLength . '"  class="btn btn-danger del-layout">x</a>
                                </div>
                                <div
                                    class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray bg-layout" data-css data-form-final>
                                    <div class="row" id="layout-' . $layoutLength . '">
                                        <div class="col-md-4" id="section-1">
                                            <div class="mb-3" data-iner>
                                            
                                            </div>
                                            <div class="col-md-12" data-action>
                                                <div class="d-flex align-items-end flex-column">
                                                    <a href="javascript:void(0)" x-field data-bs-toggle="modal"
                                                        id-layout="' . $id_layout . '" data-layout="layout-' . $layoutLength . '" data-section="section-1" data-bs-target="#fields"
                                                        class="btn btn-primary text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="section-2">
                                            <div class="mb-3" data-iner>
                                            
                                            </div>
                                            <div class="col-md-12" data-action>
                                                <div class="d-flex align-items-end flex-column">
                                                    <a href="javascript:void(0)" x-field data-bs-toggle="modal"
                                                        id-layout="' . $id_layout . '" data-layout="layout-' . $layoutLength . '" data-section="section-2" data-bs-target="#fields"
                                                        class="btn btn-primary text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="section-3">
                                            <div class="mb-3" data-iner>
                                            
                                            </div>
                                            <div class="col-md-12" data-action>
                                                <div class="d-flex align-items-end flex-column">
                                                    <a href="javascript:void(0)" x-field data-bs-toggle="modal"
                                                        id-layout="' . $id_layout . '" data-layout="layout-' . $layoutLength . '" data-section="section-3" data-bs-target="#fields"
                                                        class="btn btn-primary text-center border-dashed-top border-dashed-bottom border-dashed-left border-dashed-right border-color-gray">
                                                        + Add Field
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                break;
        }

        return json_encode($html);
    }

    public function delLayout(Request $request)
    {
        $validasi = DB::table('form_layout')->where('id', $request->id)->first();
        if ($validasi) {
            DB::table('form_layout')->where('id', $request->id)->delete();
            DB::table('form_field')->where('id_form_layout', $request->id)->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true]);
    }

    public function getField(Request $request)
    {
        $urutanLayout = $request->input('layout');
        $urutanSection = $request->input('section');

        $urutanField = $request->input('length') == 0 ? 1 : $request->input('length');
        if ($request->input('length') >= 1) {
            $urutanField++;
        }

        $script = 'null';

        switch ($request->input('type')) {
            case 'title':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'title ' . $urutanField,
                    'type' => 'title',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="d-flex flex-row justify-content-between gap-2 mb-3" data-field-label id="title-' . $urutanField . '">
                            <div class="w-100">
                                <input data-label-input id-field="' . $idField . '" has-change="false" data-name="label-title-field-' . $urutanField . '" data-label-title data-title="true"
                                    type="text" value="Your title here ' . $urutanField . '" class="no-border w-100 input-title" data-type="title"
                                    id="label-title-field-' . $urutanField . '" hidden>
                                <label data-field-label has-change="false" data-target="label-title-field-' . $urutanField . '" class="h4">Your title here ' . $urutanField . '</label>
                            </div>
                            <div>
                                <div class="d-flex gap-2 mb-2" data-action>
                                    <a href="javascript:void(0)" class="badge bg-warning" x-edit data-type="title" data-edit-title
                                        data-name="label-title-field-' . $urutanField . '">
                                        edit
                                    </a>
                                    <a href="javascript:void(0)" class="badge bg-danger del-fileld" data-delete-title
                                        id-field="' . $idField . '" data-target-delete="#title-' . $urutanField . '" data-type="title">
                                        delete
                                    </a>
                                </div>
                            </div>
                        </div>';
                break;
            case 'text':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'text-field-' . $urutanField,
                    'type' => 'text',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-text id="text-' . $urutanField . '" data-css>
                            <div class="d-flex flex-row justify-content-end gap-2 mb-2" data-action>
                                <a href="javascript:void(0)" class="badge bg-warning" x-edit data-edit-text data-name="label-text-field-' . $urutanField . '">
                                    edit
                                </a>
                                <a href="javascript:void(0)" id-field="' . $idField . '" class="badge bg-danger del-fileld" data-delete-text data-target-delete="#text-' . $urutanField . '" data-type="text">
                                    delete
                                </a>
                            </div>
                            <div class="row justify-items-center">
                                <div class="col-sm-3 col-form-label">
                                    <input data-label-input id-field="' . $idField . '" data-label-text type="text" has-change="false" value="Text Field ' . $urutanField . '" data-target-input="#text-field-' . $urutanField . '" class="no-border w-100" id="label-text-field-' . $urutanField . '" readonly="true">
                                </div>
                                <div class="col-sm-9">
                                    <input data-filed data-text class="form-control input-text" has-change="false" placeholder="Input Text Here..." type="text" name="text-field-' . $urutanField . '" id="text-field-' . $urutanField . '">
                                </div>
                            </div> 
                        </div>';
                break;
            case 'date':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'date-field-' . $urutanField,
                    'type' => 'date',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-date id="date-' . $urutanField . '" data-css>
                            <div class="d-flex flex-row justify-content-end gap-2 mb-2" data-action>
                                <a href="javascript:void(0)" class="badge bg-warning" x-edit data-edit-date data-name="label-date-field-' . $urutanField . '">
                                    edit
                                </a>
                                <a href="javascript:void(0)" id-field="' . $idField . '" class="badge bg-danger del-fileld" data-delete-date data-target-delete="#date-' . $urutanField . '" data-type="date">
                                    delete
                                </a>
                            </div>
                            <div class="row justify-items-center">
                                <div class="col-sm-3 col-form-label">
                                    <input data-label-input id-field="' . $idField . '" data-label-date type="text" has-change="false" value="Date Field ' . $urutanField . '" data-target-input="#date-field-' . $urutanField . '" class="no-border w-100" id="label-date-field-' . $urutanField . '" readonly="true">
                                </div>
                                <div class="col-sm-9">
                                    <input data-filed data-date class="form-control input-date" type="date" has-change="false" name="date-field-' . $urutanField . '" id="date-field-' . $urutanField . '">
                                </div>
                            </div> 
                        </div>';
                break;
            case 'file upload':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'file-field-' . $urutanField,
                    'type' => 'file',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-file id="file-' . $urutanField . '" data-css>
                            <div class="d-flex flex-row justify-content-end gap-2 mb-2" data-action>
                                <a href="javascript:void(0)" class="badge bg-warning" x-edit data-edit-file data-name="label-file-field-' . $urutanField . '">
                                    edit
                                </a>
                                <a href="javascript:void(0)" id-field="' . $idField . '" class="badge bg-danger del-fileld" data-delete-file data-target-delete="#file-' . $urutanField . '" data-type="file">
                                    delete
                                </a>
                            </div>           
                            <div class="row justify-items-center">
                                <div class="col-sm-3 col-form-label">
                                    <input data-label-input id-field="' . $idField . '" data-label-file type="text" has-change="false" value="File Field ' . $urutanField . '" data-target-input="#file-field-' . $urutanField . '" class="no-border w-100" id="label-file-field-' . $urutanField . '" readonly="true">
                                </div>
                                <div class="col-sm-9">
                                    <input data-filed data-file class="form-control input-file" type="file" has-change="false" name="file-field-' . $urutanField . '" id="file-field-' . $urutanField . '">
                                </div>
                            </div> 
                         </div>';
                break;
            case 'textarea':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'textarea-field-' . $urutanField,
                    'type' => 'textarea',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-textarea id="textarea-' . $urutanField . '" data-css>
                            <div class="d-flex flex-row justify-content-end gap-2 mb-2" data-action>
                                <a href="javascript:void(0)" class="badge bg-warning" x-edit data-edit-textarea data-name="label-textarea-field-' . $urutanField . '">
                                    edit
                                </a>
                                <a href="javascript:void(0)" id-field="' . $idField . '" class="badge bg-danger del-fileld" data-delete-textarea data-no=' . $urutanField . ' data-target-delete="#textarea-' . $urutanField . '" data-type="textarea">
                                    delete
                                </a>
                            </div>           
                            <div class="row justify-items-center">
                               <div class="col-sm-3 col-form-label">
                                   <input data-label-input id-field="' . $idField . '" data-label-textarea type="text" has-change="false" value="Textarea Field ' . $urutanField . '" data-target-input="#textarea-field-' . $urutanField . '" class="no-border w-100" id="label-textarea-field-' . $urutanField . '" readonly="true">
                               </div>
                               <div class="col-sm-9">
                                    <textarea data-filed data-textarea class="form-control input-textarea" has-change="false" name="textarea-field-' . $urutanField . '" id="textarea-field-' . $urutanField . '"></textarea>
                               </div>
                            </div> 
                         </div>';
                break;
            case 'select-option':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'select-option-field-' . $urutanField,
                    'type' => 'select-option',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $id_select = DB::table('option_group')->insertGetId([
                    'name_group' => 'Select Field ' . $urutanField . '',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                DB::table('option_value')->insert([
                    'id_option_group' => $id_select,
                    'value' => '--Pilih--',
                    'placeholder' => 'True',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-select id="select-option-' . $urutanField . '" data-css>
                            <div class="d-flex flex-row justify-content-end gap-2 mb-2" data-action>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#opsi-select-option" class="badge bg-primary" x-setting data-setting-select data-name="label-select-field-' . $urutanField . '" data-option-group="' . $id_select . '" data-target-input="#select-option-field-' . $urutanField . '">
                                    setting
                                </a>
                                <a href="javascript:void(0)" class="badge bg-warning" x-edit data-edit-select data-name="label-select-field-' . $urutanField . '" data-layout="layout-' . $urutanLayout . '" data-section="section-' . $urutanSection . '">
                                    edit
                                </a>
                                <a href="javascript:void(0)" id-field="' . $idField . '" class="badge bg-danger del-fileld" data-delete-select data-target-label="#label-select-field-' . $urutanField . '" data-target-delete="#select-option-' . $urutanField . '" data-type="select" data-option-group="' . $id_select . '">
                                    delete
                                </a>
                            </div>           
                            <div class="row justify-items-center">
                               <div class="col-sm-3 col-form-label">
                                    <input data-label-input id-field="' . $idField . '" data-label-select type="text" has-change="false" value="Select Field ' . $urutanField . '" data-target-input="#select-option-field-' . $urutanField . '" class="no-border w-100" id="label-select-field-' . $urutanField . '" readonly="true">
                               </div>
                               <div class="col-sm-9">
                                    <select data-filed select-option class="form-control select-option" has-change="false" name="select-option-field-' . $urutanField . '" id="select-option-field-' . $urutanField . '">
                                            <option>--Pilih--</option>
                                    </select>
                               </div> 
                            </div> 
                        </div>';
                break;
            case 'radio-button':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'default-radio-buttons-' . $urutanField,
                    'type' => 'radio-button',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $id_radio = DB::table('radio_group')->insertGetId([
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                DB::table('radio_value')->insert([
                    'id_radio_group' => $id_radio,
                    'value' => 'Radio Button',
                    'first' => 'True',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3"
                            id="radio-' . $urutanField . '" data-radio>
                            <div class="d-flex flex-row justify-content-end gap-2 mb-2" data-action>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#radio"
                                    class="badge bg-primary" x-radio data-setting-radio data-name="label-radio-field-' . $urutanField . '"
                                    data-radio-group="' . $id_radio . '" data-target-input="#radio-append-' . $urutanField . '">
                                    setting
                                </a>
                                <a href="javascript:void(0)" class="badge bg-warning" x-edit data-edit-radio data-type="radio"
                                    data-name="label-radio-field-' . $urutanField . '">
                                    edit
                                </a>
                                <a href="javascript:void(0)" class="badge bg-danger del-fileld" data-delete-radio
                                    id-field="' . $idField . '" data-target-delete="#radio-' . $urutanField . '" data-type="radio">
                                    delete
                                </a>
                            </div>
                            <h5 class="card-title" has-change="false" data-is-label-radio data-label-radio="label-radio-field-' . $urutanField . '">Default Radio
                                Buttons ' . $urutanField . '</h5>
                            <input data-label-input id-field="' . $idField . '" data-label-radio has-change="false" type="text"
                                data-name="label-radio-field-' . $urutanField . '" id="label-radio-field-' . $urutanField . '" value="Default Radio Buttons ' . $urutanField . '"
                                class="no-border radio-button" data-type="radio" hidden>
                            <div data-radio-append id="radio-append-' . $urutanField . '">
                                <fieldset class="radio">
                                    <label>
                                        <input type="radio" has-change="false" data-name-radio="label-radio-field-' . $urutanField . '" name="default-radio-buttons-' . $urutanField . '"
                                            value="Radio Button">
                                        Radio Button
                                    </label>
                                </fieldset>
                            </div>
                        </div>';
                break;
            case 'check-box':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'checkbox-' . $urutanField,
                    'type' => 'check-box',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3"
                            data-field-checkbox id="checkbox-' . $urutanField . '" data-css>
                            <div class="d-flex flex-row justify-content-end gap-2 mb-2" data-action>
                                <a href="javascript:void(0)" class="badge bg-warning" x-edit data-edit-checkbox
                                    data-type="checkbox" data-name="label-checkbox-field-' . $urutanField . '">
                                    edit
                                </a>
                                <a href="javascript:void(0)" class="badge bg-danger del-fileld" data-delete-checkbox
                                    id-field="' . $idField . '" data-target-delete="#checkbox-' . $urutanField . '" data-type="checkbox">
                                    delete
                                </a>
                            </div>
                            <div>
                                <fieldset class="checkbox">
                                    <label class="w-100">
                                        <input type="checkbox" data-checkbox-indicator has-change="false" data-id="label-checkbox-field-' . $urutanField . '"
                                            name="checkbox-' . $urutanField . '" value="i am unchecked Checkbox ' . $urutanField . '">
                                        <span class="ms-3" data-label-checkbox has-change="false" data-target="label-checkbox-field-' . $urutanField . '">i am unchecked Checkbox ' . $urutanField . '</span>
                                        <input type="text" id="label-checkbox-field-' . $urutanField . '" data-label-input data-checkbox
                                            data-type="checkbox" data-name="label-checkbox-field-' . $urutanField . '" has-change="false"
                                            value="i am unchecked Checkbox ' . $urutanField . '" class="no-border border-bottom w-100" hidden>
                                    </label>
                                </fieldset>
                            </div>
                        </div>';
                break;
        }

        $data = [
            'html' => $html,
            'layout' => $urutanLayout,
            'section' => $urutanSection,
            'script' => $script,
            'countTextArea' => $urutanField
        ];

        return json_encode($data);
    }

    public function getOption(Request $request)
    {
        $validate = DB::table('option_value')->where('id_option_group', $request->param)->get();
        if ($validate) {
            $html = '<table class="table" id="tb-opsi">
                        <thead>
                            <tr>
                                <th>Value</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="append-opsi">';

            foreach ($validate as $value) {
                if ($value->placeholder == 'True') {
                    $html .= '<tr>
                                    <td>
                                        <input type="text" id="option-value" data-val-opt="' . $value->id . '"  data-target-input="' . $request->target . '" class="form-control" value="' . $value->value . '">
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success more-opsi" data-option-group="' . $request->param . '" data-target-input="' . $request->target . '">+</a>
                                    </td>
                                </tr>';
                } else {
                    $dataVal = $value->value == NULL ? ' ' : $value->value;
                    $html .= '<tr>
                                <td>
                                    <input type="text" id="option-value" data-val-opt="' . $value->id . '"  data-target-input="' . $request->target . '" class="form-control" value="' . $dataVal . '">
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger del-opsi" data-val-opt="' . $value->id . '">-</a>
                                </td>
                            </tr>';
                }
            }

            $html .= '</tbody>
                    </table>';

            return json_encode($html);
        }
    }

    public function moreOption(Request $request)
    {
        $id_val_opt = DB::table('option_value')->insertGetId([
            'id_option_group' => $request->param,
            'placeholder' => 'False'
        ]);

        return json_encode($id_val_opt);
    }

    public function submitOption(Request $request)
    {
        $val = $request->val;
        $id = $request->id;
        $html = '';

        for ($i = 0; $i < count($val); $i++) {
            DB::table('option_value')->where('id', $id[$i])->update([
                'value' => $val[$i]
            ]);

            $html .= '<option value="' . $val[$i] . '">' . $val[$i] . '</option>';
        }

        $data = [
            'success' => [
                'html' => $html
            ]
        ];

        return json_encode($data);
    }

    public function delOption(Request $request)
    {
        DB::table('option_group')->where('id', $request->param)->delete();
        DB::table('option_value')->where('id_option_group', $request->param)->delete();
        return json_encode(['success' => true]);
    }

    public function getRadio(Request $request)
    {
        $validate = DB::table('radio_value')->where('id_radio_group', $request->param)->get();
        if ($validate) {
            $html = '<table class="table" id="tb-opsi">
                    <thead>
                        <tr>
                            <th>Value</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="append-opsi">';
            foreach ($validate as $value) {
                if ($value->first == 'True') {
                    $html .= '<tr>
                                <td>
                                    <input type="text" id="radio-value" data-val-opt="' . $value->id . '" class="form-control" value="' . $value->value . '">
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-success more-radio" data-radio-group="' . $value->id_radio_group . '">+</a>
                                </td>
                            </tr>';
                } else {
                    $html .= '<tr>
                                <td>
                                    <input type="text" id="radio-value" data-val-opt="' . $value->id . '" class="form-control" value="' . $value->value . '">
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger del-radio" data-radio-group="' . $value->id_radio_group . '">-</a>
                                </td>
                            </tr>';
                }
            }
            $html .= '</tbody>
                    </table>';
        }
        return json_encode($html);
    }

    public function renameField(Request $request)
    {
        $validasi = DB::table('form_field')->where('id', $request->id)->first();
        if ($validasi) {
            DB::table('form_field')->where('id', $request->id)->update([
                'field_name' => $request->name,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true]);
    }

    public function delField(Request $request)
    {
        $validasi = DB::table('form_field')->where('id', $request->id)->first();
        if ($validasi) {
            DB::table('form_field')->where('id', $request->id)->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true]);
    }

    // area setting form
    public function moreApprover()
    {
        $approver = DB::table('users')->where('role', 'user')->where('is_mapping', 'true')->get();
        $page = DB::table('menu')->where('status', 'active')->where('page', 'Approver')->whereNotIn('parent', ['0'])->whereNull('id_html_form')->get();
        $html = '<tr>
                    <td><input type="text" name="approver-name[]" class="form-control"></td>
                     <td>
                         <select name="user-approver[]" id="" class="form-control">
                             <option value="">--Select Approver--</option>';
        foreach ($approver as $a) {
            $html .= '<option value="' . $a->id . '">' . $a->name . '</option>';
        }
        $html .= '</select>
                     </td>
                     <td>
                         <select name="page-approver[]" id="" class="form-control">
                             <option value="">--Select Page Approver--</option>';
        foreach ($page as $p) {
            $html .= '<option value="' . $p->id . '">' . $p->name . '</option>';
        }
        $html .= '</select>
                     </td>
                     <td>
                         <a href="javascript:void(0)" class="btn btn-danger del-approver">-</a>
                     </td>
                 </tr>';

        return response()->json(['data' => $html]);
    }

    public function getpageApprover(Request $request)
    {
        $page = DB::table('menu')->where('parent', $request->parent)->where('page', 'Approver')->whereNotIn('parent', ['0'])->whereNull('id_html_form')->get();
        return response()->json(['data' => $page]);
    }

    public function preview(Request $request)
    {
        $data = [
            'selected' => 'preview',
            'html' => DB::table('html_form')->where('id', $request->form)->first()
        ];

        return view('pages/formbuilder/preview', $data);
    }
}
