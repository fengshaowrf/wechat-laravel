<?php

namespace App\Listeners\Wechat;

use App\Events\Wechat\TextEvent;
use App\Helper\Encrypt;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;

class CanOpen
{
    /**
     * @var Application $wechat
     */
    protected $wechat;

    /**
     * DevAccount constructor.
     * @param Application $wechat
     */
    public function __construct(Application $wechat) { $this->wechat = $wechat; }

    /**
     * Handle the event.
     *
     * @param  TextEvent $event
     * @return void
     */
    public function handle(TextEvent $event)
    {
        $content = $event->Content;
        if (strpos($content, '打不开') === false && strpos($content, '打不開') === false && strpos($content, '进不去') === false) return;
        $openid = $event->server->getMessage()['FromUserName'];
        $auth_key = Encrypt::authcode($openid, Encrypt::ENCODE);
        $error_user = [
            'openid' => $openid,
            'type' => 0,
        ];
        $url = config('app.url') . '?key=' . $auth_key;
        $text = "可能由于你的网络较差,请尝试下方的快速通道\n\n\n<a href=\"{$url}\">点击进入系统</a>";
        if (strpos($content, '还是') !== false) {
            //还是打不开
            $error_user['type'] = 1;
            $text_msg = new Text();
            $text_msg->content = '复制下面出现的链接到手机其他浏览器(如Safari,UC浏览器)打开。工程师正在努力尽快优化微信的这个问题,感谢你的反馈';
            $this->wechat->staff->message($text_msg)->to($openid)->send();
            $text_msg->content = $url;
            $this->wechat->staff->message($text_msg)->to($openid)->send();
            return;
        }
        $event->server->setMessageHandler(function () use ($text) {
            return $text;
        });
    }
}
