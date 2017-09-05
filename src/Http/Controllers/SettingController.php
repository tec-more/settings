<?php namespace Tukecx\Base\Settings\Http\Controllers;

use Tukecx\Base\Core\Http\Controllers\BaseAdminController;

use Tukecx\Base\Settings\Repositories\Contracts\SettingContract;

class SettingController extends BaseAdminController
{
    protected $module = 'tukecx-settings';

    /**
     * @var \Tukecx\Base\Settings\Repositories\SettingRepository
     */
    protected $repository;

    public function __construct(SettingContract $settingRepository)
    {
        parent::__construct();

        $this->repository = $settingRepository;

        $this->breadcrumbs->addLink('设置', route('admin::settings.index.get'));

        $this->getDashboardMenu($this->module);

        $this->assets
            ->addStylesheets('bootstrap-tagsinput')
            ->addJavascripts('bootstrap-tagsinput');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('设置');

        return do_filter('settings.index.get', $this)->viewAdmin('index');
    }

    /**
     * Update settings
     * @method POST
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = $this->request->except([
            '_token',
            '_tab',
        ]);

        /**
         * Filter
         */
        $data = do_filter('settings.before-edit.post', $data, $this);

        $result = $this->repository->updateSettings($data);

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        do_action('settings.after-edit.post', $result, $this);

        return redirect()->back();
    }
}
