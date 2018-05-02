<?php
namespace engine\interfaces\database;

interface iDatabase{
    /**
     * 
     */
    function turnOn();
    
    /**
     * 
     */
    function executeQuery();

    /**
     * 
     */
    function turnOff();
}