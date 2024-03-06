<?php

namespace App\Providers;

use App\Models\MainMenu;

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
        $mainMenus = MainMenu::all();

        view()->share('mainMenus', $mainMenus);
    }
}
