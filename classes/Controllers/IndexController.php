<?php

namespace Controllers;

use Core\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        $this->view->setTemplate('index/index.php');
        return $this->view;
    }

}