<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 11.03.2018
 * Time: 23:06
 */

namespace Controllers;

use Core\Application;

class IndexController
{

    public function indexAction(Application $application, $id = null)
    {
        echo 'Hallo Stefan';
    }

}