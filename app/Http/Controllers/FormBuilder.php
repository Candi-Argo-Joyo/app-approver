<?php

namespace App\Http\Controllers;

use App\Helpers\FormBuilder as HelpersFormBuilder;
use App\Helpers\LogActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormBuilder extends Controller
{
    public function index()
    {
        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
        $data = [
            'forms' => DB::table('html_form')->orderBy('id', 'desc')->get()
        ];
        return view('pages/formbuilder/index', $data);
    }

    public function addValidation(Request $request)
    {
        $length = $request->validation_length;
        $users = User::where('is_mapping', 'true')->whereIn('role', ['manager', 'validator', 'user'])->get();

        $select = '';
        foreach ($users as $user) {
            $select .= '<option value="' . $user->id . '">' . $user->name . ' [' . $user->jabatan_name . ']</option>';
        }

        $html = HelpersFormBuilder::htmlValidation($length, $select);
        return response()->json(['html' => $html]);
    }

    public function add(Request $request)
    {
        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');

        $html = isset($request->form) ? DB::table('html_form')->where('id', $request->form)->first() : DB::table('html_form')->where('status', 'draft')->first();

        $data = [
            'selected' => 'form_builder',
            'html' =>  $html,
            'page' =>  HelpersFormBuilder::dataAdd($request)['page'],
            'selected_page' => isset($request->form) ? HelpersFormBuilder::dataAdd($request)['selected_page'] : '',
            'report' => isset($request->form) ? HelpersFormBuilder::dataAdd($request)['selected_report'] : '',
            'user' => isset($request->form) ? DB::table('users')->where('role', 'manager')->where('is_mapping', 'true')->get() : '',
            'approver' => isset($request->form) ? DB::table('menu')->where('id_html_form', $request->form)->where('page', 'Approver')->get() : '',
            // 'selected_approver' => isset($request->form) ? HelpersFormBuilder::dataAdd($request)['selected_approver'] : '',
            // 'selected_validator' => isset($request->form) ? HelpersFormBuilder::dataAdd($request)['selected_validator'] : '',
            // 'menu_validator' => isset($request->form) ? HelpersFormBuilder::dataAdd($request)['menu_selected_validator'] : '',
            'group_item' => DB::table('group_item')->get()
        ];

        return view('pages/formbuilder/addform', $data);
    }

    public function getReportApproval(Request $request)
    {
        $report = DB::table('menu')->where('id_html_form', $request->param_html)->where('parent', $request->parent)->where('page', 'Report')->first();
        $approver = DB::table('menu')->where('id_html_form', $request->param_html)->where('parent', $request->parent)->where('page', 'Approver')->first();

        if ($report || $approver) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'report' => $report,
                    'approver' => $approver
                ]
            ]);
        }
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

            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
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
        // var_dump($request);
        // exit;
        if (isset($request->html_preview)) {

            // untuk mengecek apakah ada yang sama dengan value
            $validator = Validator::make(
                $request->all(),
                [
                    'set_page' => 'required|exists:menu,id',
                    'report_page' => 'required|exists:menu,id',
                    'approver_page' => 'required|exists:menu,id',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ]);
            }
            //    

            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');

            // mengaktifkan page menu berdasarkan form builder baru
            DB::table('menu')->where('id', $request->set_page)->update([
                'id_html_form' => $request->param_html,
                'is_use' => 'yes'
            ]);

            DB::table('menu')->where('id', $request->report_page)->update([
                'id_html_form' => $request->param_html,
                'is_use' => 'yes'
            ]);

            DB::table('menu')->where('id', $request->approver_page)->update([
                'id_html_form' => $request->param_html,
                'is_use' => 'yes'
            ]);

            // save html
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
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            DB::table('menu')->where('id_html_form', $request->param)->update([
                'id_html_form' => NULL,
                'is_use' => 'no'
            ]);

            DB::table('html_form')->where('id', $request->param)->delete();
            DB::table('form_layout')->where('id_html_form', $request->param)->delete();
            DB::table('form_field')->where('id_html_form', $request->param)->delete();
            DB::table('approver_for_form')->where('id_html_form', $request->param)->delete();
            DB::table('insert_form')->where('id_html_form', $request->param)->delete();
            DB::table('insert_item_form')->where('id_html_form', $request->param)->delete();
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
                    'jenis' => 'column-3',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = '<div class="mt-4" data-count-layout>
                                <div class="d-flex align-items-end flex-column">
                                    <a href="javascript:void(0)" id-layout="' . $id_layout . '" data-no-urut="layout-' . $layoutLength . '"  class="btn btn-danger del-layout">x</a>
                                </div>
                                <div
                                    class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray bg-layout" data-css data-form-final>
                                    <div class="row" id="layout-' . $layoutLength . '">
                                        <div class="col-md-12" id="dom-title"></div>
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
                    'original_name' => 'title ' . $urutanField,
                    'type' => 'title',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, NULL);
                break;
            case 'text':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'text-field-' . $urutanField,
                    'original_name' => 'text field ' . $urutanField,
                    'type' => 'text',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, NULL);
                break;
            case 'number':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'number-field-' . $urutanField,
                    'original_name' => 'number field ' . $urutanField,
                    'type' => 'number',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, NULL);
                break;
            case 'date':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'date-field-' . $urutanField,
                    'original_name' => 'date field ' . $urutanField,
                    'type' => 'date',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, NULL);
                break;
            case 'file upload':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'file-field-' . $urutanField,
                    'original_name' => 'file field ' . $urutanField,
                    'type' => 'file',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, NULL);
                break;
            case 'textarea':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'textarea-field-' . $urutanField,
                    'original_name' => 'textarea field ' . $urutanField,
                    'type' => 'textarea',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, NULL);
                break;
            case 'select-option':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'select-option-field-' . $urutanField,
                    'original_name' => 'select option field ' . $urutanField,
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

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, NULL);
                break;
            case 'radio-button':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'default-radio-buttons-' . $urutanField,
                    'original_name' => 'default radio buttons ' . $urutanField,
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

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), $id_radio, NULL);
                break;
            case 'check-box':
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'checkbox-' . $urutanField,
                    'original_name' => 'checkbox ' . $urutanField,
                    'type' => 'check-box',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, NULL);
                break;

            case 'item';
                $idField = DB::table('form_field')->insertGetId([
                    'id_form_layout' => $request->id_layout,
                    'id_html_form' => $request->id_html,
                    'field_name' => 'item-' . $urutanField,
                    'original_name' => 'Data pengajuan pembelian barang ' . $urutanField,
                    'type' => 'item',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $id_group = $request->groupItems;
                $html = HelpersFormBuilder::htmlField(NULL, NULL, NULL, $urutanField, $idField, $request->input('type'), NULL, $id_group);
        }

        $data = [
            'html' => $html,
            'layout' => $urutanLayout,
            'section' => $urutanSection,
            'script' => $script,
            'type' => 'item',
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
                'original_name' => $request->original_name,
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
    public function moreApprover(Request $request)
    {
        if (Auth::user()->role == 'administrator') {
            $approver = DB::table('users')->where('role', 'manager')->where('id_divisi', $request->divisi)->where('is_mapping', 'true')->get();
        } else {
            $approver = DB::table('users')->where('role', 'manager')->where('id_divisi', Auth::user()->id_divisi)->where('is_mapping', 'true')->get();
        }
        // dd($approver);
        // exit;

        if (!$approver->isEmpty()) {
            $page =  DB::table('menu')->where('parent', $request->parent)->where('page', 'Approver')->where('status', 'active')->whereNull('id_html_form')->get();

            $html = '<tr>
                    <td>
                        <input type="text" name="approver-name[]" class="form-control">
                        <div id="invalid-page-approver" class="invalid-feedback">
                        </div>
                    </td>
                     <td>
                         <select name="page-approver[]" id="" class="form-control">
                             <option value="">--Select Page Approver--</option>';
            foreach ($page as $p) {
                $html .= '<option value="' . $p->id . '">' . $p->name . ' [user:]</option>';
            }
            $html .= '</select>
                     <div id="invalid-page-approver" class="invalid-feedback">
                     </div>
                     </td>
                     <td>
                         <a href="javascript:void(0)" class="btn btn-danger del-approver">-</a>
                     </td>
                 </tr>';
            return response()->json(['data' => $html, 'report' => $page]);
        }

        $divisi = DB::table('division')->where('id', $request->divisi)->first();
        return response()->json(['error' => 'Manager with <strong style="color:red">' . $divisi->name . ' division</strong> not found']);
    }

    public function getpageApprover(Request $request)
    {
        if (isset($request->is_edit)) {
            $base = DB::table('menu')->where('id_html_form', $request->is_edit)->where('parent', $request->parent)->where('page', 'Entry Page')->first();
            if ($base) {
                $page = DB::table('menu')->where('parent', $request->parent)->where('page', 'Approver')->get();
                $validator = DB::table('menu')->where('parent', $request->parent)->where('page', 'Validator')->first();
                $report = DB::table('menu')->where('parent', $request->parent)->where('page', 'Report')->get();
            } else {
                $page = DB::table('menu')->where('parent', $request->parent)->where('page', 'Approver')->whereNull('id_html_form')->get();
                $validator = DB::table('menu')->where('parent', $request->parent)->where('page', 'Validator')->whereNull('id_html_form')->first();
                $report = DB::table('menu')->where('parent', $request->parent)->where('page', 'Report')->whereNull('id_html_form')->get();
            }
        } else {
            $page = DB::table('menu')->where('parent', $request->parent)->where('page', 'Approver')->whereNull('id_html_form')->get();
            $validator = DB::table('menu')->where('parent', $request->parent)->where('page', 'Validator')->whereNull('id_html_form')->first();
            $report = DB::table('menu')->where('parent', $request->parent)->where('page', 'Report')->whereNull('id_html_form')->get();
        }

        if (!$report || !$page) {
            return response()->json([
                'error' => [
                    'msg' => 'page not found',
                ]
            ]);
        }

        return response()->json([
            'success' => [
                'data' => $page,
                'validator' => $validator,
                'report' => $report
            ]
        ]);
    }

    public function preview(Request $request)
    {
        $data = [
            'selected' => 'preview',
            'html' => DB::table('html_form')->where('id', $request->form)->first()
        ];

        return view('pages/formbuilder/preview', $data);
    }

    public function settingGetfield(Request $request)
    {
        $validate_field = DB::table('form_field')->where('id_html_form', $request->param)->where('type', 'number')->get();
        if (!$validate_field) {
            return response()->json([
                'error' => ['msg' => 'Field type number not found']
            ]);
        }

        $cek_exist_validation = DB::table('validation_group')->where('id_html_form', $request->param)->first();
        if ($cek_exist_validation) {
            $users = User::where('is_mapping', 'true')->whereIn('role', ['manager', 'validator', 'user'])->get();
            $data_validation = DB::table('validation')->where('id_validation_group', $cek_exist_validation->id)->get();

            return response()->json([
                'success' => [
                    'exist_validation' => [
                        'html' => HelpersFormBuilder::existValidation($users, $data_validation),
                        'selected_field' => $cek_exist_validation->id_form_field
                    ],
                    'field' => $validate_field
                ]
            ]);
        }

        return response()->json([
            'success' => [
                'field' => $validate_field
            ]
        ]);
    }

    public function settingSaveApprover(Request $request)
    {
        $group = $request->group;

        $validate = [];
        $step = '';
        $user = '';

        if (!$request->group) {
            array_push(
                $validate,
                ['condition' => 'Conditional form cannot be empty']
            );

            return response()->json([
                'error' => $validate
            ]);
        }

        if (!$request->simultan) {
            array_push(
                $validate,
                ['simultan' => 'Simultan tidak boleh kosong']
            );

            return response()->json([
                'error' => $validate
            ]);
        }

        for ($i = 0; $i < count($group); $i++) {
            $count = count($request->input("step_$group[$i]"));
            for ($j = 0; $j < $count; $j++) {
                if ($request->input("step_$group[$i]")[$j] == $step) {
                    array_push(
                        $validate,
                        ['step' => 'Step tidak boleh sama']
                    );
                }

                if ($request->input("step_$group[$i]")[$j] == '') {
                    array_push(
                        $validate,
                        ['step' => 'Step tidak boleh kosong']
                    );
                }

                if ($request->input("name_$group[$i]")[$j] == '') {
                    array_push(
                        $validate,
                        ['name' => 'Name tidak boleh kosong']
                    );
                }


                // if ($request->input("select_required_$group[$i]")[$j] == '') {
                //     array_push(
                //         $validate,
                //         ['required' => 'Required tidak boleh kosong']
                //     );
                // }

                $cek_user = DB::table('users')->where('id', $request->input('select_' . $group[$i])[$j])->first();
                if (!$cek_user) {
                    array_push(
                        $validate,
                        ['user' => 'User tidak ditemukan']
                    );
                }

                if ($request->input("select_$group[$i]")[$j] == $user) {
                    array_push(
                        $validate,
                        ['user' => 'User tidak boleh sama']
                    );
                }

                if ($request->input("select_$group[$i]")[$j] == '') {
                    array_push(
                        $validate,
                        ['user' => 'User tidak boleh kosong']
                    );
                }

                $step = $request->input("step_$group[$i]")[$j];
                $user = $request->input("select_$group[$i]")[$j];
            }
        }

        if (count($validate) != 0) {
            return response()->json([
                'error' => $validate
            ]);
        }

        // return response()->json([
        //     'success' => 'ok'
        // ]);

        $cek_exist_validation = DB::table('validation_group')->where('id_html_form', $request->form_id)->first();
        if ($cek_exist_validation) {
            DB::table('validation_group')->where('id_html_form', $request->form_id)->delete();
            DB::table('validation')->where('id_validation_group', $cek_exist_validation->id)->delete();
        }

        for ($i = 0; $i < count($group); $i++) {
            $id = DB::table('validation_group')->insertGetId([
                'id_html_form' => $request->form_id,
                'id_form_field' => $request->field,
                'simultan' => $request->simultan,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $count = count($request->input("step_$group[$i]"));
            for ($j = 0; $j < $count; $j++) {
                $cek_user = DB::table('users')->where('id', $request->input('select_' . $group[$i])[$j])->first();
                DB::table('validation')->insert([
                    'id_html_form' => $request->form_id,
                    'id_validation_group' => $id,
                    'id_user' => $request->input('select_' . $group[$i])[$j],
                    'step' => $request->input('step_' . $group[$i])[$j],
                    'name' => $request->input('name_' . $group[$i])[$j],
                    // 'required' => $request->input('select_required_' . $group[$i])[$j] == 'true' ? 'yes' : 'no',
                    'name_user' => $cek_user->name,
                    'more_than' => $request->input('more_than_' . $group[$i])[$j],
                    'less_than' => $request->input('less_than_' . $group[$i])[$j],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return response()->json([
            'success' => 'Condition form successfully created'
        ]);
    }

    public function renamefielditems(Request $request)
    {
        $id = $request->id;
        $no = 1;
        for ($i = 0; $i < count($request->id); $i++) {
            DB::table('form_field')->where('id', $id[$i])->update([
                'field_name' => 'item' . $no
            ]);

            $no++;
        }

        return response()->json(['success' => true]);
    }
}
