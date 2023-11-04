<?php

namespace App\Controller\Api\v1;

use App\Service\PeriodService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/period', name: 'app_api_v1_period_')]
class PeriodController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function index(PeriodService $periodService): JsonResponse
    {
        $result = $periodService->list();
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }
        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function store(Request $request, PeriodService $periodService): JsonResponse
    {
        $requestData = [
            'title' => $request->request->get('title') ?? '',
            'slug' => $request->request->get('slug') ?? '',
        ];

        $result = $periodService->createPeriod($requestData);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/details/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(PeriodService $periodService, int $id): JsonResponse
    {
        $result = $periodService->details($id);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }
        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT', 'PATCH', 'POST'])]
    public function update(Request $request, int $id, PeriodService $periodService): JsonResponse
    {
        $requestData = [
            'title' => $request->request->get('title') ?? '',
            'slug' => $request->request->get('slug') ?? '',
        ];
        $result = $periodService->updatePeriod($id, $requestData);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(PeriodService $periodService, int $id): JsonResponse
    {
        $result = $periodService->delete($id);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }
        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
