<?php

namespace App\Controller;

use App\Service\SatelliteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projects/list')]
    public function list(SatelliteService $service): Response
    {
        $allProjects = $service->getAllProjects();

        return $this->render('satellite/list.html.twig', [
            'satellites' => $allProjects,
            'time' => date("Y-m-d H:i:s")
        ]);
    }
}
