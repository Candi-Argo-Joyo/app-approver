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
        $data = DB::table('users')->whereIn('role', ['manager', 'validator', 'user'])->select('id', 'name', 'email', 'username', 'guid')->get();
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
        $data = DB::table('menu')->whereNotNull('page')->whereNotIn('parent', ['0'])->select('id', 'name', 'page', 'name_parent', 'status', 'is_use')->orderBy('name_parent', 'desc')->orderBy('created_at', 'desc')->get();
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
                if ($row->is_use != 'yes') {
                    $btn = '<a href="javascript:void(0)" class="badge bg-danger delete-page" data-param="' . $row->id . '">
                                <i class="fas fa-trash"></i>
                            </a>';
                    return $btn;
                }
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
        $data = DB::table('users')->select('id', 'name', 'email', 'role', 'jabatan_name', 'divisi_name')->where('is_mapping', 'true')->whereIn('role', ['manager', 'validator', 'user'])->get();
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
                            <option value="validator">Validator</option>
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
        if (Auth::user()->role == 'administrator') {
            $data = DB::table('insert_form')->select('form_name', 'uid', 'user_name', 'status', 'created_at')->where('id_html_form', $request->id_html_form)->where('status', 'under-review')->groupBy('form_name', 'uid', 'user_name', 'status', 'created_at')->get();
        } else {
            $cekData = DB::table('insert_form')->select('form_name', 'uid', 'user_name', 'status', 'created_at')->where('id_html_form', $request->id_html_form)->where('status', 'under-review')->where('id_user', Auth::user()->id)->groupBy('form_name', 'uid', 'user_name', 'status', 'created_at')->get();
            if ($cekData) {
                $data = $cekData;
            } else {
                $data = [];
            }
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row, Request $request) {
                $btn = '<a href="' . route('pages') . '?menu=' . $request->menu . '&detail=' . $row->uid . '" class="badge bg-success preview">Detail</a> <a href="javascript:void(0)" data-param="' . $row->uid . '" data-validator="' . $request->id_menu . '" data-from="' . $request->id_html_form . '" class="badge bg-primary accept">Accept</a> <a href="javascript:void(0)" data-param="' . $row->uid . '" class="badge bg-danger reject">Reject</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesvalidator(Request $request)
    {
        $data = DB::table('insert_form')->select('form_name', 'uid', 'user_name', 'status', 'created_at')->where('id_html_form', $request->id_html_form)->where('status', 'under-review')->groupBy('form_name', 'uid', 'user_name', 'status', 'created_at')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row, Request $request) {
                $btn = '<a href="' . route('pages') . '?menu=' . $request->menu . '&detail=' . $row->uid . '" class="badge bg-success preview">Detail</a> <a href="javascript:void(0)" data-param="' . $row->uid . '" data-validator="' . $request->id_menu . '" data-from="' . $request->id_html_form . '" class="badge bg-primary accept">Accept</a> <a href="javascript:void(0)" data-param="' . $row->uid . '" class="badge bg-danger reject">Reject</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesapproval(Request $request)
    {
        $data = [];
        if (Auth::user()->role == 'administrator') {
            $dataInsert = DB::table('insert_form')->select('form_name', 'uid', 'user_name', 'status', 'validate_by', 'created_at', 'updated_at')->where('id_html_form', $request->id_html_form)->groupBy('form_name', 'uid', 'user_name', 'status', 'validate_by', 'created_at', 'updated_at')->get();
            foreach ($dataInsert as $di) {
                $data[] = [
                    'form_name' => $di->form_name,
                    'uid' => $di->uid,
                    'user_name' => $di->user_name,
                    'status' => $di->status,
                    'validate_by' => $di->validate_by,
                    'created_at' => $di->created_at,
                    'updated_at' => $di->updated_at
                ];
            }
        } else {
            $validatorGroup = DB::table('validation_group')->where('id_html_form', $request->id_html_form)->first();
            if ($validatorGroup->simultan == 'yes') {
                $validator = DB::table('validation')->where('id_html_form', $request->id_html_form)->where('id_user', Auth::user()->id)->first();
                if ($validator) {
                    //ambil nama field dari validasi grup
                    $nameField = DB::table('form_field')->where('id', $validatorGroup->id_form_field)->first();
                    if ($nameField) {
                        // buat cek data apaka nlai lebih/kurang dari condition
                        $dataInsert = DB::table('insert_form')->select('value', 'form_name', 'uid', 'user_name', 'status', 'validate_by', 'created_at', 'updated_at')->where('id_html_form', $request->id_html_form)->where('field_name', $nameField->original_name)->groupBy('value', 'form_name', 'uid', 'user_name', 'status', 'validate_by', 'created_at', 'updated_at')->get();
                        if ($dataInsert) {
                            foreach ($dataInsert as $di) {
                                if ((($di->value) >= ($validator->more_than)) || (($di->value) <= ($validator->less_than))) {
                                    $data[] = [
                                        'form_name' => $di->form_name,
                                        'uid' => $di->uid,
                                        'user_name' => $di->user_name,
                                        'status' => $di->status,
                                        'validate_by' => $di->validate_by,
                                        'created_at' => $di->created_at,
                                        'updated_at' => $di->updated_at
                                    ];
                                }
                            }
                        }
                    } else {
                        $dataInsert = DB::table('insert_form')->select('form_name', 'uid', 'user_name', 'status', 'validate_by', 'created_at', 'updated_at')->where('id_html_form', $request->id_html_form)->groupBy('form_name', 'uid', 'user_name', 'status', 'validate_by', 'created_at', 'updated_at')->get();
                        foreach ($dataInsert as $di) {
                            $data[] = [
                                'form_name' => $di->form_name,
                                'uid' => $di->uid,
                                'user_name' => $di->user_name,
                                'status' => $di->status,
                                'validate_by' => $di->validate_by,
                                'created_at' => $di->created_at,
                                'updated_at' => $di->updated_at
                            ];
                        }
                    }
                }
            } else {
                $validator = DB::table('validation')->where('id_html_form', $request->id_html_form)->where('id_user', Auth::user()->id)->first();
                if ($validator) {
                    $nameField = DB::table('form_field')->where('id', $validatorGroup->id_form_field)->first();
                    if ($nameField) {

                        $dataInsert = DB::table('insert_form')->select('value', 'form_name', 'uid', 'user_name', 'status', 'validate_by', 'on_step', 'created_at', 'updated_at')->where('id_html_form', $request->id_html_form)->where('field_name', $nameField->original_name)->groupBy('value', 'form_name', 'uid', 'user_name', 'status', 'validate_by', 'on_step', 'created_at', 'updated_at')->get();
                        foreach ($dataInsert as $da) {
                            if ($da->on_step == $validator->step) {
                                if ((($da->value) >= ($validator->more_than)) || (($da->value) <= ($validator->less_than))) {
                                    $data[] = [
                                        'form_name' => $da->form_name,
                                        'uid' => $da->uid,
                                        'user_name' => $da->user_name,
                                        'status' => $da->status,
                                        'validate_by' => $da->validate_by,
                                        'created_at' => $da->created_at,
                                        'updated_at' => $da->updated_at
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row, Request $request) {
                $btn = '<a href="' . route('pages') . '?menu=' . $request->menu . '&detail=' . $row['uid'] . '" class="badge bg-success preview">Detail</a> <a href="javascript:void(0)" data-param="' . $row['uid'] . '" class="badge bg-primary approve">Approve</a> <a href="javascript:void(0)" data-param="' . $row['uid'] . '" class="badge bg-danger reject">Reject</a>';
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

    public function datatablesAsign(Request $request)
    {
        $data = DB::table('digital_asign')
            ->select('digital_asign.id as id', 'digital_asign.image as img', 'users.name as name')
            ->join('users', 'digital_asign.id_user', '=', 'users.id')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('img', function ($row) {
                $img = '<div style="height: 100px"><img class="h-100" src="' . asset('uploads/' . $row->img . '') . '" alt=""></div>';
                return $img;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="badge bg-warning edit" data-param="' . $row->id . '">Edit</a>
                        <a href="#" class="badge bg-danger del" data-param="' . $row->id . '">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action', 'img'])
            ->make(true);
    }

    public function datatablesGroupItem(Request $request)
    {
        $data = DB::table('group_item')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="badge bg-warning edit" data-param="' . $row->id . '">Edit</a>
                        <a href="#" class="badge bg-danger del" data-param="' . $row->id . '">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesItems(Request $request)
    {
        $data = DB::table('items')
            ->select('items.id as id', 'items.name as name', 'items.unit as unit', 'group_item.name as name_group')
            ->join('group_item', 'items.id_group_item', '=', 'group_item.id')
            ->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="badge bg-warning edit-item" data-param="' . $row->id . '">Edit</a>
                        <a href="#" class="badge bg-danger del-item" data-param="' . $row->id . '">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
