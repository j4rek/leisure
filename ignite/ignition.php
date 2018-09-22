<?php
/**
* :\> REGISTER AUTOLOAD FUNCTION
* :\> Comment: 
*/

spl_autoload_register('ignition');

# Autoload
function ignition($class){
    $root = explode('\\',$class);
    $file = implode("/", $root);
    
    try{
        require_once dirname(__DIR__) . '/' . $file . '.php';
    }catch(Exception $ex){
        
    }
}
