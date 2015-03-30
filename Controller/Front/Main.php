<?php

namespace Controller\Front;

use Core\Arch\Controller;
use Core\Arch\View;
use \Model\Front\User;


class Main extends Controller {

    public function before()
    {
        //self::$layout = 'other.php';
    }

    public function actionIndex()
    {
        $this->wtf = 'Test me baby ;)';
        //$this->setGlobalVar('wtf', 'test global variable set');


        $view = new View('index', 'Main');

        $model = new User();
        $model->name = "<a href='#' onclick='javascript::alert(1)'><b>Mihail</b></a><script>alert('1')</script>";
        $model->role = "user";

        $model->make();

        $this->response = $view->out(['model' => $model->export()]);
        //$this->response = \App::$View->render('index', ['t1' => 'test1', 't2' => 'test2']);
    }

    public function actionRead($id)
    {
        echo "Action read called" . $id;
    }
}