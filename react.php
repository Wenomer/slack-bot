<?php
require_once('vendor/autoload.php');

use React\Promise\Promise;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

$loop = Factory::create();

$server = new Server([function(ServerRequestInterface $request, $next) {
    return $next($request);

}, function (Psr\Http\Message\ServerRequestInterface $request) {
    return new React\Http\Response(
        200,
        ['Content-Type' => 'text/plain'],
        "Hello World2\n"
    );
}]);

$port = getenv('PORT') ;
$port = $port ?: 8000;
$socket = new React\Socket\Server($port, $loop);
$server->listen($socket);

$server->on('error', function (Exception $e) {
    echo "error" . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
});

echo "Server running at http://127.0.0.1:{$port}\n";

$loop->run();