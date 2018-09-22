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
    static function verifyRoute(\engine\http\request $request);
    
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