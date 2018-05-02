<?php
namespace engine\interfaces\engine;

interface iEngine{
    
    /**
     * 
     */
    function turnOn();

    /**
     * 
     */
    function startRouting();

    /**
     * 
     */
    function startServices();

    /**
     * 
     */
    function startConfiguration();

    /**
     * 
     */
    function manageRequest();

    /**
     * 
     */
    function response();
}