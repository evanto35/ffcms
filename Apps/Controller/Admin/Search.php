<?php

namespace Apps\Controller\Admin;


use Apps\Model\Admin\Search\FormSettings;
use Extend\Core\Arch\AdminController;
use Ffcms\Core\App;

/**
 * Class Search. Admin configuration controller for search app.
 * @package Apps\Controller\Admin
 */
class Search extends AdminController
{
    const VERSION = 0.1;

    public $type = 'app';

    public function actionIndex()
    {
        // initialize model and pass configs inside
        $model = new FormSettings($this->getConfigs());

        // check if submit request is sended
        if ($model->send()) {
            if ($model->validate()) {
                // save configurations
                $this->setConfigs($model->getAllProperties());
                App::$Session->getFlashBag()->add('success', __('Settings is successful updated'));
                App::$Response->redirect('search/index');
            } else {
                App::$Session->getFlashBag()->add('error', __('Form validation is failed'));
            }
        }

        // render output view
        return App::$View->render('settings', [
            'model' => $model->filter()
        ]);
    }

}