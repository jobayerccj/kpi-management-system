<?php

namespace App\Service;

use App\Repository\KpiSetupRepository;
use Exception;

class KpiSetupService
{
    public function __construct(private readonly KpiSetupRepository $kpiSetupRepository)
    {
    }

    public function list(): array
    {
        try {
            $data = $this->kpiSetupRepository->getKpiSetupData();

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
