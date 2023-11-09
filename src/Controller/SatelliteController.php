<?php

namespace App\Controller;

use App\Service\SatelliteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SatelliteController extends AbstractController
{
    #[Route('/satellites/list', name: 'satellites_index')]
    public function index(SatelliteService $service): Response
    {
        $satellites = $service->getAllSatellites();

        return $this->render('satellite/list.html.twig', [
            'satellites' => $satellites,
            'time' => date("Y-m-d H:i:s")
        ]);
    }
}
