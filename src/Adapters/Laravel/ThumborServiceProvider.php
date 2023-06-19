<?php
/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Adapters\Laravel;

use Beeyev\Thumbor\Thumbor;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ThumborServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/config/thumbor.php' => config_path('thumbor.php'),
            ],
            'config'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Thumbor::class, function () {
            return new Thumbor(config('thumbor.base_url'), config('thumbor.security_key'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<class-string>
     */
    public function provides(): array
    {
        return [Thumbor::class];
    }
}
