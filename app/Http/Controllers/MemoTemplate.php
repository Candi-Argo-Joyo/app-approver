<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MemoTemplate extends Controller
{
    public function index()
    {
        return view('pages/memoTemplate/index');
    }

    public function add()
    {
        $data = [
            'selected' => 'memo'
        ];
        return view('pages/memoTemplate/add', $data);
    }

    public function moreTemplate(Request $request)
    {
        $no = ($request->input('no') + 1);
        $html = "<tr>
                        <td><div id='urutan'>" . ($no + 1) . "</div></td>
                        <td>
                            <div class='form-group mb-3'>
                                <label for=''>Content Name</label>
                                <input type='text' class='form-control'>
                            </div>
                            <div class='form-group mb-3'>
                                <label for=''>Content</label>
                                <textarea name='content' id='content' style='min-height: 500px' class='form-control change editor-" . ($no + 1) . "'></textarea>
                            </div>
                        </td>
                        <td>
                            <a href='javascript:void(0)' class='badge bg-danger' id='DeleteButton'>
                                -
                            </a>
                        </td>
                </tr>
                ";

        $script = "<script param=" . ($no + 1) . ">ClassicEditor.create(document.querySelector('.editor-" . ($no + 1) . "'))</script>";

        $data = [
            'html' => $html,
            'script' => $script
        ];
        return json_encode($data);
    }
}
