<?php


namespace App\Helpers;

use App\Models\LogActivity as LogActivityModel;


class LogActivity
{
    public static function addToLog($subject)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = request()->fullUrl();
        $log['method'] = request()->method();
        $log['ip'] = request()->ip();
        $log['agent'] = request()->header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['user'] = auth()->check() ? auth()->user()->name : 'not tracked';
        LogActivityModel::create($log);
    }
}
