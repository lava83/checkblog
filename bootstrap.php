<?php

require_once 'autoloader.php';

$application = \Core\Application::getInstance();
$application->setApplicationBasePath(__DIR__);
$application->run();

