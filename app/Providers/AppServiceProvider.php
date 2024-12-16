<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GiphyService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

     protected $policies = [
        App\Models\Post::class => App\Policies\PostPolicy::class,
    ];
    
    public function register()
    {
        $this->app->singleton(GiphyService::class, function ($app) {
            return new GiphyService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
