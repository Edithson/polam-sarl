<?php

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LawsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DahsboardController;

// Route::view('/', 'welcome');

Route::get('/', HomeController::class . '@index')->name('home');

Route::get('/about', AboutController::class . '@index')->name('about');
Route::get('/service', ServiceController::class . '@index')->name('service');
Route::get('/article', HomeController::class . '@list_articles')->name('article');
Route::get('/article/{article:slug}', HomeController::class . '@show_article')->name('home.article.show');
Route::get('/contact', ContactController::class . '@index')->name('contact');
Route::get('/faq', FaqController::class . '@index')->name('faq');

//protected routes

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', UserController::class . '@index')->middleware('can:viewAny,' . User::class)->name('user.index');
    Route::get('/admin/users/create', UserController::class . '@create')->middleware('can:create,' . User::class)->name('user.create');
    Route::get('/admin/users/{user}', UserController::class . '@edit')->middleware('can:update,user')->name('user.edit');
    Route::get('/admin/dashboard', DahsboardController::class . '@index')->name('admin_dashboard');
    Route::resource('/admin/articles', ArticleController::class)->middleware('auth');
    Route::get('/admin/laws', LawsController::class . '@index_admin')->name('laws.index_admin');
    Route::resource('/admin/laws', LawsController::class)->except(['index'])->middleware('auth');
    Route::get('/admin/settings', SettingController::class . '@index')->middleware('can:viewAny,' . Setting::class)->name('settings.index');
    Route::get('/admin/contact', ContactController::class . '@index_admin')->name('admin.contact.index');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/debug-sentry', function () {
    throw new Exception("Test de Sentry avec debug à false ! Ça fonctionne !");
});

require __DIR__.'/auth.php';
