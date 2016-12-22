<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * 获取用户微信基本信息
     */
    public function userinfo()
    {
        return self::$user_wx;
    }
}
