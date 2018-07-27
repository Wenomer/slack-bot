<?php
namespace App\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Controller implements ContainerAwareInterface
{
    private $container;

    public function jsonResponse(array $data)
    {
        return $this->response(json_encode($data), 200 , ['Content-type' => 'application/json']);
    }

    public function response($data, $status, $headers = [])
    {
        return new Response($data, $status, $headers);
    }

    public function getJson(Request $request, $key)
    {
        $content = $request->getContent();

        if (empty($content)) {
            return null;
        }

        $data  = json_decode($content, true);

        return $data[$key] ?? null;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function get($service)
    {
        return $this->container->get($service);
    }
}