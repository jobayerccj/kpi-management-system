<?php

namespace App\Controller\Api\v1;

use App\Service\KpiTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/kpi-type', name: 'app_api_v1_kpi_type_')]
class KpiTypeController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function index(KpiTypeService $kpiTypeService): JsonResponse
    {
        $result = $kpiTypeService->list();
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }
        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function store(Request $request, KpiTypeService $kpiTypeService): JsonResponse
    {
        $requestData = [
            'title' => $request->request->get('title') ?? '',
            'slug' => $request->request->get('slug') ?? '',
        ];
        $result = $kpiTypeService->createKpiType($requestData);

        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/details/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(KpiTypeService $kpiTypeService, int $id): JsonResponse
    {
        $result = $kpiTypeService->details($id);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }
        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT', 'PATCH', 'POST'])]
    public function update(Request $request, int $id, KpiTypeService $kpiTypeService): JsonResponse
    {
        $requestData = [
            'title' => $request->request->get('title') ?? '',
            'slug' => $request->request->get('slug') ?? '',
        ];
        $result = $kpiTypeService->updateKpiType($id, $requestData);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(KpiTypeService $kpiTypeService, int $id): JsonResponse
    {
        $result = $kpiTypeService->delete($id);
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }
        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
