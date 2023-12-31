<?php

namespace App\Providers;

use App\Models\Module;
use App\Models\Setting;
use App\Observers\ModuleObserver;
use App\Observers\SettingObserver;
use App\Rules\ValidRecaptcha;
use Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Module::observe(ModuleObserver::class);
        Setting::observe(SettingObserver::class);
        Validator::extend('recaptcha', ValidRecaptcha::class);
        app()->useLangPath(base_path('lang'));
        Schema::defaultStringLength(191);
        Blade::if('module', function ($name, $module = null) {
            $module = $module->where('name', $name)->first();
            //            $module
            if ($module) {
                return $module->is_active;
            }

            return false;
        });
    }
}
