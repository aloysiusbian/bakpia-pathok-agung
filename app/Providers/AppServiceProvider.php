<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\AdminComposer;
use App\View\Composers\PelangganComposer;

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
     * Bootstrap any application servicess
     */
    public function boot(): void
    {
        View::composer('dashboard-admin.*', AdminComposer::class);
        View::composer('dashboard-pelanggan.*', PelangganComposer::class);
        View::composer('pages.edit_profile', PelangganComposer::class);
        View::composer('pages.edit_profil', AdminComposer::class);
    }
}
