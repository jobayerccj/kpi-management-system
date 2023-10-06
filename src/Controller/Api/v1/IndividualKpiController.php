<?php

namespace App\Controller\Api\v1;

use App\Service\IndividualKpiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/individual/kpi', name: 'app_api_v1_individual_kpi_')]
class IndividualKpiController extends AbstractController
{
    private IndividualKpiService $individualKpiService;
    public function __construct(IndividualKpiService $individualKpiService)
    {
        $this->individualKpiService = $individualKpiService;
    }


    #[Route('/create', name: 'create', methods: ['POST'])]
    public function store(Request $request)
    {
        $requestData = [
            'kpi_setup_id' => $request->request->get('kpi_setup_id') ?? null,
            'kpi_type_id' => $request->request->get('kpi_type_id') ?? null,
            'period_id' => $request->request->get('period_id') ?? null,
        ];
        $result = $this->individualKpiService->createIndividualKpi($requestData);

        if ($result['status']) {
            return $this->json($result, Response::HTTP_CREATED);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
