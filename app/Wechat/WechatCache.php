<?php

namespace App\Wechat;

use Doctrine\Common\Cache\Cache as CacheInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

/**
 * Created by PhpStorm.
 * User: bling
 * Date: 16/9/23
 * Time: 上午10:10
 */
class WechatCache implements CacheInterface
{
    public function fetch($id)
    {
        return Redis::get($this->parseId($id));
    }

    public function contains($id)
    {
        return !is_null(Redis::get($this->parseId($id)));
    }


    public function save($id, $data, $lifeTime = 0)
    {
        return Redis::setex($this->parseId($id), $lifeTime, $data);
    }

    public function delete($id)
    {
        return Redis::delete($this->parseId($id));
    }

    public function getStats()
    {
        return null;
    }

    protected function parseId($id)
    {
        //修改$id 兼容其他项目中使用redis保存access_token的格式 : wechat.access_token.APPID
        Log::debug('parse id : ' . $id);
        $arr = explode('.', $id);
        $appid = $arr[count($arr) - 1];
        $key_type = $arr[count($arr) - 2];
        $key = "wechat.{$key_type}.{$appid}";
        return $key;
    }
}