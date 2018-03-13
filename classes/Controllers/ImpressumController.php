<?php

namespace Controllers;


use Core\Controller;

class ImpressumController extends Controller
{

    public function indexAction() {
        $this->view->setTemplate('impressum/index.php');
        return $this->view;
    }

}