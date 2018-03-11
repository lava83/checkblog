<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 11.03.2018
 * Time: 23:05
 */
$basePath = __DIR__ . DIRECTORY_SEPARATOR;
require_once $basePath . 'classes' . DIRECTORY_SEPARATOR . 'Autoloader.php';
try {
    Autoloader::addDir($basePath . 'classes');
    spl_autoload_register([new Autoloader, 'load']);
} catch (Exception $e) {
    throw $e;
}