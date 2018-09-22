<?php
namespace app\structure\controllers;

use \engine\structure\controller;
use \engine\http\request;

class primitive extends controller{
    
    function index(request $request){
        debug($request);
        echo 'primitive';
    }
}