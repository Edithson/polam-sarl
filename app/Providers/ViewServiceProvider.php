<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // On n'injecte ces variables QUE dans les layouts de base
        View::composer('*', function ($view) {
            $settings = Setting::getCachedSettings();

            $view->with('siteName', $settings->name);
            $view->with('siteLogo', $settings->logo);
            $view->with('siteSlogan', $settings->slogan);
            $view->with('siteSocials', $settings->socials ?? []);
        });
    }
}
