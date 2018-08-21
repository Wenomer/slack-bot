<?php
require_once('vendor/autoload.php');
$i = 0;
$app = function ($request, $response) use (&$i) {
    $i++;
    $text = "This is request number $i.\n";
    $headers = array('Content-Type' => 'text/plain');
    $response->writeHead(200, $headers);
    $response->end($text);
};
$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server('8080', $loop);
$http = new React\Http\Server($socket);
$http->on('request', $app);

$server->listen($socket);

$loop->run();