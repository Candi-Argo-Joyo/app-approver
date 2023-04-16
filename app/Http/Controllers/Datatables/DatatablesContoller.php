<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DataTables;

class DatatablesContoller extends Controller
{

    public function __construct()
    {
        $this->ajax();
    }

    private function ajax()
    {
        if (!request()->ajax()) {
            Redirect::to('login')->send();
        }
    }

    public function datatablesLogs(Request $request)
    {
        $data = DB::table('log_activity')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('method_h', function ($row) {
                if ($row->method == 'POST') {
                    $method = '<label class="badge bg-cyan">' . $row->method . '</label>';
                } else {
                    $method = '<label class="badge bg-success">' . $row->method . '</label>';
                }
                return $method;
            })
            ->addColumn('ip_h', function ($row) {
                $method = '<span class="text-warning">' . $row->ip . '</span>';
                return $method;
            })
            ->addColumn('agent_h', function ($row) {
                $method = '<span class="text-danger">' . $row->agent . '</span>';
                return $method;
            })
            ->rawColumns(['method_h', 'ip_h', 'agent_h'])
            ->make(true);
    }

    public function datatablesUsers(Request $request)
    {
        $data = DB::table('users')->whereIn('role', ['manager', 'user'])->select('id', 'name', 'email', 'username', 'guid')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('source', function ($row) {
                if ($row->guid == NULL) {
                    $source = 'Create Manual';
                } else {
                    $source = 'LDAP / Active Directory';
                }
                return $source;
            })
            ->addColumn('action', function ($row) {
                if ($row->guid == NULL) {
                    $btn = '<a href="javascript:void(0)" class="badge bg-warning edit" data-param="' . $row->id . '">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="javascript:void(0)" class="badge bg-danger delete" data-param="' . $row->id . '">
                                <i class="fas fa-trash"></i>
                            </a>';
                } else {
                    $btn = '<a href="javascript:void(0)" class="badge bg-danger delete" data-param="' . $row->id . '">
                                <i class="fas fa-trash"></i>
                            </a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'source'])
            ->make(true);
    }

    public function datatablesPageMenu(Request $request)
    {
        $data = DB::table('menu')->where('status', 'active')->whereNotIn('parent', ['0'])->select('id', 'name', 'page', 'name_parent', 'status')->orderBy('name_parent', 'desc')->orderBy('created_at', 'desc')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('type', function ($row) {
                $img = '';
                switch ($row->page) {
                    case 'Entry Page':
                        $img = "entry.png";
                        break;
                    case 'Approver':
                        $img = "approver.png";
                        break;
                    default:
                        $img = "report.png";
                        break;
                }

                $btn = $row->page . '
                        <a href="javascript:void(0)" preview asset="' . asset('images/page/' . $img) . '" data-bs-toggle="modal" data-bs-target="#viewImage" role="button">(view)</a>';
                return $btn;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 'active') {
                    $status = '<span status="false" class="badge bg-success change-status" data-param="' . $row->id . '" role="button">
                               active
                              </span>';
                } else {
                    $status = '<span class="badge bg-danger change-status" data-param="' . $row->id . '" role="button">
                               non active
                              </span>';
                }
                return $status;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="badge bg-warning edit" data-param="' . $row->id . '">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="javascript:void(0)" class="badge bg-danger delete" data-param="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </a>';
                return $btn;
            })
            ->rawColumns(['status', 'action', 'type'])
            ->make(true);
    }

    public function datatablesPosition(Request $request)
    {
        $data = DB::table('position')->select('id', 'name')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="badge bg-warning edit" data-param="' . $row->id . '">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="javascript:void(0)" class="badge bg-danger delete" data-param="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesDivision(Request $request)
    {
        $data = DB::table('division')->select('id', 'name')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="badge bg-warning edit" data-param="' . $row->id . '">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="javascript:void(0)" class="badge bg-danger delete" data-param="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesHastMapping(Request $request)
    {
        $data = DB::table('users')->select('id', 'name', 'email', 'role', 'jabatan_name', 'divisi_name')->where('is_mapping', 'true')->whereIn('role', ['manager', 'user'])->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="badge bg-info rolback" data-param="' . $row->id . '">Rollback</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesUnMapping(Request $request)
    {
        $data = DB::table('users')->select('id', 'name', 'email', 'divisi_name')->where('is_mapping', 'false')->where('role', 'user')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('check', function ($row) {
                $check = '<input name="select[]" type="checkbox" value="' . $row->id . '">';
                return $check;
            })
            ->addColumn('role', function ($row) {
                $html = '<select class="form-control role" name="role[]">
                            <option value="">--Chose Role--</option>
                            <option value="manager">Manager</option>
                            <option value="user">User</option>
                        </select>';

                return $html;
            })
            ->addColumn('jabatan', function ($row) {

                $dataPosition = DB::table('position')->get();
                $html = '<select class="form-control position" name="position[]">';
                $html .= '<option value="">--Chose Position--</option>';
                foreach ($dataPosition as $ps) {
                    $html .= '<option value="' . $ps->id . '">' . $ps->name . '</option>';
                }

                $html .= '</select>';

                return $html;
            })
            ->addColumn('divisi', function ($row) {

                $dataDivision = DB::table('division')->get();
                $html = '<select class="form-control division" name="division[]">';
                $html .= '<option value="">--Chose Division--</option>';
                foreach ($dataDivision as $ds) {
                    $html .= '<option value="' . $ds->id . '">' . $ds->name . '</option>';
                }

                $html .= '</select>';

                return $html;
            })
            ->rawColumns(['jabatan', 'divisi', 'check', 'role'])
            ->make(true);
    }

    public function datatablesentry(Request $request)
    {
        $data = DB::table('insert_form')->select('form_name', 'uid', 'user_name', 'status', 'created_at')->where('id_html_form', $request->id_html_form)->where('status', 'draft')->groupBy('form_name', 'uid', 'user_name', 'status', 'created_at')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row, Request $request) {
                $btn = '<a href="' . route('pages') . '?menu=' . $request->menu . '&detail=' . $row->uid . '" class="badge bg-success preview">Detail</a> <a href="javascript:void(0)" data-param="' . $row->uid . '" class="badge bg-danger delete">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesapproval(Request $request)
    {
        $data = DB::table('insert_form')->select('form_name', 'uid', 'user_name', 'status', 'created_at')->where('id_html_form', $request->id_html_form)->where('status', 'draft')->groupBy('form_name', 'uid', 'user_name', 'status', 'created_at')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row, Request $request) {
                $btn = '<a href="' . route('pages') . '?menu=' . $request->menu . '&detail=' . $row->uid . '" class="badge bg-success preview">Detail</a> <a href="javascript:void(0)" data-param="' . $row->uid . '" class="badge bg-primary approve">Approve</a> <a href="javascript:void(0)" data-param="' . $row->uid . '" class="badge bg-danger reject">Reject</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesData(Request $request)
    {
        $data = DB::table('insert_form')->select('form_name', 'uid', 'user_name', 'status', 'created_at')->where('id_html_form', $request->id_html_form)->where('status', 'approve')->groupBy('form_name', 'uid', 'user_name', 'status', 'created_at')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row, Request $request) {
                $btn = '<a href="javascript:void(0)" class="badge bg-info">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="' . route('pages') . '?menu=' . $request->menu . '&detail=' . $row->uid . '" class="badge bg-success">Detail</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
