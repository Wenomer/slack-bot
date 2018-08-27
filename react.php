<?php
require_once('vendor/autoload.php');

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;
use \React\Socket\Server as Socket;

$loop = Factory::create();

$server = new Server([function(ServerRequestInterface $request, $next) {
    return $next($request);

}, function (ServerRequestInterface $request) {
    return new Response(
        200,
        ['Content-Type' => 'text/plain'],
        "Hello World2\n"
    );
}]);

$port = getenv('PORT') ;
$port = $port ?: 8000;
$socket = new Socket('0.0.0.0:' . $port, $loop);
$server->listen($socket);

$server->on('error', function (Exception $e) {
    echo "error" . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
});

echo "Server running at http://127.0.0.1:{$port}\n";

$loop->run();