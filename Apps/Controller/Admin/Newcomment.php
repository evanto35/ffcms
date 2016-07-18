<?php

namespace Apps\Controller\Admin;

use Ffcms\Core\App;
use Extend\Core\Arch\AdminController;
use Apps\Model\Admin\Newcomment\FormSettings;

/**
 * Class Newcomment. Controller of widget admin part
 * @package Apps\Controller\Admin
 */
class Newcomment extends AdminController
{
    const VERSION = 0.1;
    
    public $type = 'widget';

    /**
     * Show widget new comments settings
     * @return string
     * @throws \Ffcms\Core\Exception\NativeException
     * @throws \Ffcms\Core\Exception\SyntaxException
     */
    public function actionIndex()
    {
        $model = new FormSettings($this->getConfigs());
        
        if ($model->send() && $model->validate()) {
            $this->setConfigs($model->getAllProperties());
            App::$Session->getFlashBag()->add('success', __('Settings is successful updated'));
        }
        
        return $this->view->render('index', [
            'model' => $model->filter()
        ]);
    }
}