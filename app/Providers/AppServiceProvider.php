<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
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
    Blade::if('role', function ($roles) {
      $arrRoles = explode('|', $roles);
      return Auth::user()->hasRole($arrRoles);
    });

    View::composer('*', function ($view) {
      $settings = Cache::rememberForever('settings', function () {
        return Setting::select('name', 'logo')->first();
      });
      $view->with('settings', $settings);
    });
  }
}
