<?php

namespace App\Events\Wechat;

use EasyWeChat\Server\Guard;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 微信被动文本消息
 * Class TextEvent
 * @package App\Events\Wechat
 */
class TextEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \EasyWeChat\Server\Guard
     */
    public $server;

    /**
     * @var string
     */
    public $Content = '';


    /**
     * Create a new event instance.
     *
     * @param Guard $server
     */
    public function __construct($server)
    {
        $this->server = $server;
        $msg = $server->getMessage();
        if (isset($msg['Content'])) $this->Content = $msg['Content'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
