<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 11.03.2018
 * Time: 20:52
 */
require_once 'autoloader.php';

$application = \Core\Application::getInstance();
$application->setApplicationBasePath(__DIR__);
$application->run();

