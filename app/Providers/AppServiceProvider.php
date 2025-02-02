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
        Blade::directive('shapeClass', function ($shape) {
            return "<?php echo match($shape) {
                'circle' => 'bg-red-400 rounded-full',
                'triangle' => 'bg-transparent w-0 h-0 border-l-10 border-r-10 border-b-20 border-b-blue-500',
                'square' => 'bg-green-400',
                'rectangle' => 'bg-yellow-400 w-28 h-16',
                'star' => 'bg-purple-400 clip-star',
                default => 'bg-gray-400'
            }; ?>";
});
}
}