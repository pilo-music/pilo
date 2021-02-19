<?php
/**
 * Created by PhpStorm.
 * User: mobin
 * Date: 2019-03-01
 * Time: 2:26 AM
 */

namespace App\Libs;


use App\Models\ViewAnalyse as Model;
use Jenssegers\Agent\Agent;

class ViewAnalyse
{
    /**
     * @param $type
     * @param $id
     */
    public static function addView($type, $id)
    {
        try {
            $agent = new Agent();
            $browser = $agent->browser();
            $platform = $agent->platform();
            Model::create([
                'user_id' => auth()->check() ? auth()->user()->id : null,
                'post_type' => $type,
                'post_id' => $id,
                'ip' => request()->ip(),
                'browser' => $browser,
                'browser_version' => $agent->version($browser),
                'platform' => $platform,
                'platform_version' => $agent->version($platform),
                'is_robot' => $agent->isRobot(),
                'robot_name' => $agent->isRobot() == true ? $agent->robot() : null,
            ]);
        } catch (\Exception $e) {
        }
    }
}
