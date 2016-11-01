<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

use Mubu\Route\RouteRequest;
use Mubu\Error\Error;
use Mubu\Http\Http;
use Mubu\Exception\ExceptionHandler;

class Route
{
    private static $routes = [];
    private static $middlewares = [];
    private static $groups = [];
    private static $patterns = [
        '{a}' => '([^/]+)',
        '{d}' => '([0-9]+)',
        '{i}' => '([0-9]+)',
        '{s}' => '([a-zA-Z]+)',
        '{w}' => '([a-zA-Z0-9_]+)',
        '{u}' => '([a-zA-Z0-9_-]+)',
        '{*}' => '(.*)'
    ];
    private static $namespaces = [
        'middlewares' => 'App\Middlewares\\',
        'controllers' => 'App\Controllers\\'
    ];
    private static $errorCallback;


    /**
    * Add route method; Get, Post, Put, Patch, Any, Ajax... 
    *
    * @return new self
    */
    public static function __callStatic($method, $params)
    {
        if(is_null($params))
            return;

        $route = $params[0];
        $callback = $params[1];
        $settings = null;

        if(count($params) > 2)
        {
            $settings = $params[1];
            $callback = $params[2];
        }

        if(strstr($route, '{'))
        {
            $route1 = $route2 = '';
            foreach(explode('/', $route) as $key => $value)
            {
                if($value != '')
                {
                    if(!strpos($value, '?'))
                        $route1 .= '/' . $value;
                    else
                    {
                        if($route2 == '')
                            self::addRoute($route1, $method, $callback, $settings);

                        $route2 = $route1 . '/' . str_replace('?', '', $value);
                        self::addRoute($route2, $method, $callback, $settings);
                        $route1 = $route2;
                    }
                }
            }

            if($route2 == '')
                self::addRoute($route1, $method, $callback, $settings);
        }
        else
            self::addRoute($route, $method, $callback, $settings);

        return new self;
    }

    /**
    * Add new route rules pattern; String or Array 
    *
    * @return new self
    */
    public static function pattern($pattern, $attr = null)
    {
        if(is_array($pattern))
        {
            foreach ($pattern as $key => $value)
                if(!in_array('{' . $key . '}', array_keys(self::$patterns)))
                    self::$patterns['{' . $key . '}'] = '(' . $value . ')';
                else
                    throw new ExceptionHandler('<h2>Opps! Error.</h2> <b>' . $key . '</b> pattern cannot be changed.');
        }
        else
        {
            if(!in_array('{' . $pattern . '}', array_keys(self::$patterns)))
                self::$patterns['{' . $pattern . '}'] = '(' . $attr . ')';
            else
                throw new ExceptionHandler('<h2>Opps! Error.</h2> <b>' . $pattern . '</b> pattern cannot be changed.');
        }

        return new self;
    }

    /**
    * Add new middleware; Closure, Method or Middleware Class 
    *
    * @return null
    */
    public static function middleware($name, $command)
    {
        self::$middlewares[$name] = $command;
    }


    /**
    * Add new route method one or more http methods.
    *
    * @return null
    */
    public static function add($methods, $route, $settings, $callback = null)
    {
        if(is_null($callback))
        {
            $callback = $settings;
            $settings = null;
        }

        if(strstr($methods, '|'))
            foreach (array_unique(explode('|', $methods)) as $method)
                if($method != '')
                    self::{strtolower($method)}($route, $settings, $callback);
        else
            self::{strtolower($method)}($route, $settings, $callback);
    }

    /**
    * Add new Route and it's settings
    *
    * @return null
    */
    private static function addRoute($uri, $method, $callback, $settings)
    {
        $groupItem = count(self::$groups) - 1;
        $group = '';

        if($groupItem > -1)
            foreach (self::$groups as $key => $value)
                $group .= $value['route'];

        $route = rtrim(dirname(http::server('PHP_SELF')) . $group . '/' . trim($uri, '/'), '/');

        if($route == dirname(http::server('PHP_SELF')))
            $route .= '/';

        $data = [
            'route' => $route,
            'method' => strtoupper($method),
            'callback' => (is_object($callback) ? $callback : self::$namespaces['controllers'] . $callback),
            'alias' => (isset($settings['alias']) ? $settings['alias'] : (isset($settings['as']) ? $settings['as'] : null)),
            'before' => (isset($settings['before']) ? (is_object($settings['before']) ? $settings['before'] : (strstr($settings['before'], '@') ? self::$namespaces['middlewares'] . $settings['before'] : $settings['before'] )) : null),
            'after' => (isset($settings['after']) ? (is_object($settings['after']) ? $settings['after'] : (strstr($settings['after'], '@') ? self::$namespaces['middlewares'] . $settings['after'] : $settings['after'] )) : null),
            'group' => ($groupItem === -1) ? null : self::$groups[$groupItem]
        ];
        array_push(self::$routes, $data);
    }
    
    /**
    * Run Routes
    *
    * @return true | throw Exception
    */
    public static function run()
    {
        $uri = parse_url(http::server('REQUEST_URI'), PHP_URL_PATH);
        if((str_replace('/', '', $uri) != BASE_FOLDER) && (substr($uri, -1) == '/'))
            $uri = substr($uri, 0, (strlen($uri)-1));

        $method = RouteRequest::getRequestMethod();

        $searches = array_keys(static::$patterns);
        $replaces = array_values(static::$patterns);

        $foundRoute = false;

        $routes = [];
        foreach (self::$routes as $data)
            array_push($routes, $data['route']);

        // check if route is defined without regex
        if (in_array($uri, array_values($routes)))
        {
            foreach (self::$routes as $data)
            {
                if (RouteRequest::validMethod($data['method'], $method) && ($data['route'] == $uri))
                {
                    $foundRoute = true;

                    self::runRouteMiddleware($data, 'before');
                    self::runRouteCommand($data['callback']);
                    self::runRouteMiddleware($data, 'after');

                    break;
                }
            }
        }
        else
        {
            foreach (self::$routes as $data)
            {
                $route = $data['route'];

                if (strpos($route, '{') !== false)
                    $route = str_replace($searches, $replaces, $route);

                if (preg_match('#^' . $route . '$#', $uri, $matched))
                {
                    if (RouteRequest::validMethod($data['method'], $method))
                    {
                        $foundRoute = true;

                        self::runRouteMiddleware($data, 'before');

                        array_shift($matched);
                        $newMatched = [];
                        foreach ($matched as $key => $value)
                        {
                            if(strstr($value, '/'))
                                foreach (explode('/', $value) as $k => $v)
                                    $newMatched[] = trim(urldecode($v));
                            else
                                $newMatched[] = trim(urldecode($value));
                        }
                        $matched = $newMatched;

                        self::runRouteCommand($data['callback'], $matched);
                        self::runRouteMiddleware($data, 'after');

                        break;
                    }
                }
            }
        }

        // If it originally was a HEAD request, clean up after ourselves by emptying the output buffer
        if (strtoupper(http::server('REQUEST_METHOD')) == 'HEAD')
            ob_end_clean();

        if ($foundRoute == false)
        {
            if (!self::$errorCallback)
            {
                self::$errorCallback = function()
                {
                    header(http::server('SERVER_PROTOCOL') . " 404 Not Found");
                    throw new ExceptionHandler('<h2>Bad Request</h2> Looks like something went wrong. Please try again.');
                };
            }

            call_user_func(self::$errorCallback);
        }
    }

    /**
    * Run Route Command; Controller or Closure
    *
    * @return null
    */
    private static function runRouteCommand($command, $params = null)
    {
        if(!is_object($command))
        {
            $parts = explode('/', $command);
            $segments = explode('@', end($parts));

            $controllerFile = realpath(__DIR__ . '/../../app/Controllers/' . strtolower(str_replace(self::$namespaces['controllers'], '', $segments[0])) . '.php');

            if(count($parts) > 1)
                $controllerFile = realpath(__DIR__ . '/../../app/Controllers/' . $parts[0] . '/' . strtolower($segments[0]).'.php');

            if(!file_exists($controllerFile))
                throw new ExceptionHandler('<h2>Opps! Error</h2> <b>' . $segments[0] . '</b> Controller File is not found. Please, check file.');

            require_once($controllerFile);
            $controller = new $segments[0]();

            if(!is_null($params) && in_array($segments[1], get_class_methods($controller)))
                echo call_user_func_array([$controller, $segments[1]], $params);
            elseif(is_null($params) && in_array($segments[1], get_class_methods($controller)))
                echo call_user_func([$controller, $segments[1]]);
            else
                throw new ExceptionHandler('<h2>Oppps!</h2><b>' . $segments[1] . '</b> method is not found in <b>'.$segments[0].'</b> controller. Please, check file.');
        }
        else
            if(!is_null($params))
                echo call_user_func_array($command, $params);
            else
                echo call_user_func($command);
    }

    /**
    * Detect Routes Middleware; before or after
    *
    * @return null
    */
    private static function runRouteMiddleware($middleware, $type)
    {
        if($type == 'before')
        {
            if(!is_null($middleware['group']))
                self::beforeAfterCommand($middleware['group'][$type]);

            self::beforeAfterCommand($middleware[$type]);
        }
        else
        {
            self::beforeAfterCommand($middleware[$type]);

            if(!is_null($middleware['group']))
                self::beforeAfterCommand($middleware['group'][$type]);
        }
    }

    /**
    * Run Route Middlewares 
    *
    * @return true | false
    */
    private static function beforeAfterCommand($command)
    {
        if(!is_null($command))
        {
            if(is_array($command))
                foreach ($command as $key => $value)
                    self::beforeAfterCommand($value);

            elseif(is_object($command))
                return call_user_func($command);

            elseif(strstr($command, '@'))
            {
                $parts = explode('/', $command);
                $segments = explode('@', end($parts));

                $middlewareFile = realpath(__DIR__ . '/../../app/Middlewares/' . strtolower(str_replace(self::$namespaces['middlewares'], '', $segments[0])) . '.php');

                if(count($parts) > 1)
                    $middlewareFile = realpath(__DIR__ . '/../../app/Middlewares/' . $parts[0] . '/' . strtolower(str_replace(self::$namespaces['middlewares'], '', $segments[0])) .'.php');

                if(!file_exists($middlewareFile))
                    throw new ExceptionHandler('<h2>Oppps!</h2><b>' . $segments[0] . '</b> middleware file is not found. Please, check file.');

                require_once($middlewareFile);
                $controller = new $segments[0]();

                if(in_array($segments[1], get_class_methods($controller)))
                    return $controller->$segments[1]();
                else
                    throw new ExceptionHandler('<h2>Oppps!</h2><b>' . $segments[1] . '</b> method is not found in <b>'.$segments[0].'</b> middleware. Please, check file.');
            }
            else
            {
                if(!is_null(self::$middlewares[$command]) && isset(self::$middlewares[$command]))
                    self::beforeAfterCommand(self::$middlewares[$command]);
                else
                    return false;
            }
        }
        else
            return false;
    }

    /**
    * Routes Group 
    *
    * @return null
    */
    public static function group($name, $settings = null, $callback = null)
    {
        $groupName = trim($name, '/');
        $group['route'] = '/' . $groupName;
        $group['before'] = $group['after'] = null;

        if(is_null($callback))
            $callback = $settings;
        else
        {
            $group['before'] = (!isset($settings['before']) ? null : $settings['before']);
            $group['after']  = (!isset($settings['after']) ? null : $settings['after']);
        }

        $groupCount = count(self::$groups) - 1;
        if($groupCount > -1)
        {
            foreach (self::$groups as $key => $value)
            {
                $list['before'][] = $value['before'];
                $list['after'][] = $value['after'];
            }

            if(!is_null($group['before']))
                $list['before'][] = $group['before'];

            if(!is_null($group['after']))
                $list['after'][] = $group['after'];

            $group['before'] = $list['before'];
            $group['after'] = $list['after'];
        }

        array_push(self::$groups, $group);

        if(is_object($callback))
            call_user_func($callback);

        self::endGroup();
    }

    /**
    * Routes Group endpoint
    *
    * @return null
    */
    private static function endGroup()
    {
        array_pop(self::$groups);
    }   

    /**
    * Added route from methods of Controller file. 
    *
    * @return null
    */
    public static function controller($route, $controller)
    {
        $controllerFile = realpath(__DIR__ . '/../../app/Controllers/' . strtolower($controller) . '.php');

        if(file_exists($controllerFile))
        {
            if(!class_exists($controller))
                $req = require($controllerFile);
        }
        else
            throw new ExceptionHandler("<b>" . $controller . "</b> controller file is not found! Please, check file.");

        $classMethods = get_class_methods(self::$namespaces['controllers'] . $controller);

        if($classMethods)
        {
            foreach ($classMethods as $methodName)
            {
                if(!strstr($methodName, '__'))
                {
                    $method = "any";
                    foreach(explode('|', RouteRequest::$validMethods) as $m)
                    {
                        if(stripos($methodName, strtolower($m), 0) === 0)
                        {
                            $method = strtolower($m);
                            break;
                        }
                    }

                    $methodVar = lcfirst(str_replace($method, '', $methodName));

                    $r = new \ReflectionMethod(self::$namespaces['controllers'] . $controller, $methodName);
                    $paramNum = $r->getNumberOfRequiredParameters();
                    $paramNum2 = $r->getNumberOfParameters();

                    $value = ($methodVar == 'main' ? $route : $route . '/' . $methodVar);

                    self::{$method}(($value . str_repeat('/{a}', $paramNum) . str_repeat('/{a?}', $paramNum2 - $paramNum)), ($controller . '@' . $methodName));
                }
            }

            unset($r);
        }

        $req = null;
    }

    /**
    * Routes error function. (Closure)
    *
    * @return null
    */
    public static function error(Closure $callback)
    {
        self::$errorCallback = $callback;
    }

    /**
    * Display all Routes.
    *
    * @return null
    */
    public static function getList()
    {
        echo '<pre style="border:1px solid #eee;padding:0 10px;width:960px;max-height:780;margin:20px auto;font-size:17px;overflow:auto;">';
        var_dump(self::getRoutes());
        echo '</pre>';
        die();
    }

    /**
    * Get all Routes
    *
    * @return mixed
    */
    public static function getRoutes()
    {
        return self::$routes;
    }
}
