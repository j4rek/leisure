<?php

require_once( __DIR__ .'/../ignite/ignition.php');

use \engine\engine;

$engine = new engine();

$engine->turnOn();

$engine->manageRequest();

$engine->response();
