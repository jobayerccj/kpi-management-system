<?php

namespace App\Service;

use App\Entity\IndividualKpi;
use Doctrine\ORM\EntityManagerInterface;

class IndividualKpiService
{
    private const CREATED_BY = 1;
    private const TARGET_SUBMITTED = 1;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly IndividualKpiValidatorService $validatorService
    ) {
    }

    public function createIndividualKpi(array $data): array
    {
        try {
            $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            $individualKpi = new IndividualKpi();
            $individualKpi->setKpiSetupId($data['kpi_setup_id']);
            $individualKpi->setUserId((int) $data['user_id']);
            $individualKpi->setKpiTypeId($data['kpi_type_id']);
            $individualKpi->setPeriodId($data['period_id']);
            $individualKpi->setWeight($data['weight']);
            $individualKpi->setDescription($data['description']);
            $individualKpi->setJanuaryTarget($data['january_target'] ?? null);
            $individualKpi->setFebruaryTarget($data['february_target'] ?? null);
            $individualKpi->setMarchTarget($data['march_target'] ?? null);
            $individualKpi->setAprilTarget($data['april_target'] ?? null);
            $individualKpi->setMayTarget($data['may_target'] ?? null);
            $individualKpi->setJuneTarget($data['june_target'] ?? null);
            $individualKpi->setJulyTarget($data['july_target'] ?? null);
            $individualKpi->setAugustTarget($data['august_target'] ?? null);
            $individualKpi->setSeptemberTarget($data['september_target'] ?? null);
            $individualKpi->setOctoberTarget($data['october_target'] ?? null);
            $individualKpi->setNovemberTarget($data['november_target'] ?? null);
            $individualKpi->setDecemberTarget($data['december_target'] ?? null);
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
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
