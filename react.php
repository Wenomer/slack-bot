<?php
require_once('vendor/autoload.php');

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;
use \React\Socket\Server as Socket;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

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
$host = getenv('HOST') ;

$uri = sprintf('%s:%s', $host, $port);
$socket = new Socket($uri, $loop);
$server->listen($socket);

$server->on('error', function (Exception $e) {
    echo "error" . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
});

echo "Server running at {$uri}\n";

$loop->run();