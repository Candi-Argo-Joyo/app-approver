<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Request;

class FormBuilder
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
        $data['selected_approver'] = DB::table('approver_for_form')->where('id_html_form', $request->form)->get();

        return $data;
    }
}
