<?php

namespace App\Service;

use App\Entity\IndividualKpi;
use App\Repository\IndividualKpiRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class IndividualKpiService
{
    private const CREATED_BY = 1;
    private const TARGET_SUBMITTED = 1;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly IndividualKpiValidatorService $validatorService,
        private readonly IndividualKpiRepository $individualKpiRepository
    ) {
    }

    public function createIndividualKpi(array $data): array
    {
        try {
            $date = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            $individualKpi = new IndividualKpi();
            $individualKpi->setKpiSetupId($data['kpi_setup_id']);
            $individualKpi->setUserId($data['user_id']);
            $individualKpi->setKpiTypeId($data['kpi_type_id']);
            $individualKpi->setPeriodId($data['period_id']);
            $individualKpi->setWeight($data['weight']);
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

    public function validateWeight(int $userId, int $currentWeight): array
    {
        $existingWeight = $this->individualKpiRepository->findUserWiseWeight($userId) ?? 0;
        if ($existingWeight + $currentWeight > 100) {
            return [
                'status' => false,
                'message' => sprintf('You have reached your weight limit. Your current weight %d', $existingWeight)
            ];
        }

        return [
            'status' => true
        ];
    }
}
