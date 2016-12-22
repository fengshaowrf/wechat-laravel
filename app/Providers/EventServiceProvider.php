<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Wechat\TextEvent' => [
            'App\Listeners\Wechat\DefaultListener',
            'App\Listeners\Wechat\HomeListener',
            'App\Listeners\Wechat\CanOpen',
        ], 'App\Events\Wechat\ActionEvent' => [
            'App\Listeners\Wechat\ScanSubListener',
            'App\Listeners\Wechat\SubscribeListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
