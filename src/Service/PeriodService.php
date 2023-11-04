<?php

namespace App\Service;

use App\Entity\Period;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class PeriodService
{
    private EntityManagerInterface $entityManager;
    private PeriodValidatorService $validatorService;

    public function __construct(EntityManagerInterface $entityManager, PeriodValidatorService $validatorService)
    {
        $this->entityManager = $entityManager;
        $this->validatorService = $validatorService;
    }

    public function list(): array
    {
        try {
            $periods = $this->entityManager->getRepository(Period::class)->findAll();
            $data = [];
            foreach ($periods as $period) {
                $data[] = [
                    'id' => $period->getId(),
                    'title' => $period->getTitle(),
                    'slug' => $period->getSlug(),
                ];
            }

            return ['status' => true, 'data' => $data];
        } catch (\Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    public function details(int $id): array
    {
        try {
            $period = $this->entityManager->getRepository(Period::class)->find($id);
            if (!$period) {
                return ['status' => false, 'message' => 'Data not found'];
            }
            $data = [
                'id' => $period->getId(),
                'title' => $period->getTitle(),
                'slug' => $period->getSlug(),
            ];

            return ['status' => true, 'data' => $data];
        } catch (\Exception $th) {
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }

    public function createPeriod(array $data): array
    {
        try {
            $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            // Validate department data
            $validationResult = $this->validatorService->validatePeriod($data);

            if (!$validationResult['status']) {
                return $validationResult;
            }

            $period = new Period();
            $period->setTitle($data['title']);
            $period->setSlug($data['slug']);
            $period->setStatus(1);
            $period->setCreatedAt($date);
            $period->setUpdatedAt($date);

            $this->entityManager->persist($period);
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

    public function updatePeriod(int $id, array $data): array
    {
        try {
            // Fetch the department entity to update
            $department = $this->entityManager->getRepository(Period::class)->find($id);

            if (!$department) {
                return [
                    'status' => false,
                    'message' => 'Period not found',
                ];
            }

            // Validate the updated department data
            $validationResult = $this->validatorService->validatePeriod($data);

            if (!$validationResult['status']) {
                return $validationResult;
            }
            // Update the department entity with the new data
            $department->setTitle($data['title']);
            $department->setSlug($data['slug']);

            $this->entityManager->flush();

            return [
                'status' => true,
                'message' => 'Success! The data has been updated',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function delete(int $id): array
    {
        try {
            $period = $this->entityManager->getRepository(Period::class)->find($id);
            if (!$period) {
                return ['status' => false, 'message' => 'Data not found'];
            }
            $this->entityManager->remove($period);
            $this->entityManager->flush();

            return ['status' => true, 'message' => 'Success! The data has been deleted.'];
        } catch (\Exception $th) {
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }
}
