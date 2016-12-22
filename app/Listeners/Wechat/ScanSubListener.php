<?php

namespace App\Listeners\Wechat;

use App\Events\Wechat\ActionEvent;
use App\Services\CheckInService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ScanSubListener
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActionEvent $event
     */
    public function handle(ActionEvent $event)
    {
        if(('SCAN' != $event->event && 'subscribe' != $event->event) || ($event->event=='subscribe' && !$event->event_key)) return;//非扫码事件(如果是第一次扫码关注就是subscribe)
        $event_key = str_replace('qrscene_','',$event->event_key);
        $resp = [];
        if(($event_key - 0) > 0){
            //临时二维码
            $prefix = (int)substr($event_key,0,2);
            $value = substr($event_key,2);
            switch($prefix){
                case 10: {
                    $resp = "临时二维码 10:".$value;
                    break;
                }
                case 11: {
                    $resp = "临时二维码 10:".$value;
                    break;
                }
                case 12: {
                    $resp = "临时二维码 10:".$value;
                    break;
                }
                case 21: {
                    $resp = "临时二维码 21:".$value;
                    break;
                }
                default: {
                    $resp = "临时二维码 default:".$value;
                }
            }
        }else{
            //永久二维码
            $key_data = explode('_',$event_key);
            if(!is_array($key_data) || count($key_data)<2) return;
            $prefix = $key_data[0];
            $value = $key_data[1];
            switch($prefix){
                case 'event': {
                    $resp = "永久二维码 event:".$value;
                    break;
                }
            }
        }
        $event->server->setMessageHandler(function($msg) use ($resp){
            return $resp;
        });

    }
}
