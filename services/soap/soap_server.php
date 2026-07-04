<?php
require_once __DIR__ . '/UserService.php';

ini_set("soap.wsdl_cache_enabled", "0");

$server = new SoapServer(null, [
    'uri' => 'http://localhost/mglsi-news-v3/services/soap/UserService',
]);
$server->setClass('UserService');
$server->handle();