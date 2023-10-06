<?php

namespace App\Service;

use App\Entity\IndividualKpi;
use Doctrine\ORM\EntityManagerInterface;

class IndividualKpiService
{
    private EntityManagerInterface $entityManager;
    private IndividualKpiValidatorService $validatorService;

    public function __construct(EntityManagerInterface $entityManager, IndividualKpiValidatorService $validatorService)
    {
        $this->entityManager = $entityManager;
        $this->validatorService = $validatorService;
    }
    public function createIndividualKpi(array $data): array
    {
        try {
            $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            // Validate department data
            $validationResult = $this->validatorService->validateIndividualKpi($data);

            if (!$validationResult['status']) {
                return $validationResult;
            }

            $department = new IndividualKpi();
            $department->setKpiSetupId($data['kpi_setup_id']);
            $department->setKpiTypeId($data['kpi_type_id']);
            $department->setPeriodId($data['period_id']);
            $department->setCreatedBy(1);
            $department->setStatus(1);
            $department->setCreatedAt($date);
            $department->setUpdatedAt($date);

            $this->entityManager->persist($department);
            $this->entityManager->flush();

            return [
                'status' => true,
                'message' => 'Success! The data has been added',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
