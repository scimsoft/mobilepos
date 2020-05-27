<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\ProductsComposer;
use App\Http\ViewComposers\CategoriesComposer;

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
        //
        View::composer(['order.*'],ProductsComposer::class);
        View::composer(['order.*'],CategoriesComposer::class);

        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount, 2).' €'; ?>";
        });

    }
}
