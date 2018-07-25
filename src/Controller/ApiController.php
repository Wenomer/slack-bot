<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController
{
    /**
    * @Route("/")
    */
    public function number()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/bound")
     */
    public function boundAction(Request $request)
    {
        $challenge = $request->get('challenge');
        error_log($challenge);

        return new Response($challenge);
    }
}