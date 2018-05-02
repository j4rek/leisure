<?php
namespace engine\http;

class request{
    /**
     * 
     */
    private $headers;

    /**
     * 
     */
    private $queryArgs;

    /**
     * 
     */
    static function process(){
        $reflection = new request();
        $reflection->headers = (object) $_SERVER;
        $reflection->queryArgs = (object) $_REQUEST;
        return $reflection;
    }

    /**
     * 
     */
    function headers(){
        return $this->headers;
    }

    /**
     * 
     */
    function header($value){
        return $this->headers->{$value};
    }



}