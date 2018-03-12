<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 11.03.2018
 * Time: 22:25
 */

namespace Core;

use Exceptions\RouterException;

class Router
{

    /**
     * @var array
     */
    protected static $routes = [];

    protected static $path = '';

    protected static $baseUrlPath = '';

    public static function init()
    {
        static::$baseUrlPath = Config::get('app.base_url');
        $parsedBaseUrl = parse_url(static::$baseUrlPath);
        if (isset($parsedBaseUrl['path'])) {
            static::$baseUrlPath = $parsedBaseUrl['path'];
        } else {
            static::$baseUrlPath = $parsedBaseUrl;
        }
        if (substr(static::$baseUrlPath, -1) != '/') {
            static::$baseUrlPath .= '/';
        }
        $parsedUrl = parse_url(getenv('REQUEST_URI'));
        if (isset($parsedUrl['path'])) {
            static::$path = $parsedUrl['path'];
        } else {
            static::$path = '';
        }
    }

    public static function add($expression, $function)
    {
        array_push(static::$routes, [
            'expression' => $expression,
            'function' => $function
        ]);
    }

    public static function run()
    {
        $isRoute = false;
        foreach (static::$routes as $route) {
            $expression = '^' . static::$baseUrlPath . $route['expression'] . '$';
            if (preg_match('%' . $expression . '%', static::$path, $matches)) {
                array_shift($matches);
                if ($route['function'] instanceof \Closure) {
                    call_user_func_array($route['function'], $matches);
                }
                elseif (is_string($route['function'])) {
                    static::workWithControllerAndAction($route['function']);
                }
                elseif (is_array($route['function'])) {
                    if (!isset($route['function']['use'])) {
                        throw new RouterException('The use index must be set.');
                    }
                    if (is_string($route['function']['use'])) {
                        static::workWithControllerAndAction($route['function']['use']);
                    }
                }
                $isRoute = true;
            }
        }
    }

    protected function workWithControllerAndAction($controllerActionPath): void {
        list($controller, $action) = explode('@', $controllerActionPath);
        if (class_exists($controller)) {
            self::triggerControllerAction($controller, $action);
        } else {
            throw new RouterException(sprintf('Cant find controller: %s', $controller));
        }
    }

    protected static function triggerControllerAction($controller, $actionWithoutSuffix): void
    {
        $controllerObject = Application::getInstance()->make($controller);
        $action = $actionWithoutSuffix . 'Action';
        $reflectController = new \ReflectionClass($controllerObject);
        $params = [];
        if ($actionParameters = $reflectController->getMethod($action)->getParameters()) {
            foreach ($actionParameters as $parameter) {
                $reflectionParameterClass = $parameter->getClass();
                if($reflectionParameterClass and $parameterClassName = $reflectionParameterClass->name and class_exists($parameterClassName)) {
                    $params[$parameter->name] = Application::getInstance()->make($parameterClassName);
                }
            }
        }
        $controllerObject->setAction($action);
        $triggeredAction = $controllerObject->dispatch($action, $params);
        if($triggeredAction instanceof View) {
            $triggeredAction->render();
        }
    }
}