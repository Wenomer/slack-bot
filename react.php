<?php
require_once('vendor/autoload.php');

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;
use React\Socket\Server as Socket;
use Symfony\Component\Dotenv\Dotenv;
use React\EventLoop\LoopInterface;

if (!getenv('APP_ENV')) {
    (new Dotenv())->load(__DIR__.'/.env');
}

$loop = Factory::create();
$router = new App\Router($loop);

$router->add('/', function (ServerRequestInterface $request, LoopInterface $loop) {
    $childProcess = new \React\ChildProcess\Process('sleep 10');
    $childProcess->start($loop);

//    $childProcess->stdiout

    return new Response(
        200, ['Content-Type' => 'text/plain; charset=UTF-8'], $childProcess->stdout
    );
});

$server = new Server(function (ServerRequestInterface $request) use ($router) {
    return $router($request);
});

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