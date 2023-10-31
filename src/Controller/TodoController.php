<?php

namespace App\Controller;

use App\Enum\DateFormatEnum;
use App\Service\TodoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todos/index', name: 'todo_index')]
    public function index(): Response
    {
        return $this->render('todo/todo.html.twig', [
            'time' => date(DateFormatEnum::DATE_TIME->value)
        ]);
    }

    #[Route('/todos/{id}', name: 'todos_get_item', requirements: ['id' => '\d+'])]
    public function getItem(int $id, TodoService $service): Response
    {
        $element = $service->getById($id);
        if(!$element) {
            throw new NotFoundHttpException('Item was not found');
        }

        return $this->json($element);
    }

    #[Route('/todos', name: 'todos_get_collection')]
    public function getCollection(TodoService $service): Response
    {
        $elements = $service->getAll();

        if(empty($elements)) {
            throw new NotFoundHttpException('No item was found');
        }

        return $this->json($elements);
    }
}
