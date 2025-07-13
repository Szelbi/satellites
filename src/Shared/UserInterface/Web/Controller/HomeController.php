<?php
namespace App\Shared\UserInterface\Web\Controller;

use App\Shared\Application\Dto\MenuItemDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(): Response
    {
        $menuItems = [
            new MenuItemDto('contact_form_index', 'menu.contact_form', 'envelope'),
            new MenuItemDto('todo_index', 'menu.todo', 'list-check'),
            new MenuItemDto('weather_index', 'menu.weather', 'cloud-sun'),
            new MenuItemDto('lucky_number_index', 'menu.lucky_number', 'dice-6'),
            new MenuItemDto('projects_index', 'menu.projects', 'folder'),
        ];

        return $this->render('main/index.html.twig', [
            'menuItems' => $menuItems,
        ]);
    }
}
