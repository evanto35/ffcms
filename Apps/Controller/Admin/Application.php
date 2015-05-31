<?php

namespace Apps\Controller\Admin;

use Apps\Model\Admin\AppTurnForm;
use Extend\Core\Arch\AdminController;
use Ffcms\Core\App;
use Ffcms\Core\Exception\ForbiddenException;

class Application extends AdminController
{
    // list of applications
    public function actionIndex()
    {
        $this->response = App::$View->render('index', [
            'apps' => $this->applications
        ]);
    }

    // allow turn on/off applications
    public function actionTurn($controller_name)
    {
        $controller_name = ucfirst(strtolower($controller_name));

        $search = \Apps\ActiveRecord\App::where('sys_name', '=', $controller_name)->first();

        if ($search === null || $search->id < 1) {
            throw new ForbiddenException();
        }

        $model = new AppTurnForm();

        if ($model->isPostSubmit()) {
            $model->updateApp($search);
            App::$Session->getFlashBag()->add('success', 'Application status was changed');
        }

        $this->response = App::$View->render('turn', [
            'app' => $search,
            'model' => $model
        ]);
    }

    public function actionInstall()
    {
        // TODO: fix me
        $this->response = 'TODO';
    }
}