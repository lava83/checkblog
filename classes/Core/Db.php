<?php

namespace Core;


class Db
{

    /**
     * @var self
     */
    protected static $pdoInstances = [];

    /**
     * @param string $name
     * @return \PDO
     */
    public static function getInstance($name = 'default'): \PDO {
        if(!isset(static::$pdoInstances[$name])) {
            $dbConfig = Config::get('db.' . $name);
            $dsn = sprintf('%s:host=%s;dbname=%s', trim($dbConfig['driver']), trim($dbConfig['host']), trim($dbConfig['database']));
            static::$pdoInstances[$name] = new \PDO($dsn, trim($dbConfig['user']), trim($dbConfig['password']), [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . trim($dbConfig['charset']),
            ]);
            if($dbConfig['exceptions'] === true) {
                static::$pdoInstances[$name]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        }
        return static::$pdoInstances[$name];
    }

}