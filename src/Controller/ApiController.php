<?php
namespace App\Controller;

use App\Entity\Calls;
use Monolog\Handler\StdoutHandler;
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
     * @Route("/debug")
     */
    public function debugAction(Request $request)
    {
        var_dump($this->getDoctrine()->getManager());
        die;
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
        $logger->debug('JSON');
        $logger->debug($request->getContent());
        $logger->debug('GET');
        $logger->debug(print_r($_GET ,true ));
        $logger->debug('POST');
        $logger->debug(print_r($_POST ,true ));

        if ($value = $this->getJson($request, 'challenge')) {
            return $this->jsonResponse(['challenge' => $value]);
        }

        if ($request->get('command') == '/lunch') {
            $call = new Calls();
            $call->setClicks(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($call);
            $entityManager->flush();

            return $this->jsonResponse($this->getAttachment($call));
        }

        if ($request->get('payload')) {
            $logger->debug(print_r($request->get('payload') ,true ));

            return new Response('response');
        }

        return new Response('test');
    }

    private function getAttachment(Calls $call)
    {
        return[
            'text' => "Click to increase value",
            "attachments" => [
                [
                    "text" => "Click to increase, now: " . $call->getClicks(),
                    "fallback" => "You are unable increase",
                    "callback_id" => $call->getId(),
                    "color" => "#3AA3E3",
                    "attachment_type" => "default",
                    "actions" => [
                        [
                            "name" => "1",
                            "text" => "+1",
                            "type" => "button",
                            "value" => "1"
                        ],
                        [
                            "name" => "2",
                            "text" => "+2",
                            "type" => "button",
                            "value" => "2"
                        ]
                    ]
                ]
            ],
        ];
    }
}