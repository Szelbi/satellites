<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SatelliteController extends AbstractController
{
    #[Route('/satellite/list')]
    public function list(): Response
    {
        $satellites = [
            "applyforesta.com",
            "az-evisa.com",
            "e-visa-vietnam.com",
            "etaaustraliaonline.com",
            "etacanadaonline.com",
            "evisa-bahrain.com",
            "go-cambodia-online.com",
            "goethiopia.net",
            "gomyanmar.online",
            "oman-evisa.com",
            "status.evisa.express",
            "tanzanianvisa.com",
            "vignette.express",
            "visa-for-egypt.com",
            "visa-for-turkey.com",
            "visa-saudi-arabia.com",
            "visa-sri-lanka.com",
            "crm.evisa.express",
            "united-arab-emirates",
        ];

        return $this->render('satellite/list.html.twig', [
            'satellites' => $satellites,
            'time' => $currentTime = date("Y-m-d H:i:s")
        ]);
    }
}
