<?php

namespace App\Providers;

use App\Models\Guest;
use App\Models\Message;
use App\Observers\GuestObserver;
use App\Observers\MessageObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Guest::observe(GuestObserver::class);
        Message::observe(MessageObserver::class);
    }
}
