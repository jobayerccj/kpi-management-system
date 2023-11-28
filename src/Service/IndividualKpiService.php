<?php

namespace App\Service;

use App\Entity\IndividualKpi;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class IndividualKpiService
{
    private const CREATED_BY = 1;
    private const TARGET_SUBMITTED = 1;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly IndividualKpiValidatorService $validatorService,
    ) {
    }

    public function createIndividualKpi(array $data): array
    {
        try {
            $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            $individualKpi = new IndividualKpi();
            $individualKpi->setKpiSetupId($data['kpi_setup_id']);
            $individualKpi->setKpiTypeId($data['kpi_type_id']);
            $individualKpi->setPeriodId($data['period_id']);
            $individualKpi->setCreatedBy(self::CREATED_BY);
            $individualKpi->setStatus(self::TARGET_SUBMITTED);
            $individualKpi->setCreatedAt($date);
            $individualKpi->setUpdatedAt($date);
            $validationResult = $this->validatorService->validateIndividualKpi($individualKpi);

            if (!$validationResult['status']) {
                return $validationResult;
            }

            $this->entityManager->persist($individualKpi);
            $this->entityManager->flush();

            return [
                'status' => true,
                'message' => 'Success! The data has been added',
            ];
        } catch (Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
