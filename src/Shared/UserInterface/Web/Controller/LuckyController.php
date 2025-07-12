<?php
namespace App\Shared\UserInterface\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number', name: 'lucky_number_index')]
    public function index(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route('/lucky/number/get', name: 'lucky_number_get')]
    public function randomNumberGet(): Response
    {
        $number = random_int(0, 100);

        return new JsonResponse(['number' => $number], Response::HTTP_OK);
    }
}
