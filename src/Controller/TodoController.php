<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Service\TodoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\InvalidMetadataException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    public function __construct(
        private readonly TodoService $service
    ) {
    }

    #[Route('/todos/index', name: 'todo_index')]
    public function index(): Response
    {
        $todos = $this->service->getAll();

        return $this->render('todo/todo.html.twig', ['todos' => $todos]);
    }

    #[Route('/todos/{id}', name: 'todos_get_item', requirements: ['id' => '\d+'])]
    public function itemAction(int $id): Response
    {
        $element = $this->service->getById($id);
        if(!$element) {
            throw new NotFoundHttpException('Item was not found');
        }

        return $this->json($element);
    }

    #[Route('/todos', name: 'todos_get_collection', methods: ['GET'])]
    public function listAction(): Response
    {
        $todos = $this->service->getAll();

        if(empty($todos)) {
            throw new NotFoundHttpException('No item was found');
        }

        return $this->json($todos);
    }

    #[Route('/todos', name: 'todos_create', methods: ['POST'])]
    public function createAction(Request $request): Response
    {
        $requestData = json_decode($request->getContent());

        if(!isset($requestData->label)) {
            throw new InvalidMetadataException('Wrong JSON data');
        }

        $todo = new Todo();
        $todo->setLabel($requestData->label);

        $this->service->transactionalMake($todo);

        return $this->json($todo);
    }
}
