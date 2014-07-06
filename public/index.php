<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$application = new \Application\Application();
$request = new \Hamlet\Request\WebRequest();
$response = $application->run($request);
$application->output($request, $response);