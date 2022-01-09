<?php

namespace App\Providers;

use App\Domain;
use App\Link;
use App\Observers\DomainObserver;
use App\Observers\LinkObserver;
use App\Observers\PixelObserver;
use App\Observers\SpaceObserver;
use App\Observers\UserObserver;
use App\Pixel;
use App\Space;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Space::observe(SpaceObserver::class);
        Link::observe(LinkObserver::class);
        Domain::observe(DomainObserver::class);
        User::observe(UserObserver::class);
        Pixel::observe(PixelObserver::class);
    }
}
