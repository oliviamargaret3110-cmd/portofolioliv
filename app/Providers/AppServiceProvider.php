<?php

namespace App\Providers;

use App\Models\Profile;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Data profil + pengaturan dibagikan ke layout publik (navbar & footer).
        View::composer('layouts.app', function ($view): void {
            $view->with('siteProfile', Profile::query()->first());
            $view->with('siteSettings', Setting::query()->pluck('value', 'key'));
        });
    }
}
