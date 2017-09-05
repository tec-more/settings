<?php namespace Tukecx\Base\Settings\Repositories;

use Tukecx\Base\Caching\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;
use Tukecx\Base\Settings\Repositories\Contracts\SettingContract;

class SettingRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements SettingContract
{
    /**
     * @return array
     */
    public function getAllSettings()
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $settingKey
     * @return mixed
     */
    public function getSetting($settingKey)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $settings
     * @return bool
     */
    public function updateSettings($settings = [])
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function updateSetting($key, $value)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
