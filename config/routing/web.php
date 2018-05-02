<?php
namespace config\routing;

use \engine\routing\router;

class web extends router{
    function register(){
        $this->get('make', 'primitive');
    }
}