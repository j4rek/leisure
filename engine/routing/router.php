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

        array_push(self::$routes[$type],[
            'route'         => $route,
            'controller'    => $controller,
            'method'        => $method
        ]);
    }

    public static function verifyRoute($type, $route){
        foreach(self::$routes[$type] as $_route){
            if($_route['route'] == substr($route,1) ){
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
}