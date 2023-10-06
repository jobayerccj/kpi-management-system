<?php

namespace App\Controller\Api\v1;

use App\Entity\User;
use App\Repository\IndividualKpiRepository;
use App\Service\IndividualKpiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/individual/kpi', name: 'app_api_v1_individual_kpi_')]
class IndividualKpiController extends AbstractController
{
    public function __construct(
        private readonly IndividualKpiService $individualKpiService,
        private readonly IndividualKpiRepository $individualKpiRepository,
        private readonly Security $security
    ) {
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        /** @var User $loggedInUser */
        $loggedInUser = $this->security->getUser();
        $result = $this->individualKpiService->validateWeight(
            $loggedInUser->getId(),
            $request->request->get('weight') ?? 0
        );

        if ($result['status']) {
            $requestData = [
                'kpi_setup_id' => $request->request->get('kpi_setup_id') ?? null,
                'user_id' => $loggedInUser->getId(),
                'kpi_type_id' => $request->request->get('kpi_type_id') ?? null,
                'period_id' => $request->request->get('period_id') ?? null,
                'weight' => $request->request->get('weight') ?? null,
            ];

            $result = $this->individualKpiService->createIndividualKpi($requestData);
            if ($result['status']) {
                return $this->json($result, Response::HTTP_CREATED);
            }
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route('/current-weight', name: 'current-weight', methods: ['GET'])]
    public function currentWeight(): JsonResponse
    {
        /** @var User $loggedInUser */
        $loggedInUser = $this->security->getUser();
        $weight = $this->individualKpiRepository->findUserWiseWeight($loggedInUser->getId());

        return $this->json(['status' => 'success', 'weight' => $weight]);
    }
}
