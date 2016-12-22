<?php

namespace App\Listeners\Wechat;

use App\Events\Wechat\TextEvent;

class HomeListener
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
     * @param TextEvent $event
     */
    public function handle(TextEvent $event)
    {
        if ('首页' != $event->Content) return;
        $user = app('wechat')->user;
        $event->server->setMessageHandler(function ($message) use ($user) {
            $fromUser = $user->get($message->FromUserName);
            return "{$fromUser->nickname} 您好！欢迎关注 !";
        });
    }
}
