<?php namespace Tukecx\Base\Settings\Repositories;

use Tukecx\Base\Caching\Services\Traits\Cacheable;
use Tukecx\Base\Core\Repositories\Eloquent\EloquentBaseRepository;
use Tukecx\Base\Caching\Services\Contracts\CacheableContract;
use Tukecx\Base\Settings\Repositories\Contracts\SettingContract;

class SettingRepository extends EloquentBaseRepository implements SettingContract, CacheableContract
{
    use Cacheable;

    protected $rules = [
        'option_key' => 'required|unique:settings|string|max:100',
        'option_value' => 'string'
    ];

    protected $editableFields = [
        'option_key',
        'option_value',
    ];

    /**
     * @return array
     */
    public function getAllSettings()
    {
        $result = [];
        $settings = $this->get(['option_key', 'option_value']);

        foreach ($settings as $key => $row) {
            $result[$row->option_key] = $row->option_value;
        }

        return $result;
    }

    /**
     * @param $settingKey
     * @return mixed
     */
    public function getSetting($settingKey)
    {
        $setting = $this
            ->where(['option_key' => $settingKey])
            ->select(['id', 'option_key', 'option_value'])
            ->first();
        if ($setting) {
            return $setting->option_value;
        }
        return null;
    }

    /**
     * @param array $settings
     * @return array|bool
     */
    public function updateSettings($settings = [])
    {
        foreach ($settings as $key => $row) {
            $result = $this->updateSetting($key, $row);
            if ($result['error']) {
                return $result;
            }
        }
        return response_with_messages('Settings updated', false, \Constants::SUCCESS_NO_CONTENT_CODE);
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    public function updateSetting($key, $value)
    {
        $allowCreateNew = true;
        $justUpdateSomeFields = false;

        /**
         * Parse everything to string
         */
        $value = (string)$value;

        $setting = $this
            ->where(['option_key' => $key])
            ->select(['id', 'option_key', 'option_value'])
            ->first();

        if ($setting) {
            $allowCreateNew = false;
            $justUpdateSomeFields = true;
        }

        $result = $this->editWithValidate($setting, [
            'option_key' => $key,
            'option_value' => $value
        ], $allowCreateNew, $justUpdateSomeFields);

        if ($result['error']) {
            return response_with_messages($result['messages'], true, \Constants::ERROR_CODE, [
                'key' => $key,
                'value' => $value
            ]);
        }

        return response_with_messages('Settings updated', false, \Constants::SUCCESS_NO_CONTENT_CODE);
    }
}
