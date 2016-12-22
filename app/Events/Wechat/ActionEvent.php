<?php

namespace App\Events\Wechat;

use EasyWeChat\Server\Guard;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

/**
 * 微信被动事件消息
 * Class ActionEvent
 * @package App\Events\Wechat
 */
class ActionEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Guard
     */
    public $server;
    public $event_key = '';
    public $event = ''; //微信事件消息类型

    /**
     * Create a new event instance.
     *
     * @param Guard $event
     */
    public function __construct($event)
    {
        //
        $this->server = $event;
        $msg = $event->getMessage();
        if(isset($msg['Event'])) $this->event = $msg['Event'];
        if(isset($msg['EventKey'])) $this->event_key = $msg['EventKey'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
