<?php
namespace App\Shared\UserInterface\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }
}
