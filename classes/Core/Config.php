<?php

namespace Core;

use Exceptions\ConfigException;

class Config
{

    protected static $config = [];

    protected static $dirs = [];

    /**
     * adds a dir to configuration
     * @param $dirName
     * @throws ConfigException
     */
    public static function addDir($dirName) {
        if(!is_dir($dirName)) {
            throw new ConfigException(sprintf('The dir: %s doesnt exists.', $dirName));
        }
        static::$dirs[] = $dirName;
    }

    /**
     * initialize the configuration of application
     */
    public static function init() {
        foreach (static::$dirs as $dir) {
            if($phpFiles = glob($dir . DIRECTORY_SEPARATOR . '*.php')) {
                foreach ($phpFiles as $phpFile) {
                    $namespace = basename($phpFile, '.php');
                    static::$config[$namespace] = require_once $phpFile;
                }
            }
        }
    }

    /**
     * get the config element by path
     * @param $path
     * @return array|mixed|null
     */
    public static function get($path) {
        $pathArray = explode('.', $path);
        $current = static::$config;
        if(static::exists($current, $pathArray[0])) {
            //check the namespace exists
            foreach($pathArray as $item) {
                if(static::exists($current, $item)) {
                    $current = &$current[$item];
                }
            }
            return $current;
        }
        return null;
    }

    /**
     * @param $array
     * @param $key
     * @return bool
     */
    public static function exists($array, $key) {
        return isset($array[$key]);
    }

}