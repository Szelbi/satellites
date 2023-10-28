<?php

namespace App\Controller;

use App\Service\SatelliteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo')]
    public function list(): Response
    {
        return $this->render('todo/todo.html.twig', [
            'time' => date("Y-m-d H:i:s")
        ]);
    }
}
