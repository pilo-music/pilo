<?php


namespace App\Libs;

use Request;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{
    public static function addToLog($subject)
    {
       try{
           $log = [];
           $log['subject'] = $subject;
           $log['url'] = Request::fullUrl();
           $log['method'] = Request::method();
           $log['ip'] = Request::ip();
           $log['agent'] = Request::header('user-agent');
           $log['user_id'] = auth()->check() ? auth()->user()->id : null;
           LogActivityModel::create($log);
       }catch (\Exception $e){}
    }

    public static function logActivityLists()
    {
        return LogActivityModel::latest()->paginate(20);
    }

}