<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 12.03.18
 * Time: 11:31
 */

namespace Controllers;


use Core\Controller;

class ImpressumController extends Controller
{

    public function indexAction() {
        $this->view->setTemplate('impressum/index.php');
        return $this->view;
    }

}