<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class BaseController extends Controller
{
    /**
     * 学员用户信息
     */
    public static $student;

    /**
     * 微信用户基本信息
     */
    public static $user_wx;

    /**
     * 获取当前时间
     * 开发账号可以通过get方式传递参数修改目标时间?debug_day || ?debug_time 即可传值
     * 例如 https://host/index?debug_day=1&debug_time=21:00 返回时间为 1天后的21:00 Carbon对象
     * @return BaseController|Carbon
     */
    public static function now()
    {
        if (!self::abTest(self::$student['id']) && env('APP_DEBUG') == false) return Carbon::now();
        //加载debug 时间
        $debug_day = Request::get('debug_day');
        $debug_time = Request::get('debug_time');
        if ($debug_time == 'clear') {
            session(['debug_now_time' => null]);
            return Carbon::now();
        }
        if (($now = session('debug_now_time')) && !$debug_day && !$debug_time) {
            //从session 中获取
            return $now;
        }
        //重新加载
        $now = Carbon::now();
        if ($day = Request::get('debug_day')) {
            $now = Carbon::now()->addDay($day);
        }
        if ($debug_time = Request::get('debug_time')) {
            $debug_time = Carbon::createFromFormat('H:i', $debug_time);
            $now = Carbon::create($now->year, $now->month, $now->day, $debug_time->hour, $debug_time->minute);
        }
        session(['debug_now_time' => $now]);
        return $now;
    }

    /**
     * 是否是测试账号
     * @param $id
     * @return bool
     */
    public static function abTest($id)
    {
        $master = [
            1,
        ];
        return in_array((int)$id, $master);
    }

}
