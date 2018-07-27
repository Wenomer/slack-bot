<?php
namespace App\Controller;

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
        $logger->debug($request->getContent());

        if ($request->getContent() && $this->getPost($request, 'challenge')) {
            return $this->jsonResponse(['challenge' => $this->getPost($request, 'challenge')]);
        }

        if ($request->getContent() && $this->getPost($request, 'command') == '/lunch') {

            $text = [
                'text' => "Would you like to play a game?",
                "attachments" => [
                    [
                        "text" => "Choose a game to play",
                        "fallback" => "You are unable to choose a game",
                        "callback_id" => "wopr_game",
                        "color" => "#3AA3E3",
                        "attachment_type" => "default",
                        "actions" => [
                            [
                                "name" => "game",
                                "text" => "Chess",
                                "type" => "button",
                                "value" => "chess"
                            ]
                        ]
                    ]
                ],
            ];

            return $this->jsonResponse($text);
        }

        return new Response('test');
    }
}