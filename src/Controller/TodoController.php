<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoDto;
use App\Form\TodoType;
use App\Form\Trait\FormHandleTrait;
use App\Service\TodoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todos')]
class TodoController extends AbstractController
{
    use FormHandleTrait;

    public function __construct(
        private readonly TodoService $service
    ) {
    }

    #[Route('/index', name: 'todo_index')]
    public function index(): Response
    {
        $todos = $this->service->getAll();

        return $this->render('todo/todo.html.twig', ['todos' => $todos]);
    }

    #[Route('/{id}', name: 'todos_get_item', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function itemAction(int $id): Response
    {
        $element = $this->service->getById($id);
        if(!$element) {
            throw new NotFoundHttpException('Item was not found');
        }

        return $this->json($element);
    }

    #[Route(name: 'todos_get_collection', methods: ['GET'])]
    public function listAction(): Response
    {
        $todos = $this->service->getAll();

        if(empty($todos)) {
            throw new NotFoundHttpException('No item was found');
        }

        return $this->json($todos);
    }

    #[Route(name: 'todos_create', methods: ['POST'])]
    public function createAction(
        Request $request,
    ): Response
    {
        $form = $this->createForm(TodoType::class);

        if (!$this->handleForm($form, $request)) {
            return $this->json($this->formErrors, $this->responseStatus);
        }

        $this->service->transactionalMake($form->getData());

        return $this->json($form->getData());
    }

    #[Route('/{id}', name: 'todos_update', methods: ['PATCH'])]
    public function updateAction(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $todo = $entityManager->getRepository(Todo::class)->find($id);

        if (!$todo) {
            throw $this->createNotFoundException('Item with the specified ID not found: '.$id);
        }

        $form = $this->createForm(TodoType::class, $todo);

        if (!$this->handleForm($form, $request, true)) {
            return $this->json($this->formErrors, $this->responseStatus);
        }

        $entityManager->flush();

        return $this->json($todo);
    }

    #[Route('/{id}', name: 'todo_delete', methods: ['DELETE'])]
    public function deleteAction(int $id, EntityManagerInterface $entityManager): Response
    {
        $todo = $entityManager->getRepository(Todo::class)->find($id);

        if (!$todo) {
            throw $this->createNotFoundException('Item with the specified ID not found: '.$id);
        }

        $entityManager->remove($todo);
        $entityManager->flush();

        return $this->json(['message' => 'Item deleted successfully']);
    }

}
