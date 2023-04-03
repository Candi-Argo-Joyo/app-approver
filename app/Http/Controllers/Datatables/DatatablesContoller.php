<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class DatatablesContoller extends Controller
{
    public function datatablesPageMenu(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/')->with('error', 'Akses dilarang..!');
        }

        DB::statement(DB::raw('set @rownum=0'));
        $data = DB::table('menu')->where('status', 'active')->whereNotIn('parent', ['0'])->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'id', 'name', 'page', 'name_parent', 'status')->orderBy('name_parent', 'desc')->orderBy('created_at', 'desc')->get();
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
        if (!$request->ajax()) {
            return redirect('/')->with('error', 'Akses dilarang..!');
        }

        DB::statement(DB::raw('set @rownum=0'));
        $data = DB::table('position')->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'id', 'name')->get();
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
        if (!$request->ajax()) {
            return redirect('/')->with('error', 'Akses dilarang..!');
        }

        DB::statement(DB::raw('set @rownum=0'));
        $data = DB::table('division')->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'id', 'name')->get();
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
}
