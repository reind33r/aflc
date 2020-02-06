<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Carbon\Carbon::setLocale('fr');
        setlocale(LC_TIME, 'fr_FR.UTF-8');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('bootstrap.form.input', 'input');
        Blade::component('bootstrap.form.checkbox', 'checkbox');
        Blade::component('bootstrap.form.textarea', 'textarea');
        Blade::component('bootstrap.form.select', 'select');

        Blade::directive('human_date', function ($expression) {
            return "<?php require_once(app_path('Helpers/HumanDateFormat.php')); echo \App\Helpers\HumanDateFormat::format({$expression}); ?>";
        });

        Blade::directive('phone', function ($expression) {
            return "<?php require_once(app_path('Helpers/PhoneFormat.php')); echo \App\Helpers\PhoneFormat::format({$expression}); ?>";
        });
    }
}
