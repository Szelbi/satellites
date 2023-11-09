<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_page')]
    public function index(RouterInterface $router): Response
    {
        $routes = $router->getRouteCollection()->all();
        $myRoutes = array_filter(array_keys($routes), fn(string $key) => str_contains($key, 'index'));

        $formattedRoutes = [];
        foreach ($myRoutes as $route) {
            $formattedRoutes[$route] = ucwords(str_replace(['_index', '_'], ['', ' '], $route));
        }

        return $this->render('main/index.html.twig', [
            'routes' => $formattedRoutes,
        ]);
    }
}
