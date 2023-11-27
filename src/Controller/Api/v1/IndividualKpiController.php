<?php

namespace App\Controller\Api\v1;

use App\Repository\IndividualKpiRepository;
use App\Service\IndividualKpiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/individual/kpi', name: 'app_api_v1_individual_kpi_')]
class IndividualKpiController extends AbstractController
{
    private IndividualKpiService $individualKpiService;
    private IndividualKpiRepository $individualKpiRepository;
    private $userId = 1;

    public function __construct(
        IndividualKpiService $individualKpiService,
        IndividualKpiRepository $individualKpiRepository
    ) {
        $this->individualKpiService = $individualKpiService;
        $this->individualKpiRepository = $individualKpiRepository;
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $weight = $this->checkWeight($this->userId);
        if ($weight + $request->request->get('weight') > 100) {
            return $this->json(['status' => false,
                'message' => 'You have reached your weight limit. Your current weight ' . $weight]);
        }
        $requestData = [
            'kpi_setup_id' => $request->request->get('kpi_setup_id') ?? null,
            'user_id' => $request->request->get('user_id') ?? 1,
            'kpi_type_id' => $request->request->get('kpi_type_id') ?? null,
            'period_id' => $request->request->get('period_id') ?? null,
            'weight' => $request->request->get('weight') ?? null,
        ];
        $result = $this->individualKpiService->createIndividualKpi($requestData);

        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/current-weight/{user_id}', name: 'current-weight', methods: ['GET'])]
    public function currentWeight($user_id): JsonResponse
    {
        $weight = $this->checkWeight($user_id);

        return $this->json(['status' => 'success', 'weight' => $weight]);
    }

    public function checkWeight(int $userId): int
    {
        return $this->individualKpiRepository->findUserWiseWeight($userId) ?? 0;
    }
}
