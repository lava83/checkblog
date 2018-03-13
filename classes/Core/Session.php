<?php

namespace Core;


class Session
{

    /**
     * @var self
     */
    protected static $instance = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * gets the session singleton instance
     * @return Session
     */
    public static function getInstance()
    {
        if (!(static::$instance instanceof self)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * starts the session if is not startet
     */
    public function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * wrapper to become the session id
     * @return string
     */
    public function id()
    {
        return session_id();
    }

    /**
     * wrapper and help methode to become the session array
     * @return mixed
     */
    public function getPackage()
    {
        return $_SESSION;
    }

    /**
     * adds a session value, this will destroy after next use
     * @param $key
     * @param null $value
     */
    public function addFlash($key, $value = null)
    {
        $_SESSION['flash'][$key] = $value;
    }

    /**
     * check to have a flash message with key: $key
     * @param $key
     * @return bool
     */
    public function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }

    /**
     * gets a session value and destroy it
     * @param $key
     * @return mixed
     */
    public function flash($key)
    {
        $ret = null;
        if (isset($_SESSION['flash'][$key])) {
            $ret = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
        }
        return $ret;
    }

    /**
     * sets a session value
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * gets a session value
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

}