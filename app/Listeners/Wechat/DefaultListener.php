<?php

namespace App\Listeners\Wechat;

use App\Events\Wechat\TextEvent;

class DefaultListener{
    /**
     * Create the event listener.
     */
    public function __construct(){
    }

    /**
     * Handle the event.
     *
     * @param  TextEvent $event
     *
     * @return void
     */
    public function handle(TextEvent $event){
        if(!$event->Content) return ;
        $for_api = app('wechat');
        $user = $for_api->user;
        $resp = [];
        $msg = $event->server->getMessage();
        switch($event->Content){
            case '基本信息':{
                $user = $user->get($msg['FromUserName']);
                $resp = json_encode($user);
                break;
            }
            case '时间测试':{
                $time = microtime();
                $user->get($msg['FromUserName']);
                $time2 = microtime();
                $resp =$time2-$time;
                break;
            }
        }
        $event->server->setMessageHandler(function($msg) use($resp){
            return $resp;
        });
    }
}
