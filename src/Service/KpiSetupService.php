<?php

namespace App\Service;

use App\Entity\KpiSetup;
use Doctrine\ORM\EntityManagerInterface;

class KpiSetupService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function list(): array
    {
        try {
            $kpiSetups = $this->entityManager->getRepository(KpiSetup::class)->findAll();
            $data = [];
            foreach ($kpiSetups as $kpiSetup) {
                $data[] = [
                    'id' => $kpiSetup->getId(),
                    'title' => $kpiSetup->getTitle(),
                    'status' => $kpiSetup->getStatus(),
                ];
            }

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
