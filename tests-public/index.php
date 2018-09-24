<?php

include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/../tests-src/Server.php';


$server = new Server();
$server->run();

