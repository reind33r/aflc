<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;

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

        Blade::directive('human_date', function ($expression) {
            return "<?php require_once(app_path('Helpers/HumanDateFormat.php')); echo \App\Helpers\HumanDateFormat::format({$expression}); ?>";
        });
    }
}
