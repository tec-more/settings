<?php namespace Tukecx\Base\Settings\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'Tukecx\Base\Settings';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'tukecx-settings',
            'priority' => 1,
            'parent_id' => 'tukecx-configuration',
            'heading' => null,
            'title' => '设置',
            'font_icon' => 'fa fa-circle-o',
            'link' => route('admin::settings.index.get'),
            'css_class' => null,
            'permissions' => ['view-settings'],
        ]);
    }
}
