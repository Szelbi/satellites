<?php

namespace App\Controller;

use App\Handler\GetProjectListHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projects/list', name: 'projects_index')]
    public function index(GetProjectListHandler $handler): Response
    {
        $allProjects = $handler->getAllProjects();

        return $this->render('satellite/list.html.twig', [
            'satellites' => $allProjects,
            'time' => date("Y-m-d H:i:s")
        ]);
    }
}
