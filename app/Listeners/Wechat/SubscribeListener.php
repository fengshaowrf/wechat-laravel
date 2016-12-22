<?php

namespace App\Listeners\Wechat;

use App\Events\Wechat\ActionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribeListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActionEvent $event
     * @return void
     */
    public function handle(ActionEvent $event)
    {
        if ($event->event_key) return;//扫码关注事件

        switch ($event->event) {
            case 'subscribe': {
                //普通关注事件
                $event->server->setMessageHandler(function ($msg) {
                    return "欢迎关注!";
                });
                return;
            }
            case 'unsubscribe': {
                //TODO 取消关注
            }
        }
    }
}
