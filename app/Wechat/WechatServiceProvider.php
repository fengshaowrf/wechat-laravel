<?php
/**
 * Created by PhpStorm.
 * User: bling
 * Date: 16/9/23
 * Time: 上午11:06
 */

namespace App\Wechat;


use EasyWeChat\Foundation\Application;
use Overtrue\LaravelWechat\CacheBridge;
use Overtrue\LaravelWechat\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(['EasyWeChat\\Foundation\\Application' => 'wechat'], function ($app) {
            $app = new Application(config('wechat'));
            if (config('wechat.use_laravel_cache')) {
                $app->cache = new CacheBridge();
            } elseif (config('wechat.cache_class')) {
                $cacheClass = config('wechat.cache_class');
                $app->cache = new $cacheClass;
            }
            return $app;
        });
    }
}