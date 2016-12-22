<?php
/**
 * Created by PhpStorm.
 * User: bling
 * Date: 2016/12/22
 * Time: 下午2:31
 */

namespace App\Wechat;


use EasyWeChat\Core\Exceptions\HttpException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class WechatHelper
{
    public static function configJSForViews()
    {
        if (Request::isMethod('get') && isset($_SERVER['SERVER_PORT']) && isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI'])) {
            $js_config = [];
            try {
                $js = app('wechat')->js;
                $protocol = (!empty($_SERVER['HTTPS'])
                    && $_SERVER['HTTPS'] !== 'off'
                    || (int)$_SERVER['SERVER_PORT'] === 443) ? 'https://' : 'http://';
                $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                if (env('APP_ENV') == 'production') $url = str_replace('http', 'https', $url); //生产环境用阿里云slb的443端口时，后台服务的SERVER_PORT仍然是80 需要手动替换
                $js->setUrl($url);
                $APIs = [
                    'hideAllNonBaseMenuItem',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ',
                    'showMenuItems',
                    'hideMenuItems',
                    'previewImage',
                    'chooseImage',
                    'previewImage',
                    'uploadImage'
                ];
                $js_config = $js->config($APIs);
            } catch (HttpException $exception) {
                //微信js-sdk 注册失败
                Log::error('微信js-sdk 注册失败,' . $exception->getMessage());
            }
            view()->share('js_config', $js_config);
        }
    }
}