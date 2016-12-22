<?php

namespace App\Providers;

use App\Wechat\WechatHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::addExtension('html', 'php'); //设置php模板的后缀为html

        //为每个GET请求的网页注册wx-js-sdk config
        WechatHelper::configJSForViews();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
