<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        // Define blade directive attr to facilitate adding conditional html attributes
        Blade::directive('attr', fn (string $expression) => "<?php echo (new App\Support\AttrRenderer)->renderDirective([{$expression}], get_defined_vars()); ?>");
    }
}
