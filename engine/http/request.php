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
    private $page;

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
        $this->setParameters();
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
    function getPage(){
        return $this->page;
    }

    /**
     * 
     */
    function checkUrlParameters(){
        
    }

    /**
     * 
     */
    function setParameters(){
        $url = str_replace(str_replace('index.php','', $this->header('PHP_SELF')),'',$this->header('REQUEST_URI'));
        $params = explode('/',$url);
        $this->page = array_shift($params);
        $this->args = new \stdClass();
        foreach($params as $param){
            $this->args->value = $param;
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