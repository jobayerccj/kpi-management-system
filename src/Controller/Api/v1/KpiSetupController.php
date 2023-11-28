<?php

namespace App\Controller\Api\v1;

use App\Service\KpiSetupService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/kpi/setup', name: 'app_api_v1_kpi_setup_')]
class KpiSetupController extends AbstractController
{
    public function __construct(
        private readonly KpiSetupService $kpiSetupService
    ) {
    }

    #[Route('/list', name: 'list', methods: ['GET'])]
    public function index(): Response
    {
        $result = $this->kpiSetupService->list();
        if ($result['status']) {
            return $this->json($result, Response::HTTP_OK);
        }

        return $this->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
