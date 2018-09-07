<?php
namespace App;

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\LoopInterface;
use React\Http\Response;

class Router
{
    private $loop;
    private $routes = [];

    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $path = $request->getUri()->getPath();

        $handler = $this->routes[$path] ?? $this->notFound($path);

        return $handler($request, $this->loop);
    }

    public function add($path, callable $handler)
    {
        $this->routes[$path] = $handler;
    }

    private function notFound($path)
    {
        return function () use ($path) {
            return new Response(
                404,
                ['Content-Type' => 'text/html; charset=UTF-8'],
                "Нет обработчика запроса для $path"
            );
        };
    }


}