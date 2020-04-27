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
        Blade::aliasComponent('bootstrap.form.input', 'input');
        Blade::aliasComponent('bootstrap.form.checkbox', 'checkbox');
        Blade::aliasComponent('bootstrap.form.textarea', 'textarea');
        Blade::aliasComponent('bootstrap.form.select', 'select');
        Blade::aliasComponent('bootstrap.form.datetime', 'datetime');

        Blade::directive('human_date', function ($expression) {
            return "<?php require_once(app_path('Helpers/HumanDateFormat.php')); echo \App\Helpers\HumanDateFormat::format({$expression}); ?>";
        });

        Blade::directive('phone', function ($expression) {
            return "<?php require_once(app_path('Helpers/PhoneFormat.php')); echo \App\Helpers\PhoneFormat::format({$expression}); ?>";
        });

        Blade::directive('human_bytes', function ($expression) {
            return "<?php require_once(app_path('Helpers/BytesSizeFormat.php')); echo \App\Helpers\BytesSizeFormat::formatBytes({$expression}); ?>";
        });

        Blade::directive('currency', function ($expression) {
            return "<?php require_once(app_path('Helpers/CurrencyFormat.php')); echo \App\Helpers\CurrencyFormat::format({$expression}); ?>";
        });

        Blade::directive('linebreaks', function ($expression) {
            return "<?php require_once(app_path('Helpers/Linebreaks.php')); echo \App\Helpers\Linebreaks::format({$expression}); ?>";
        });
    }
}
