<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 11.03.2018
 * Time: 23:06
 */

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