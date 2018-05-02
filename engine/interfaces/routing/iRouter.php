<?php
namespace engine\interfaces\routing;

interface iRouter{
    /**
     * 
     */
    static function registerRoute($type,$route,$controller,$method);

    /**
     * 
     */
    static function verifyRoute($type, $route);
    
    /**
     * 
     */
    static function get($route,$controller,$method = 'index');
    
    /**
     * 
     */
    static function post();
    
    /**
     * 
     */
    static function put();
    
    /**
     * 
     */
    static function delete();

}