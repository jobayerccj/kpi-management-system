<?php

namespace App\Controller\Api\v1;

use App\Service\DepartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/department', name: 'app_api_v1_department_')]
class DepartmentController extends AbstractController
{
    private DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    #[Route('/list', name: 'list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $result = $this->departmentService->list();
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $requestData = [
            'title' => $request->request->get('title') ?? '',
            'slug' => $request->request->get('slug') ?? '',
            'description' => $request->request->get('description') ?? '',
        ];

        $result = $this->departmentService->createDepartment($requestData);

        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/details/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $result = $this->departmentService->details($id);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT', 'PATCH', 'POST'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $requestData = [
            'title' => $request->request->get('title') ?? '',
            'slug' => $request->request->get('slug') ?? '',
            'description' => $request->request->get('description') ?? '',
        ];
        $result = $this->departmentService->updateDepartment($id, $requestData);

        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/delete/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $result = $this->departmentService->delete($id);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
