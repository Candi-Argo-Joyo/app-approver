<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use Mail;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail as FacadesMail;

class MailSetting extends Controller
{
    public function index()
    {
        $env = [
            'MAIL_MAILER' => env('MAIL_MAILER'),
            "MAIL_HOST" => env('MAIL_HOST'),
            "MAIL_PORT" => env('MAIL_PORT'),
            "MAIL_USERNAME" => env('MAIL_USERNAME'),
            "MAIL_PASSWORD" => env('MAIL_PASSWORD'),
            "MAIL_ENCRYPTION" => env('MAIL_ENCRYPTION')
        ];

        $data = [
            'env' => $env
        ];
        return view('pages/settingmail', $data);
    }

    public function save(Request $request)
    {
        $path = base_path('.env');

        $oldEnv = [
            ['NAME' => 'MAIL_MAILER', 'VALUE' => env('MAIL_MAILER') == null ? 'null' : env('MAIL_MAILER')],
            ['NAME' => "MAIL_HOST", 'VALUE' => env('MAIL_HOST') == null ? 'null' : env('MAIL_HOST')],
            ['NAME' => "MAIL_PORT", 'VALUE' => env('MAIL_PORT') == null ? 'null' : env('MAIL_PORT')],
            ['NAME' => "MAIL_USERNAME", 'VALUE' => env('MAIL_USERNAME') == null ? 'null' : env('MAIL_USERNAME')],
            ['NAME' => "MAIL_PASSWORD", 'VALUE' => env('MAIL_PASSWORD') == null ? 'null' : env('MAIL_PASSWORD')],
            ['NAME' => "MAIL_ENCRYPTION", 'VALUE' => env('MAIL_ENCRYPTION') == null ? 'null' : env('MAIL_ENCRYPTION')]
        ];

        $newEnv = [
            ['NAME' => "MAIL_MAILER", 'VALUE' => $request->mailer == '' ? 'null' : ($request->mailer == 'null' ? 'null' : $request->mailer)],
            ['NAME' => "MAIL_HOST", 'VALUE' => $request->hosts == '' ? 'null' : ($request->hosts == 'null' ? 'null' : $request->hosts)],
            ['NAME' => "MAIL_PORT", 'VALUE' => $request->port == '' ? 'null' : ($request->port == 'null' ? 'null' : $request->port)],
            ['NAME' => "MAIL_USERNAME", 'VALUE' => $request->username == '' ? 'null' : ($request->username == 'null' ? 'null' : $request->username)],
            ['NAME' => "MAIL_PASSWORD", 'VALUE' => $request->password == '' ? 'null' : ($request->password == 'null' ? 'null' : $request->password)],
            ['NAME' => "MAIL_ENCRYPTION", 'VALUE' => $request->encryption == '' ? 'null' : ($request->encryption == 'null' ? 'null' : $request->encryption)]
        ];

        if (file_exists($path)) {
            for ($i = 0; $i < count($newEnv); $i++) {
                $oldName = $oldEnv[$i]['NAME'];
                $oldValue = $oldEnv[$i]['VALUE'];
                $newName = $newEnv[$i]['NAME'];
                $newValue = $newEnv[$i]['VALUE'];

                file_put_contents($path, str_replace(
                    "$oldName=$oldValue",
                    "$newName=$newValue",
                    file_get_contents($path)
                ));
            }
        }

        return response()->json(['success' => true]);
    }

    public function testMail(Request $request)
    {
        FacadesMail::to('receiver-email-id')->send(new NotifyMail());

        if (FacadesMail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
        } else {
            return response()->success('Great! Successfully send in your mail');
        }
    }
}
