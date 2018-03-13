<?php

namespace Core;

use Exceptions\ApplicationException;
use Exceptions\ConfigException;
use function Sodium\add;

/**
 * Class Application
 * @package Core
 */
class Application
{

    /**
     * @var Application
     */
    protected static $instance = null;

    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * the base or work path of the application
     * @var null
     */
    protected $applicationBasePath = null;

    /**
     *
     * singleton class __constructor
     *
     * Application constructor.
     */
    protected function __construct()
    {
    }

    /**
     * singleton class __clone
     */
    protected function __clone()
    {
    }

    /**
     * @return Application
     */
    public static function getInstance()
    {
        if (!(static::$instance instanceof self)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * sets the application base path
     * @param $applicationBasePath
     * @throws ApplicationException
     */
    public function setApplicationBasePath($applicationBasePath)
    {
        if (!is_dir($applicationBasePath)) {
            throw new ApplicationException(sprintf('The application path: %s doesnt exists.', $this->applicationBasePath));
        }
        $this->applicationBasePath = $applicationBasePath;
    }

    /**
     * initiliaze the application with default data and config
     * @throws ApplicationException
     * @throws \Exception
     */
    public function init()
    {
        if ($this->initialized === false) {
            if (empty($this->applicationBasePath)) {
                throw new ApplicationException('Please set the application path!');
            }
        }
        $this->setEnvironment();
        $this->initializeSession();
        $this->initializeConfig();
        $this->initializeRouter();
    }

    /**
     * run the application cowboy
     * @throws ApplicationException
     * @throws \Exception
     */
    public function run()
    {
        if ($this->initialized === false) {
            $this->init();
        }
        Router::run();
    }

    public function make($applicationClass) {
        if(!class_exists($applicationClass)) {
            throw new ApplicationException(sprintf('The class: %s doesnt exists', $applicationClass));
        }
        $reflectApplicationClass = new \ReflectionClass($applicationClass);
        $params = [];
        if($reflectApplicationClass->hasMethod('__construct') && $constructParameters = $reflectApplicationClass->getConstructor()->getParameters()) {
            foreach ($constructParameters as $reflectionParameter) {
                $reflectionParameterClass = $reflectionParameter->getClass();
                if($reflectionParameterClass and $parameterClassName = $reflectionParameterClass->name and class_exists($parameterClassName)) {
                    $params[$reflectionParameter->name] = $this->make($parameterClassName);
                }
            }
        }
        if($reflectApplicationClass->hasMethod('getInstance') && $reflectApplicationClass->getMethod('getInstance')->isStatic()) {
            //singleton instance
            $instance = call_user_func($applicationClass . '::getInstance');
        } else {
            $instance = $reflectApplicationClass->newInstanceArgs($params);
        }
        return $instance;
    }

    /**
     * sets environment variables if .env file exists
     */
    protected function setEnvironment()
    {
        $envPath = $this->applicationBasePath . DIRECTORY_SEPARATOR . '.env';
        if (file_exists($envPath) && is_readable($envPath)) {
            if ($fh = fopen($envPath, 'r')) {
                while (($data = fgets($fh)) !== false) {
                    putenv($data);
                }
            }
        }
    }

    /**
     * initialize ower application configuration
     * @throws \Exception
     */
    protected function initializeConfig(): void
    {
        try {
            Config::addDir($this->applicationBasePath . DIRECTORY_SEPARATOR . 'config');
            Config::init();
        } catch (ConfigException $e) {
            throw new \Exception('Cant initialize configuration.');
        }
    }

    protected function initializeRouter(): void
    {
        Router::init();
        $webRoutesFilePath = $this->applicationBasePath . DIRECTORY_SEPARATOR . 'routes/web.php';
        if (file_exists($webRoutesFilePath)) {
            require_once $webRoutesFilePath;
        }
    }

    protected function initializeSession(): void
    {
        /** @var Session $session */
        $session = $this->make(Session::class);
        $session->start();
    }
}