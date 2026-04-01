<?php

namespace App\Providers;

use Sentry\State\Scope;
use function Sentry\configureScope;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
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
        if (app()->bound('sentry')) {
            configureScope(function (Scope $scope): void {
                if (auth()->check()) {
                    $scope->setTag('user_permission', auth()->user()->permissions['articles'] ?? 'none');
                }
            });
        }
        // On partage ces variables uniquement avec les vues situées dans le dossier 'errors'
        View::composer('errors::*', function ($view) {
            $isAdmin = Request::is('admin') || Request::is('admin/*');

            $view->with([
                'isAdmin' => $isAdmin,
                'homeRoute' => $isAdmin ? route('admin_dashboard') : route('home'),
                'homeLabel' => $isAdmin ? 'Retour au tableau de bord' : "Retour à l'accueil",
            ]);
        });
    }
}
