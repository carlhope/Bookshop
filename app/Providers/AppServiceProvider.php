<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
                'cart' => fn () => session('cart', []),
                'cartCount' => fn () => Session::get('cart_count', 0),

            ]);


        Inertia::version(fn () => md5_file(public_path('build/manifest.json')));

    }
}
