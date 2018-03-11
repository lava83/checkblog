<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 11.03.2018
 * Time: 20:55
 */

class Autoloader
{
    protected static $dirs = [];

    /**
     * adds a autoloader dir
     * @param $dirName
     * @throws Exception
     */
    public static function addDir($dirName) {
        if(!is_dir($dirName)) {
            throw new Exception(sprintf('The dir: %s doesnt exists.', $dirName));
        }
        static::$dirs[] = $dirName;
    }

    /**
     * the loader methode
     * @param $className
     */
    public function load($className) {

        foreach (static::$dirs as $dir) {
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
            $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;
            if(file_exists($filePath)) {
                require_once $filePath;
            }
        }

    }
}

