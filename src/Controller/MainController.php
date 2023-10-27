<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Route as SymfonyRoute;

class MainController extends AbstractController
{
    public function __construct(
        private readonly RouterInterface $router
    ) {
    }

    #[Route('/', name: 'app_main_page')]
    public function index(): Response
    {
        $routes = $this->router->getRouteCollection()->all();
        $myRoutes = array_filter($routes,
            fn ($value, $key) => !str_starts_with($key, '_') && $value->getPath() !== '/',
            ARRAY_FILTER_USE_BOTH);

        $myRoutesPaths = array_map(fn(SymfonyRoute $route) => $route->getPath(), $myRoutes);

        return $this->render('main/index.html.twig', [
            'routes' => $myRoutesPaths,
        ]);
    }
}
