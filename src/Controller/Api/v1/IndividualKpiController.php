<?php

namespace App\Controller\Api\v1;

use App\Entity\User;
use App\Repository\IndividualKpiRepository;
use App\Service\IndividualKpiService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
        $result = $this->individualKpiService->createIndividualKpi($request->request->all());
        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/current-weight', name: 'current-weight', methods: ['GET'])]
    public function currentWeight(): JsonResponse
    {
        /** @var User $loggedInUser */
        $loggedInUser = $this->security->getUser(); // TODO: Need to discuss for Admin user
        $weight = $this->individualKpiRepository->findUserWiseWeight($loggedInUser->getId());

        return $this->json(['status' => 'success', 'weight' => $weight]);
    }
}
