<?php

namespace App\Controller;

use App\Entity\Satellite;
use App\Service\SatelliteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SatelliteController extends AbstractController
{
    #[Route('/satellite/list')]
    public function list(SatelliteService $service): Response
    {
        $satellites = $service->getAllSatellites();

        return $this->render('satellite/list.html.twig', [
            'satellites' => $satellites,
            'time' => date("Y-m-d H:i:s")
        ]);
    }
}
