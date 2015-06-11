<?php namespace Reivaj86\ChefAuth;

use Illuminate\Support\ServiceProvider;

class ChefAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/chef-auth.php' => config_path('chef-auth.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../migrations/' => base_path('/database/migrations')
        ], 'migrations');

        $this->registerBladeExtensions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/chef-auth.php', 'chef-auth');
    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->extend(function ($view, $compiler) {
            $pattern = $compiler->createMatcher('chefrecipe');

            return preg_replace($pattern, '<?php if (Auth::check() && Auth::user()->cooks$2): ?> ', $view);
        });

        $blade->extend(function ($view, $compiler) {
            $pattern = $compiler->createPlainMatcher('endchefrecipe');

            return preg_replace($pattern, '<?php endif; ?>', $view);
        });

        $blade->extend(function ($view, $compiler) {
            $pattern = $compiler->createMatcher('chefcategory');

            return preg_replace($pattern, '<?php if (Auth::check() && Auth::user()->is$2): ?> ', $view);
        });

        $blade->extend(function ($view, $compiler) {
            $pattern = $compiler->createPlainMatcher('endchefcategory');

            return preg_replace($pattern, '<?php endif; ?>', $view);
        });

        $blade->extend(function ($view, $compiler) {
            $pattern = $compiler->createMatcher('chefsteamed');

            return preg_replace($pattern, '<?php if (Auth::check() && Auth::user()->steamed$2): ?> ', $view);
        });

        $blade->extend(function ($view, $compiler) {
            $pattern = $compiler->createPlainMatcher('endchefsteamed');

            return preg_replace($pattern, '<?php endif; ?>', $view);
        });
    }

}