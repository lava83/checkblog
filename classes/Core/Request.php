<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 12.03.18
 * Time: 14:45
 */

namespace Core;


class Request
{

    protected $data = [];

    public function __construct()
    {
        $this->init();
    }

    public function init() {
        foreach($_GET as $key => $value) {
            $this->set($key, $value);
        }
        foreach($_POST as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function isPost() {
        return getenv('REQUEST_METHOD') === 'POST';
    }

    public function getAll() {
        return $this->data;
    }

    public function get($key) {
        if(isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }

    protected function set($key, $value) {
        $this->data[$key] = $value;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __get($name)
    {
        return $this->get($name);
    }


}