<?php
require_once('vendor/autoload.php');
$loop = React\EventLoop\Factory::create();

$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) {

    return new React\Http\Response(
        200,
        array('Content-Type' => 'text/plain'),
        "Hello World!\n"
    );
});
$port = getenv('PORT');
$socket = new React\Socket\Server($port, $loop);
$server->listen($socket);

echo "Server running at http://127.0.0.1:{$port}\n";

$loop->run();