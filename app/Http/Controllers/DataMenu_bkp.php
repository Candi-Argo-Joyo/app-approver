<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataMenu extends Controller
{
    public function index()
    {
        return view('pages/datamenu/index');
    }

    public function getGroupAll()
    {
        $data = DB::table('menu_group')->get();
        return response()->json(['data' => $data, 'count_group' => count($data)]);
    }

    public function saveGroup(Request $request)
    {
        if ($request->param) {
            $validator = Validator::make(
                $request->all(),
                [
                    'group' => 'required',
                    'param' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                ]
            );
        } else {
            $validator = Validator::make($request->all(), [
                'group' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        if ($request->param) {
            DB::table('menu_group')->where('id', $request->param)->update([
                'name' => strtoupper($request->group),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('menu_group')->insert([
                'name' => strtoupper($request->group),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return response()->json(['success' => 'Group created successfully.']);
    }

    public function getOneGroup(Request $request)
    {
        $validasi = DB::table('menu_group')->where('id', $request->param)->first();
        if ($validasi) {
            return response()->json(['success' => $validasi]);
        }
        return response()->json(['error' => 'Group find not found.']);
    }

    public function delGroup(Request $request)
    {
        $validasi = DB::table('menu_group')->where('id', $request->param)->first();
        if ($validasi) {
            DB::table('menu_group')->where('id', $request->param)->delete();
            return response()->json(['success' => 'Group delete successfully.']);
        }
        return response()->json(['error' => 'Group delete error.']);
    }

    public function saveMenu(Request $request)
    {
        if ($request->type == 'dropdown') {
            $validator = Validator::make(
                $request->all(),
                [
                    'id_group' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                    'name' => 'required',
                    'type' => 'required',
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'id_group' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                    'name' => 'required',
                    'type' => 'required',
                    'parent' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }
        DB::beginTransaction();
        try {
            if ($request->type == 'dropdown') {
                if ($request->param_menu) {
                    DB::table('menu')->where('id', $request->param_menu)->update([
                        'id_menu_group' => $request->id_group,
                        'name' => $request->name,
                        'type' => 'dropdown',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    DB::table('menu')->insert([
                        'id_menu_group' => $request->id_group,
                        'name' => $request->name,
                        'type' => 'dropdown',
                        'parent' => '0',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            } else {
                if ($request->param_menu) {
                    DB::table('menu')->where('id', $request->param_menu)->update([
                        'id_menu_group' => $request->id_group,
                        'name' => $request->name,
                        'type' => 'singgle',
                        'parent' => $request->parent,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    DB::table('menu')->insert([
                        'id_menu_group' => $request->id_group,
                        'name' => $request->name,
                        'type' => 'singgle',
                        'parent' => $request->parent,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Menu saved successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => ['msg' => 'Menu failed to save']]);
        }
    }

    public function getParentMenu(Request $request)
    {
        $menu = DB::table('menu')->where('parent', '0')->where('id_menu_group', $request->id_group)->get();
        return response()->json(['data' => $menu]);
    }

    public function getAllMenu()
    {
        $group = DB::table('menu_group')->get();
        $html = '<ul class="list-group">';
        $parent = [];

        foreach ($group as $g) {
            $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>' . $g->name . '</strong>
                      </li>';
            $parent = DB::table('menu')->where('id_menu_group', $g->id)->where('parent', '0')->get();
            foreach ($parent as $p) {
                $html .= '<li class="ml-4 list-group-item d-flex justify-content-between align-items-center"
                                    style="margin-left: 30px">
                                    <span class="d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text feather-icon"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                        ' . $p->name . '
                                    </span>
                                    <span>
                                        <a href="javascript:void(0)" class="badge bg-warning badge-pill">edit</a>
                                        <a href="javascript:void(0)" class="badge bg-danger badge-pill">delete</a>
                                    </span>
                                </li>';
                $menu = DB::table('menu')->where('parent', $p->id)->get();
                foreach ($menu as $m) {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="margin-left: 60px">
                                    <a href="javascript:void(0)">' . $m->name . '</a>
                                    <span>
                                        <a href="javascript:void(0)" class="badge bg-warning badge-pill">edit</a>
                                        <a href="javascript:void(0)" class="badge bg-danger badge-pill">delete</a>
                                    </span>
                                </li>';
                }
            }
        }
        $html .= '</ul>';
        return response()->json(['html' => $html, 'count_group' => count($group), 'count_menu' => count($parent)]);
    }

    public function getSinggleMenu()
    {
        $menu = DB::table('menu')->where('parent', '1')->get();
        return response()->json(['data' => $menu]);
    }

    public function sidebar()
    {
        $html = '<li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="' . route('dashboard') . '" aria-expanded="false">
                        <i class="icon-home font-700"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>';
        if (Auth::user()->role == 'administrator') {
            $html .= '<li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Master</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow"
                        href="javascript:void(0)" aria-expanded="false">
                            <i class="icon-notebook font-700"></i>
                        <span class="hide-menu">Master Data
                        </span>
                    </a>
                    <ul aria-expanded="false"
                        class="collapse  first-level base-level-line">
                        <li class="sidebar-item">
                            <a href="' . route('poistion') . '" class="sidebar-link">
                                <span class="hide-menu"> Position </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('division') . '" class="sidebar-link">
                                <span class="hide-menu"> Division </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('mappingusers') . '" class="sidebar-link">
                                <span class="hide-menu"> Maping User </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('digitalAsign') . '" class="sidebar-link">
                                <span class="hide-menu"> Digital Assign </span>
                            </a>
                        </li>
                        <li
                            class="sidebar-item">
                            <a href="' . route('formBuilder') . '"
                                class="sidebar-link">
                                <span class="hide-menu"> Form Builder </span>
                            </a>
                        </li>
                    </ul>
            </li>';
            $html .= '<li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Credit</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow"
                        href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-notebook font-700"></i>
                        <span class="hide-menu">Credit Transaction
                        </span>
                    </a>
                    <ul aria-expanded="false"
                        class="collapse first-level base-level-line">
                        <li class="sidebar-item">
                            <a href="' . route('entryKredit') . '" class="sidebar-link">
                                <span class="hide-menu"> Entry Kredit </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('knowledge') . '" class="sidebar-link">
                                <span class="hide-menu"> Acknowledge by </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('approver1') . '" class="sidebar-link">
                                <span class="hide-menu"> Approver 1 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('approver2') . '" class="sidebar-link">
                                <span class="hide-menu"> Approver 2 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('approver3') . '" class="sidebar-link">
                                <span class="hide-menu"> Approver 3 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('dataKredit') . '" class="sidebar-link">
                                <span class="hide-menu"> Data Kredit </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Memo</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="' . route('createMemo') . '" aria-expanded="false">
                        <i class="icon-pencil font-700"></i>
                        <span class="hide-menu">Create
                            Memo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="' . route('approvalMemo') . '" aria-expanded="false">
                        <i class="icon-check font-700"></i>
                        <span class="hide-menu">Approval
                            Memo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="' . route('dataMemo') . '" aria-expanded="false">
                        <i class="icon-notebook font-700"></i>
                        <span class="hide-menu">Data Memo</span>
                    </a>
            </li>';
        } else {
            if (Auth::user()->id_divisi != NULL) {
                $html .= '<li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Credit</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow"
                        href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-notebook font-700"></i>
                        <span class="hide-menu">Credit Transaction
                        </span>
                    </a>
                    <ul aria-expanded="false"
                        class="collapse first-level base-level-line">
                        <li class="sidebar-item">
                            <a href="' . route('entryKredit') . '" class="sidebar-link">
                                <span class="hide-menu"> Entry Kredit </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('knowledge') . '" class="sidebar-link">
                                <span class="hide-menu"> Acknowledge by </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('approver1') . '" class="sidebar-link">
                                <span class="hide-menu"> Approver 1 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('approver2') . '" class="sidebar-link">
                                <span class="hide-menu"> Approver 2 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('approver3') . '" class="sidebar-link">
                                <span class="hide-menu"> Approver 3 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="' . route('dataKredit') . '" class="sidebar-link">
                                <span class="hide-menu"> Data Kredit </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Memo</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="' . route('createMemo') . '" aria-expanded="false">
                        <i class="icon-pencil font-700"></i>
                        <span class="hide-menu">Create
                            Memo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="' . route('approvalMemo') . '" aria-expanded="false">
                        <i class="icon-check font-700"></i>
                        <span class="hide-menu">Approval
                            Memo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="' . route('dataMemo') . '" aria-expanded="false">
                        <i class="icon-notebook font-700"></i>
                        <span class="hide-menu">Data Memo</span>
                    </a>
                </li>';

                $group = DB::table('menu_group')->get();
                foreach ($group as $g) {
                    $html .= '<li class="list-divider"></li>
                      <li class="nav-small-cap"><span class="hide-menu">' . $g->name . '</span></li>
                      <li class="sidebar-item">';

                    $parent = DB::table('menu')->where('id_menu_group', $g->id)->where('parent', '0')->get();
                    foreach ($parent as $p) {
                        $html .= '<a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                              <i class="icon-notebook font-700"></i>
                              <span class="hide-menu">' . $p->name . ' </span>
                          </a>
                          <ul aria-expanded="false" class="collapse first-level base-level-line">';
                        $menu = DB::table('menu')->where('parent', $p->id)->get();

                        foreach ($menu as $m) {
                            $html .= '<li class="sidebar-item">
                                    <a href="#" class="sidebar-link">
                                        <span class="hide-menu"> ' . $m->name . ' </span>
                                    </a>
                                </li>';
                        }
                        $html .= '</ul>';
                    }
                    $html .= '</li>';
                }
            }
        }

        $data = [
            'data' => $html,
            'script' => "<script data-sidebar src=" . asset('dist/js/sidebarmenu.js') . "></script>"
        ];

        return json_encode($data);
    }
}
