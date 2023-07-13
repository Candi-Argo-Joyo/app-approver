<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataMenu extends Controller
{
    public function index()
    {
        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');

        $data = [
            'divsi' => DB::table('division')->get(),
            'users' => DB::table('users')->where('role', 'manager')->get(),
            'users_v' => DB::table('users')->where('role', 'validator')->get()
        ];
        return view('pages/datamenu/index', $data);
    }

    public function saveMenu(Request $request)
    {
        if ($request->type == 'dropdown') {
            if ($request->param) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|unique:menu,name,' . $request->param,
                        'type' => 'required',
                    ]
                );
            } else {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|unique:menu,name',
                        'type' => 'required',
                    ]
                );
            }
        } else {
            if ($request->param) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|unique:menu,name,' . $request->param,
                        'type' => 'required',
                        'parent' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                    ]
                );
            } else {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|unique:menu,name',
                        'type' => 'required',
                        'parent' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                    ]
                );
            }
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        DB::beginTransaction();
        try {
            $parent = $request->type == 'dropdown' ? '0' : $request->parent;

            if ($request->param_menu) {
                DB::table('menu')->where('id', $request->param_menu)->update([
                    'name' => $request->name,
                    'slug' => preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($request->name))),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                DB::table('menu')->where('parent', $request->param_menu)->update([
                    'name_parent' => $request->name,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                DB::table('menu')->insert([
                    'name' => $request->name,
                    'slug' => preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($request->name))),
                    'type' => 'singgle',
                    'parent' => $parent,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            DB::commit();
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            return response()->json(['success' => 'Menu saved successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => ['msg' => 'Menu failed to save']]);
        }
    }

    public function editMenu(Request $request)
    {
        $validasi = DB::table('menu')->where('id', $request->param)->first();
        if ($validasi) {
            return response()->json([
                'success' => $validasi
            ]);
        }

        return response()->json([
            'error' => 'Menu not found'
        ]);
    }

    public function deleteMenu(Request $request)
    {
        $validasi = DB::table('menu')->where('id', $request->param)->where('id_html_form', null)->where('status', 'non-active')->first();
        if ($validasi) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            if ($validasi->parent == '0') {
                DB::table('menu')->where('id', $request->param)->delete();
                DB::table('menu')->where('parent', $validasi->id)->delete();
                return response()->json([
                    'success' => 'Menu deleted successfully'
                ]);
            } else {
                DB::table('menu')->where('id', $request->param)->delete();
                return response()->json([
                    'success' => 'Menu deleted successfully'
                ]);
            }
        }

        return response()->json([
            'error' => 'Menu failed to delete'
        ]);
    }

    public function getParentMenu(Request $request)
    {
        $menu = DB::table('menu')->where('parent', '0')->where('id_menu_group', $request->id_group)->orderBy('id', 'asc')->get();
        return response()->json(['data' => $menu]);
    }

    public function getAllMenu()
    {
        $group = DB::table('menu_group')->get();
        $html = '<ul class="list-group">';
        $parent = [];

        // foreach ($group as $g) {
        // $divisi = DB::table('division')->where('id', $g->id_divisi)->first();
        // $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">
        //                 <strong>[group] ' . $g->name . '</strong>
        //               </li>';
        // $parent = DB::table('menu')->where('id_menu_group', $g->id)->where('parent', '0')->get();
        $parent = DB::table('menu')->where('parent', '0')->get();
        foreach ($parent as $p) {
            if ($p->status == 'active') {
                $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text feather-icon"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                            [parent] ' . $p->name . '
                                        </span>
                                        <span>
                                            <a href="javascript:void(0)" status="true" class="badge bg-success badge-pill change-status" data-param="' . $p->id . '">Aktif</a>
                                            <a href="javascript:void(0)" class="badge bg-warning badge-pill edit" data-param="' . $p->id . '">edit</a>
                                        </span>
                                    </li>';
            } else {
                $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text feather-icon"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                            [parent] ' . $p->name . '
                                        </span>
                                        <span>
                                            <a href="javascript:void(0)" status="false" class="badge bg-primary badge-pill change-status" data-param="' . $p->id . '">Non Aktif</a>
                                            <a href="javascript:void(0)" class="badge bg-warning badge-pill edit" data-param="' . $p->id . '">edit</a>
                                            <a href="javascript:void(0)" class="badge bg-danger badge-pill delete" data-param="' . $p->id . '">delete</a>
                                        </span>
                                    </li>';
            }

            $menu = DB::table('menu')->where('parent', $p->id)->get();
            foreach ($menu as $m) {
                if ($m->status == 'active') {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center"
                                        style="margin-left: 30px">
                                        <a href="javascript:void(0)">[child] ' . $m->name . '</a>
                                        <span>
                                            <a href="javascript:void(0)" class="badge bg-warning badge-pill edit" data-param="' . $m->id . '">edit</a>
                                        </span>
                                    </li>';
                } else {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center"
                                        style="margin-left: 30px">
                                        <a href="javascript:void(0)">[child] ' . $m->name . '</a>
                                        <span>
                                            <a href="javascript:void(0)" data-param="' . $m->id . '" class="badge bg-warning badge-pill edit">edit</a>
                                            <a href="javascript:void(0)" data-param="' . $m->id . '" class="badge bg-danger badge-pill delete">delete</a>
                                        </span>
                                    </li>';
                }
            }
        }
        // }
        $html .= '</ul>';
        return response()->json(['html' => $html, 'count_group' => count($group), 'count_menu' => count($parent)]);
    }

    public function getSinggleMenu()
    {
        $menu = DB::table('menu')->where('parent', '0')->orderBy('id', 'asc')->get();
        return response()->json(['data' => $menu]);
    }

    public function pageParentMenu(Request $request)
    {
        $validasi = DB::table('menu')->where('parent', $request->param)->where('page', NULL)->get();
        if ($validasi) {
            return response()->json(['success' => ['data' => $validasi]]);
        }
        return response()->json(['error' => ['msg' => 'Parent menu not found']]);
    }

    public function savePageMenu(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'parent' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                'child' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                'page' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        $validate = DB::table('menu')->where('id', $request->child)->first();

        if (!$validate) {
            return response()->json([
                'error' => ['msg' => 'Ups someting wrong']
            ]);
        }

        $parent = DB::table('menu')->where('id', $validate->parent)->first();

        if ($parent->status == 'non-active') {
            DB::table('menu')->where('id', $validate->parent)->update([
                'status' => 'active',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // merubah status dan jenis halaman child
        DB::table('menu')->where('id', $validate->id)->update([
            'page' => $request->page,
            'status' => 'active',
            'name_parent' => $parent->name,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');

        return response()->json([
            'success' => 'The menu page has been successfully saved'
        ]);
    }

    public function deletePageMenu(Request $request)
    {
        $validasi = DB::table('menu')->where('id', $request->param)->where('status', 'active')->first();
        if ($validasi) {
            DB::table('menu')->where('id', $validasi->id)->update([
                'page' => NULL,
                'status' => 'non-active',
                'name_parent' => NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('menu')->where('id', $validasi->parent)->update([
                'page' => NULL,
                'status' => 'non-active',
                'name_parent' => NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => 'The menu page has been successfully delete'
            ]);
        }

        return response()->json([
            'error' => 'Menu page failed to delete'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $validasi = DB::table('menu')->where('id', $request->param)->first();
        if (!$validasi) {
            return response()->json([
                'error' => 'Menu not found'
            ]);
        }

        $status = $validasi->status == 'non-active' ? 'active' : 'non-active';

        DB::table('menu')->where('id', $request->param)->update([
            'status' => $status
        ]);

        return response()->json([
            'success' => 'Menu has been changed successfully'
        ]);
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
            $html .= $this->masterMenu();
            $html .= $this->dinamisMenu(Auth::user()->role, Auth::user()->id_divisi);
        } else if (Auth::user()->role == 'manager') {
            $html .= $this->masterMenu();
            $html .= $this->dinamisMenu(Auth::user()->role, Auth::user()->id_divisi);
        } else {
            if (Auth::user()->id_divisi != NULL) {
                $html .= $this->dinamisMenu(Auth::user()->role, Auth::user()->id_divisi);
            }
        }

        $data = [
            'data' => $html,
            'script' => "<script data-sidebar src=" . asset('dist/js/sidebarmenu.js') . "></script>"
        ];

        return json_encode($data);
    }

    private function masterMenu()
    {
        if (Auth::user()->role == 'administrator') {
            $html = '<li class="list-divider"></li>
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
                        <li class="sidebar-item">
                            <a href="' . route('items') . '" class="sidebar-link">
                                <span class="hide-menu"> Data Items </span>
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
        }

        if (Auth::user()->role == 'manager') {
            $html = '<li class="list-divider"></li>
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
                        <li
                            class="sidebar-item">
                            <a href="' . route('formBuilder') . '"
                                class="sidebar-link">
                                <span class="hide-menu"> Form Builder </span>
                            </a>
                        </li>
                    </ul>
            </li>';
        }

        return $html;
    }

    private function dinamisMenu($role, $divisi)
    {
        $html = '';
        // if ($role == 'administrator') {
        //     $group = DB::table('menu_group')->where('status', 'active')->get();
        // } else if ($role == 'manager') {
        //     if ($divisi != NULL) {
        //         $group = DB::table('menu_group')->where('status', 'active')->where('id_divisi', $divisi)->get();
        //     }
        // } else {
        //     if ($divisi != NULL) {
        //         $group = DB::table('menu_group')->where('status', 'active')->where('id_divisi', $divisi)->get();
        //     }
        // }

        // foreach ($group as $g) {
        $html .= '<li class="list-divider"></li>
                         <li class="nav-small-cap"><span class="hide-menu">Form</span></li>';

        // $parent = DB::table('menu')->where('id_menu_group', $g->id)->where('parent', '0')->where('status', 'active')->get();
        $parent = DB::table('menu')->where('parent', '0')->where('status', 'active')->get();

        foreach ($parent as $p) {
            $html .= '<li class="sidebar-item">';
            $html .= '<a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                              <i class="icon-notebook font-700"></i>
                              <span class="hide-menu">' . $p->name . ' </span>
                          </a>
                          <ul aria-expanded="false" class="collapse first-level base-level-line">';

            // if (Auth::user()->role == 'administrator') {
            //     $menu = DB::table('menu')->where('parent', $p->id)->where('status', 'active')->where('is_use', 'yes')->orderBy('id', 'asc')->get();
            // } else if (Auth::user()->role == 'validator') {
            //     $menu = DB::table('menu')->where('parent', $p->id)->where('status', 'active')->where('is_use', 'yes')->whereIn('page', ['Validator', 'Report'])->orderBy('id', 'asc')->get();
            // } else if (Auth::user()->role == 'manager') {
            //     $menu = DB::table('menu')->where('parent', $p->id)->where('status', 'active')->where('is_use', 'yes')->whereIn('page', ['Approver', 'Report'])->orderBy('id', 'asc')->get();
            // } else {
            //     $menu = DB::table('menu')->where('parent', $p->id)->where('status', 'active')->where('is_use', 'yes')->whereIn('page', ['Entry Page'])->orderBy('id', 'asc')->get();
            // }

            if (Auth::user()->role == 'administrator') {
                $menu = DB::table('menu')->where('parent', $p->id)->where('status', 'active')->where('is_use', 'yes')->orderBy('id', 'asc')->get();
            } else {
                $menu = DB::table('menu')->where('parent', $p->id)->where('status', 'active')->where('is_use', 'yes')->whereIn('page', ['Entry Page', 'Validator', 'Approver', 'Report'])->orderBy('id', 'asc')->get();
            }

            foreach ($menu as $m) {
                $html .= '<li class="sidebar-item">
                                    <a href="' . route('pages') . '?menu=' . $m->slug . '" class="sidebar-link">
                                        <span class="hide-menu"> ' . $m->name . ' </span>
                                    </a>
                                </li>';
            }

            $html .= '</ul>';
            $html .= '</li>';
        }
        // }

        return $html;
    }
}
