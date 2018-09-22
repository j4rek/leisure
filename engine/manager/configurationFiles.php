<?php
namespace engine\manager;

use \engine\interfaces\iConfigurationFiles;

class configurationFiles implements iConfigurationFiles{
    const CFGPATH = 'config';
    const ROUTINGPATH = 'config/routing';
    
    private $configuration;

    /**
     * 
     */
    public function turnOn(){
        $this->configuration = include CFGPATH . '/services.php';
    }

    /**
     * 
     */
    public function fuelUpFiles(){

    }
    
}