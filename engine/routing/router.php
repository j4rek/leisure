<?php
namespace engine\routing;

use \engine\interfaces\routing\iRouter;


class router implements iRouter{
    /**
     * list of application routes
     */
    static private $routes = [];
    
    /**
     * 
     */
    static function registerRoute($type,$route,$controller,$method){
        if(!isset(self::$routes[$type])) self::$routes[$type] = [];

        $route = (preg_match('/\\{1}$/', $route))?substr($route, -1):$route;
        $queryString = preg_split('/\//', $route, null, PREG_SPLIT_NO_EMPTY);
        $pattern = self::createPattern($queryString);
        array_push(self::$routes[$type],[
            'route'         => array_shift($queryString),
            'controller'    => $controller,
            'method'        => $method,
            'parameters'    => self::createParameters($queryString),
            'pattern'       => $pattern
        ]);
    }

    /**
     * 
     */
    public static function verifyRoute(\engine\http\request $request){
        foreach(self::$routes[$request->header('REQUEST_METHOD')] as $_route){
            var_dump($_route['pattern']);
            if(preg_match($_route['pattern'], $request->header('REQUEST_URI'))){
                return $_route;
            }else{
                throw new \Exception('Route not found');
            }
        }
    }

    /**
     * 
     */
    public static function get($route, $controller, $method = 'index'){
        self::registerRoute('GET', $route, $controller, $method);

        #return self;
    }

    /**
     * 
     */
    public static function post(){
        self::registerRoute('POST');

        return self;
    }

    /**
     * 
     */
    public static function put(){
        self::registerRoute('PUT');

        return self;
    }

    /**
     * 
     */
    public static function delete(){
        self::registerRoute('DELETE');

        return self;
    }

    /**
     * 
     */
    private static function createParameters($args){
        $obj = new \stdclass();
        $list = [];
        $patterns = ['/{/', '/}/'];
        foreach($args as $arg){
            $arg = preg_replace($patterns,'',$arg);
            if(preg_match('/\?/', $arg)){
                $obj->name = str_replace('?', '', $arg);
                $obj->required = false;
            }else{
                $obj->name = $arg;
                $obj->required = true;
            }
            array_push($list, $obj);
        }
        return $list;
    }

    /**
     * 
     */
    private static function createPattern($routeParts){
        $str = '(' . array_shift($routeParts) . '){1}';
        foreach($routeParts as $arg){
            if(preg_match('/\?\}/', $arg)){
                $ptrn = '(\/\w+)?';
            }elseif(preg_match('/\}/', $arg)){
                $ptrn = '(\/\w+)';
            }else{
                $ptrn = '(\/' . $arg . '){1}';
            }
            $str .= $ptrn;
        }

        return '/' . $str . '/';
    }
}