<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Request;

class FormBuilderBkp
{
    public static function dataAdd($request)
    {
        if (Auth::user()->role == 'administrator') {
            $data['page'] = DB::table('menu')->where('status', 'active')->where('page', 'Entry Page')->get();
        } else {
            $data['page'] = DB::table('menu')->where('status', 'active')->where('page', 'Entry Page')->where('id_divisi', Auth::user()->id_divisi)->get();
        }

        $data['selected_page'] = DB::table('menu')->where('status', 'active')->where('id_html_form', $request->form)->where('page', 'Entry Page')->first();
        $data['selected_report'] = DB::table('menu')->where('status', 'active')->where('id_html_form', $request->form)->where('page', 'Report')->get();
        // $data['selected_approver'] = DB::table('approver_for_form')->where('type', 'Approver')->where('id_html_form', $request->form)->get();
        // $data['selected_validator'] = DB::table('approver_for_form')->where('type', 'Validator')->where('id_html_form', $request->form)->first();

        // if ($data['selected_validator']) {
        //     $data['menu_selected_validator'] = DB::table('menu')->where('id', $data['selected_validator']->id_menu)->where('id_html_form', $request->form)->first();
        // } else {
        //     $data['menu_selected_validator'] = [];
        // }

        return $data;
    }

    public static function htmlValidation($length, $select)
    {
        $html = '<div class="form-group mb-3" id="validation-' . $length . '">
                            <div class="d-flex flex-row justify-content-between">
                                <label class="form-label" for="name">Validation ' . $length . '</label>
                                <div class="justify-items-center">
                                    <a href="javascript:;" class="badge bg-danger delete-validation" data-table="validation-' . $length . '">delete</a>
                                </div>
                            </div>
                            <input type="text" name="group[]" value="table_' . $length . '" hidden>
                            <table validation class="table border table-striped table-bordered text-nowrap" id="table_' . $length . '">
                                <thead>
                                    <tr style="vertical-align: middle;">
                                        <td rowspan="2">#</td>
                                        <td rowspan="2">Step</td>
                                        <td rowspan="2">Required</td>
                                        <td rowspan="2">User Approve</td>
                                        <td colspan="2" class="p-0">
                                            <table style="text-align: center;border-color: #e8eef3;"
                                                class="w-100 table-bordered">
                                                <tr>
                                                    <td colspan="2" class="th">Condition</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1 w-50">(Rp. >)</td>
                                                    <td class="td2 w-50">(Rp. <) </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td rowspan="2">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span id="table-' . $length . '-row">1</span></td>
                                        <td><input td-count-table-' . $length . ' type="number" name="step_table_' . $length . '[]" class="form-control bg-white" placeholder="1"></td>
                                        <td>
                                            <select name="select_required_table_' . $length . '[]" id="" class="form-control bg-white">
                                                <option value="">--Select Required--</option>
                                                <option value="true">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="select_table_' . $length . '[]" id="" class="form-control bg-white">
                                                <option value="">--Select User--</option>
                                                ' . $select . '
                                            </select>
                                        </td>
                                        <td><input type="text" value="0" class="form-control bg-white" name="more_than_table_' . $length . '[]"></td>
                                        <td><input type="text" value="0" class="form-control bg-white" name="less_than_table_' . $length . '[]"></td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-primary add-more" data-table="table_' . $length . '">+</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';
        return $html;
    }

    public static function existValidation($users, $data_validation)
    {
        $html = '<div class="form-group mb-3" id="validation-1">
                            <div class="d-flex flex-row justify-content-between">
                                <label class="form-label" for="name">Validation 1</label>
                                <div class="justify-items-center">
                                    <a href="javascript:;" class="badge bg-danger delete-validation" data-table="validation-1">delete</a>
                                </div>
                            </div>
                            <input type="text" name="group[]" value="table_1" hidden>
                            <table validation class="table border table-striped table-bordered text-nowrap" id="table_1">
                                <thead>
                                    <tr style="vertical-align: middle;">
                                        <td rowspan="2">#</td>
                                        <td rowspan="2">Step</td>
                                        <td rowspan="2">Required</td>
                                        <td rowspan="2">User Approve</td>
                                        <td colspan="2" class="p-0">
                                            <table style="text-align: center;border-color: #e8eef3;"
                                                class="w-100 table-bordered">
                                                <tr>
                                                    <td colspan="2" class="th">Condition</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1 w-50">(Rp. >)</td>
                                                    <td class="td2 w-50">(Rp. <) </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td rowspan="2">Action</td>
                                    </tr>
                                </thead>
                                <tbody>';
        $no = 1;
        foreach ($data_validation as $da) {
            $html .= '<tr>
                                        <td><span id="table-1-row">' . $no . '</span></td>
                                        <td><input td-count-table-1 type="number" value="' . $da->step . '" name="step_table_1[]" class="form-control bg-white" placeholder="1"></td>
                                        <td>
                                            <select name="select_required_table_1[]" id="" class="form-control bg-white">
                                                <option value="">--Select Required--</option>
                                                <option value="true"' . ($da->required == "yes" ? " selected" : "") . '>Yes</option>
                                                <option value="false"' . ($da->required == "no" ? " selected" : "") . '>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="select_table_1[]" id="" class="form-control bg-white">
                                                <option value="">--Select User--</option>';
            foreach ($users as $us) {
                $html .= '<option value="' . $us->id . '" ' . ($da->id_user == $us->id ? " selected" : "") . '>' . $us->name . ' [' . $us->jabatan_name . ']</option>';
            }

            $html .= '</select>
                                        </td>
                                        <td><input type="text" value="' . $da->more_than . '" class="form-control bg-white" name="more_than_table_1[]"></td>
                                        <td><input type="text" value="' . $da->less_than . '" class="form-control bg-white" name="less_than_table_1[]"></td>
                                        <td>';
            if ($no == 1) {
                $html .= '<a href="javascript:;" class="btn btn-primary add-more" data-table="table_1">+</a>';
            } else {
                $html .= '<a href="javascript:;" class="btn btn-danger dell-more" data-table="table_1">-</a>';
            }
            $html .= '</td>
                                    </tr>';
            $no++;
        }

        $html .= '</tbody>
                            </table>
                        </div>';
        return $html;
    }

    public static function htmlField($urutanLayout, $urutanSection, $id_select, $urutanField, $idField, $type, $id_radio, $id_group)
    {
        $field = [
            'title' => '<div class="d-flex flex-row justify-content-between gap-2 mb-3" data-field-label id="title-' . $urutanField . '">
                            <div class="w-100">
                                <input data-label-input id-field="' . $idField . '" has-change="false" data-name="label-title-field-' . $urutanField . '" data-label-title data-title="true"
                                    type="text" value="Your title here ' . $urutanField . '" class="no-border w-100 input-title" data-type="title"
                                    id="label-title-field-' . $urutanField . '" hidden>
                                <label data-field-label has-change="false" data-target="label-title-field-' . $urutanField . '" class="h5">Your title here ' . $urutanField . '</label>
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
                        </div>', //field type title
            'text' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-text id="text-' . $urutanField . '" data-css>
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
                                    <input name="label[]" data-label-input id-field="' . $idField . '" data-label-text type="text" has-change="false" value="Text Field ' . $urutanField . '" data-target-input="#text-field-' . $urutanField . '" class="no-border w-100" id="label-text-field-' . $urutanField . '" readonly="true">
                                </div>
                                <div class="col-sm-9">
                                    <input data-filed data-text class="form-control input-text" has-change="false" placeholder="Input Text Here..." type="text" name="text-field-' . $urutanField . '" id="text-field-' . $urutanField . '">
                                </div>
                            </div> 
                        </div>', //field type text
            'number' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-number id="number-' . $urutanField . '" data-css>
                            <div class="d-flex flex-row justify-content-end gap-2 mb-2" data-action>
                                <a href="javascript:void(0)" class="badge bg-warning" x-edit data-edit-number data-name="label-number-field-' . $urutanField . '">
                                    edit
                                </a>
                                <a href="javascript:void(0)" id-field="' . $idField . '" class="badge bg-danger del-fileld" data-delete-number data-target-delete="#number-' . $urutanField . '" data-type="number">
                                    delete
                                </a>
                            </div>
                            <div class="row justify-items-center">
                                <div class="col-sm-3 col-form-label">
                                    <input name="label[]" data-label-input id-field="' . $idField . '" data-label-number type="text" has-change="false" value="number Field ' . $urutanField . '" data-target-input="#number-field-' . $urutanField . '" class="no-border w-100" id="label-number-field-' . $urutanField . '" readonly="true">
                                </div>
                                <div class="col-sm-9">
                                    <input data-filed data-number class="form-control input-number" has-change="false" placeholder="Input number Here..." type="number" name="number-field-' . $urutanField . '" id="number-field-' . $urutanField . '">
                                </div>
                            </div> 
                        </div>', //field type number
            'date' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-date id="date-' . $urutanField . '" data-css>
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
                                    <input name="label[]" data-label-input id-field="' . $idField . '" data-label-date type="text" has-change="false" value="Date Field ' . $urutanField . '" data-target-input="#date-field-' . $urutanField . '" class="no-border w-100" id="label-date-field-' . $urutanField . '" readonly="true">
                                </div>
                                <div class="col-sm-9">
                                    <input data-filed data-date class="form-control input-date" type="date" has-change="false" name="date-field-' . $urutanField . '" id="date-field-' . $urutanField . '">
                                </div>
                            </div> 
                        </div>', //field type date
            'file upload' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-file id="file-' . $urutanField . '" data-css>
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
                                    <input name="label[]" data-label-input id-field="' . $idField . '" data-label-file type="text" has-change="false" value="File Field ' . $urutanField . '" data-target-input="#file-field-' . $urutanField . '" class="no-border w-100" id="label-file-field-' . $urutanField . '" readonly="true">
                                </div>
                                <div class="col-sm-9">
                                    <input data-filed data-file class="form-control input-file" type="file" has-change="false" name="file-field-' . $urutanField . '" id="file-field-' . $urutanField . '">
                                </div>
                            </div> 
                         </div>', //field type file upload
            'textarea' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-textarea id="textarea-' . $urutanField . '" data-css>
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
                                   <input name="label[]" data-label-input id-field="' . $idField . '" data-label-textarea type="text" has-change="false" value="Textarea Field ' . $urutanField . '" data-target-input="#textarea-field-' . $urutanField . '" class="no-border w-100" id="label-textarea-field-' . $urutanField . '" readonly="true">
                               </div>
                               <div class="col-sm-9">
                                    <textarea data-filed data-textarea class="form-control input-textarea" has-change="false" name="textarea-field-' . $urutanField . '" id="textarea-field-' . $urutanField . '"></textarea>
                               </div>
                            </div> 
                         </div>', //field type textarea
            'select-option' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3" data-field-select id="select-option-' . $urutanField . '" data-css>
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
                                    <input name="label[]" data-label-input id-field="' . $idField . '" data-label-select type="text" has-change="false" value="Select Field ' . $urutanField . '" data-target-input="#select-option-field-' . $urutanField . '" class="no-border w-100" id="label-select-field-' . $urutanField . '" readonly="true">
                               </div>
                               <div class="col-sm-9">
                                    <select data-filed select-option class="form-control select-option" has-change="false" name="select-option-field-' . $urutanField . '" id="select-option-field-' . $urutanField . '">
                                            <option>--Pilih--</option>
                                    </select>
                               </div> 
                            </div> 
                        </div>', //field type select-option
            'radio-button' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3"
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
                            <input name="label[]" data-label-input id-field="' . $idField . '" data-label-radio has-change="false" type="text"
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
                        </div>', //field type radio-button
            'check-box' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray mb-3"
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
                                        <input name="label[]" type="text" id="label-checkbox-field-' . $urutanField . '" data-label-input data-checkbox
                                            data-type="checkbox" data-name="label-checkbox-field-' . $urutanField . '" has-change="false"
                                            value="i am unchecked Checkbox ' . $urutanField . '" class="no-border border-bottom w-100" hidden>
                                    </label>
                                </fieldset>
                            </div>
                        </div>', //field type check-box
            'item' => '<div class="border-dashed-top border-dashed-bottom border-dashed-right border-dashed-left border-color-gray item mb-3"
                            data-field-text id="item-' . $urutanField . '" data-css>
                            <div class="d-flex justify-content-end">
                                <div class="d-flex gap-2 mb-2" data-action>
                                    <a href="javascript:void(0)" class="badge bg-warning" x-edit data-type="item"
                                        data-edit-title data-name="label-item-' . $urutanField . '">
                                        edit
                                    </a>
                                    <a href="javascript:void(0)" class="badge bg-danger del-fileld" data-delete-title
                                        id-field="' . $idField . '" data-target-delete="#item-' . $urutanField . '" data-type="item">
                                        delete
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex justify-item-between gap-2 mb-3">
                                <input name="label[]" data-label-input id-field="' . $idField . '" name-item data-name="item-' . $urutanField . '" data-type="item" has-change="false"
                                    value="Data pengajuan pembelian barang" class="no-border w-100" id="label-item-' . $urutanField . '"
                                    readonly="true">
                                <div>
                                    <a href="javascript:void(0)" class="badge bg-primary text-nowrap add-item" data-group="' . $id_group . '" data-id-table="item-' . $urutanField . '">
                                        Add Item
                                    </a>
                                </div>
                            </div>
                            <table class="table border table-striped table-bordered text-nowrap mb-0" id="item-' . $urutanField . '">
                                <thead>
                                    <tr>
                                        <td style="width:15px;">No</td>
                                        <td style="min-width:115px;">Item</td>
                                        <td style="width:15px;">Qty</td>
                                        <td>Price</td>
                                        <td>Total Amount</td>
                                        <td style="width:15px;">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="rm">
                                        <td colspan="6" class="text-center">No items selected</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-end">Total :</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>',
        ][$type];

        return $field;
    }
}
