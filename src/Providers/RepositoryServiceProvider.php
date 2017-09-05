<?php namespace Tukecx\Base\Settings\Providers;

use Illuminate\Support\ServiceProvider;
use Tukecx\Base\Settings\Models\EloquentSetting;
use Tukecx\Base\Settings\Repositories\SettingRepository;
use Tukecx\Base\Settings\Repositories\Contracts\SettingContract;
use Tukecx\Base\Settings\Repositories\SettingRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SettingContract::class, function () {
            $repository = new SettingRepository(new EloquentSetting);

            if (config('tukecx-caching.repository.enabled')) {
                return new SettingRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
