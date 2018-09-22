<?php
namespace engine;

use \engine\interfaces\engine\iEngine;
use \engine\manager\configurationFiles;
use \engine\http\request;
use \engine\http\response;
use \engine\routing\router;
use \config\routing\api;
use \config\routing\web;

class engine implements iEngine{
    private $request;
    private $result;

    public function turnOn(){
        $this->startServices();
        $this->startConfiguration();
        $this->startRouting();
    }

    public function startRouting(){
        $webRoutes = new web();
        $webRoutes->register();
    }

    public function startServices(){

    }

    public function startConfiguration(){
        
    }

    public function manageRequest(){
        $this->request = new request();
        $this->result = router::verifyRoute($this->request);
    }
    
    public function response(){
        $class = new \ReflectionClass('\app\structure\controllers\\' . $this->result['controller']);
        $class->getMethod($this->result['method'])->invoke(new $class->name, $this->request);
    }

}