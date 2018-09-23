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
    private $args;

    /**
     * 
     */
    function __construct(){
        $this->headers = (object) $_SERVER;
        $this->queryArgs = (object) $_REQUEST;
        $this->args = new \stdclass();
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

    /**
     * 
     */
    function checkUrlParameters(){
        
    }

    /**
     * 
     */
    function setParameters($route){
        $values = preg_split('/\//', preg_replace('/.+\/(?=' . $route['page'] . ')/', '', $this->header('REQUEST_URI')));
        $parameters = preg_split('/\//', $route['route']);
        foreach($parameters as $key => $parameter){
            if(preg_match('/\{\w+\??\}/', $parameter)){
                $this->args->{preg_replace('/[\}\{\?]/', '', $parameter)} = $values[$key];
            }
        }
    }

    /**
     * 
     */
    function hasParameters(){
        return count(get_object_vars($this->args)) > 0;
    }

    /**
     * 
     */
    function input(){
        return $this->args;
    }
}