<?php

namespace App\Service;

use App\Repository\KpiSetupRepository;

class KpiSetupService
{
    private KpiSetupRepository $kpiSetupRepository;

    public function __construct(KpiSetupRepository $kpiSetupRepository)
    {
        $this->kpiSetupRepository = $kpiSetupRepository;
    }

    public function list(): array
    {
        try {
            $data = $this->kpiSetupRepository->getKpiSetupData();

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
