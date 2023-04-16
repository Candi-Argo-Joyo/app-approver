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
            'divsi' => DB::table('division')->get()
        ];
        return view('pages/datamenu/index', $data);
    }

    public function getGroupAll()
    {
        $html = '';
        $option = '';
        $data = DB::table('menu_group')->get();
        foreach ($data as $d) {
            $divisi = DB::table('division')->where('id', $d->id_divisi)->first();
            $html .= ' <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>[division:' . $divisi->name . '] ' . $d->name . '</strong>
                            <span>
                                  <a href="javascript:void(0)" data-param=' . $d->id . ' class="badge bg-warning badge-pill edit-group">edit</a>
                                  <a href="javascript:void(0)" data-param=' . $d->id . ' class="badge bg-danger badge-pill del-group">delete</a>
                            </span>
                       </li>';

            $option .= '<option value="' . $d->id . '">[division: ' . $divisi->name . '] ' . $d->name . '</option>';
        }

        return response()->json(['data' => $data, 'count_group' => count($data), 'html' => $html, 'option' => $option]);
    }

    public function saveGroup(Request $request)
    {
        if ($request->param) {
            $validator = Validator::make(
                $request->all(),
                [
                    'group' => 'required',
                    'divisi' => 'required|integer|regex:/^([0-9]+)$/|not_in:0|exists:division,id',
                    'param' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                ]
            );
        } else {
            $validator = Validator::make($request->all(), [
                'group' => 'required',
                'divisi' => 'required|integer|regex:/^([0-9]+)$/|not_in:0|exists:division,id',
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
                'id_divisi' => $request->divisi,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('menu_group')->insert([
                'name' => strtoupper($request->group),
                'id_divisi' => $request->divisi,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
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
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            DB::table('menu_group')->where('id', $request->param)->delete();
            return response()->json(['success' => 'Group delete successfully.']);
        }
        return response()->json(['error' => 'Group delete error.']);
    }

    public function saveMenu(Request $request)
    {
        if ($request->type == 'dropdown') {
            if ($request->param) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'id_group' => 'required|integer|regex:/^([0-9]+)$/|not_in:0|exists:menu_group,id',
                        'name' => 'required|unique:menu,name,' . $request->param,
                        'type' => 'required',
                    ]
                );
            } else {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'id_group' => 'required|integer|regex:/^([0-9]+)$/|not_in:0|exists:menu_group,id',
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
                        'id_group' => 'required|integer|regex:/^([0-9]+)$/|not_in:0|exists:menu_group,id',
                        'name' => 'required|unique:menu,name,' . $request->param,
                        'type' => 'required',
                        'parent' => 'required|integer|regex:/^([0-9]+)$/|not_in:0',
                    ]
                );
            } else {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'id_group' => 'required|integer|regex:/^([0-9]+)$/|not_in:0|exists:menu_group,id',
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
            $group = DB::table('menu_group')->where('id', $request->id_group)->first();
            if ($request->type == 'dropdown') {
                if ($request->param_menu) {
                    DB::table('menu')->where('id', $request->param_menu)->update([
                        'id_menu_group' => $request->id_group,
                        'id_divisi' => $group->id_divisi,
                        'name' => $request->name,
                        'slug' => preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($request->name))),
                        'type' => 'dropdown',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    DB::table('menu')->insert([
                        'id_menu_group' => $request->id_group,
                        'id_divisi' => $group->id_divisi,
                        'name' => $request->name,
                        'slug' => preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($request->name))),
                        'type' => 'dropdown',
                        'parent' => '0',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            } else {
                if ($request->param_menu) {
                    DB::table('menu')->where('id', $request->param_menu)->update([
                        'id_menu_group' => $request->id_group,
                        'id_divisi' => $group->id_divisi,
                        'name' => $request->name,
                        'slug' => preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($request->name))),
                        'type' => 'singgle',
                        'parent' => $request->parent,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    DB::table('menu')->insert([
                        'id_menu_group' => $request->id_group,
                        'id_divisi' => $group->id_divisi,
                        'name' => $request->name,
                        'slug' => preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($request->name))),
                        'type' => 'singgle',
                        'parent' => $request->parent,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
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
        $validasi = DB::table('menu')->where('id', $request->param)->first();
        if ($validasi) {
            LogActivity::addToLog('Access: [' . last(request()->segments()) . ']');
            DB::table('menu')->where('id', $request->param)->delete();
            return response()->json([
                'success' => 'Menu deleted successfully'
            ]);
        }

        return response()->json([
            'error' => 'Menu failed to delete'
        ]);
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
            $divisi = DB::table('division')->where('id', $g->id_divisi)->first();
            $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>[group][division:' . $divisi->name . '] ' . $g->name . '</strong>
                      </li>';
            $parent = DB::table('menu')->where('id_menu_group', $g->id)->where('parent', '0')->get();
            foreach ($parent as $p) {
                $html .= '<li class="ml-4 list-group-item d-flex justify-content-between align-items-center"
                                    style="margin-left: 30px">
                                    <span class="d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text feather-icon"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                        [parent][division:' . $divisi->name . '] ' . $p->name . '
                                    </span>
                                    <span>
                                        <a href="javascript:void(0)" class="badge bg-warning badge-pill edit-parent" data-param="' . $p->id . '">edit</a>
                                        <a href="javascript:void(0)" class="badge bg-danger badge-pill delete-parent" data-param="' . $p->id . '">delete</a>
                                    </span>
                                </li>';
                $menu = DB::table('menu')->where('parent', $p->id)->get();
                foreach ($menu as $m) {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="margin-left: 60px">
                                    <a href="javascript:void(0)">[child][division:' . $divisi->name . '] ' . $m->name . '</a>
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
        $menu = DB::table('menu')->where('parent', '0')->get();
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

        $group = DB::table('menu_group')->where('id', $validate->id_menu_group)->first();
        $parent = DB::table('menu')->where('id', $validate->parent)->first();

        // merubah status grup
        if ($group->status == 'non-active') {
            DB::table('menu_group')->where('id', $validate->id_menu_group)->update([
                'status' => 'active',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // merubah status parent menu
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
        if ($role == 'administrator') {
            $group = DB::table('menu_group')->where('status', 'active')->get();
        } else if ($role == 'manager') {
            if ($divisi != NULL) {
                $group = DB::table('menu_group')->where('status', 'active')->where('id_divisi', $divisi)->get();
            }
        } else {
            if ($divisi != NULL) {
                $group = DB::table('menu_group')->where('status', 'active')->where('id_divisi', $divisi)->get();
            }
        }

        foreach ($group as $g) {
            $html .= '<li class="list-divider"></li>
                         <li class="nav-small-cap"><span class="hide-menu">' . $g->name . '</span></li>';

            $parent = DB::table('menu')->where('id_menu_group', $g->id)->where('parent', '0')->where('status', 'active')->get();

            foreach ($parent as $p) {
                $html .= '<li class="sidebar-item">';
                $html .= '<a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                              <i class="icon-notebook font-700"></i>
                              <span class="hide-menu">' . $p->name . ' </span>
                          </a>
                          <ul aria-expanded="false" class="collapse first-level base-level-line">';

                if (Auth::user()->role == 'manager') {
                    $menu = DB::table('menu')->where('parent', $p->id)->where('status', 'active')->where('is_use', 'yes')->whereIn('page', ['Approver', 'Report'])->orderBy('id', 'asc')->get();
                } else {
                    $menu = DB::table('menu')->where('parent', $p->id)->where('status', 'active')->where('is_use', 'yes')->orderBy('id', 'asc')->get();
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
        }

        return $html;
    }
}
