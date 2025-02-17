<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Blade::if('adminOrSuperAdmin', function () {
            return Auth::guard('admin')->check() && in_array(Auth::guard('admin')->user()->role, ['admin', 'super_admin']);
        });
    }
}
