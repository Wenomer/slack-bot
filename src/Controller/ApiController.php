<?php
namespace App\Controller;

use App\Entity\Calls;
use GuzzleHttp\Client;
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
            $this->list($logger);
        }

        if ($request->get('command') == '/lunch2') {
            $call = new Calls();
            $call->setClicks1(0);
            $call->setClicks2(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($call);
            $entityManager->flush();

            return $this->jsonResponse($this->getAttachment($call));
        }

        if ($request->get('payload')) {
            $data = json_decode($request->get('payload'), true);
            /* @var $call Calls */
            $call = $this->getDoctrine()->getManager()->find(Calls::class, $data['callback_id']);
            $user = $data['user']['name'];

            foreach ($data['actions'] as $action) {
                $index = $user == 'wenom' ? 1 : 2;

                $call->{'setClicks' . $index}($call->{'getClicks' . $index}() + $action['value']);
                $call->{'setUser' . $index}($user);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($call);
            $entityManager->flush();

            return $this->jsonResponse($this->getAttachment($call));
        }

        return new Response('test');
    }

    private function getAttachment(Calls $call)
    {
        $users = '';
        $users .= $call->getUser1() ? '@' .$call->getUser1() . ': ' . $call->getClicks1() . "\n": '';
        $users .= $call->getUser2() ? '@' .$call->getUser2() . ': ' . $call->getClicks2() . "\n": '';
        $users = $users === '' ? '----' : $users;

        return[
            'text' => "Click to increase value",
            "response_type" => "in_channel",
            "attachments" => [
                [
                    "text" => "Click to increase, now: \n " . $users,
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

    public function post(LoggerInterface $logger)
    {
        $client = new Client([
            'base_uri' => 'https://slack.com/api/',
        ]);
        $response = $client->post('chat.postMessage', [
            'debug' => TRUE,
            'form_params' => [
                'token' => 'xoxb-329104271632-tOhuGbOBQpCiydd2gnldkKMl',
                'channel' => 'D9PRWHVQD',
                'text' => 'hello',
                'as_user' => false
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $logger->debug($response->getStatusCode());
        $logger->debug(print_r($response->getHeaders() ,true ));
    }

    public function list(LoggerInterface $logger)
    {
        $client = new Client([
            'base_uri' => 'https://slack.com/api/',
        ]);
        $response = $client->get('im.list', [
            'debug' => TRUE,
            'query' => [
                'token' => 'xoxb-329104271632-tOhuGbOBQpCiydd2gnldkKMl',
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $logger->debug($response->getStatusCode());
        $logger->debug(print_r($response->getBody()->getContents() ,true ));
    }
}