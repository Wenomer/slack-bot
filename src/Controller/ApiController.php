<?php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
    * @Route("/")
    */
    public function number()
    {
        $number = random_int(0, 100);
//var_dump($this->get('logger'));
        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/bound")
     */
    public function boundAction(Request $request)
    {
        var_dump($request->getContent());

        return $this->jsonResponse(['challenge' => $this->getPost($request, 'challenge')]);
    }

    /**
     * @Route("/test")
     */
    public function testAction(Request $request, LoggerInterface $logger)
    {
        $logger->info('test 1');
        $logger->warning('test 2');
        $logger->error('test 3');
        $logger->notice('test 4');
        $logger->critical('test 5');
//        $request->getContent();
        var_dump($request->getContent());

        return new Response('test');
    }
}