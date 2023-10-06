<?php

namespace App\Service;

use App\Entity\KpiType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class KpiTypeService
{
    private EntityManagerInterface $entityManager;
    private KpiTypeValidatorService $validatorService;

    public function __construct(EntityManagerInterface $entityManager, KpiTypeValidatorService $validatorService)
    {
        $this->entityManager = $entityManager;
        $this->validatorService = $validatorService;
    }

    public function list(): array
    {
        try {
            $kpiTypes = $this->entityManager->getRepository(KpiType::class)->findAll();
            $data = [];
            foreach ($kpiTypes as $kpiType) {
                $data[] = [
                    'id' => $kpiType->getId(),
                    'title' => $kpiType->getTitle(),
                    'slug' => $kpiType->getSlug(),
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

    public function details(int $id): array
    {
        try {
            $kpiType = $this->entityManager->getRepository(KpiType::class)->find($id);
            if (!$kpiType) {
                return [
                    'status' => false,
                    'message' => 'Data not found',
                    ];
            }
            $data = [
                'id' => $kpiType->getId(),
                'title' => $kpiType->getTitle(),
                'slug' => $kpiType->getSlug(),
            ];

            return ['status' => true, 'data' => $data];
        } catch (\Exception $th) {
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }

    public function createKpiType(array $data): array
    {
        try {
            $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            // Validate kpiType data
            $validationResult = $this->validatorService->validateKpiType($data);

            if (!$validationResult['status']) {
                return $validationResult;
            }

            $kpiType = new KpiType();
            $kpiType->setTitle($data['title']);
            $kpiType->setSlug($data['slug']);
            $kpiType->setStatus(1);
            $kpiType->setCreatedAt($date);
            $kpiType->setUpdatedAt($date);

            $this->entityManager->persist($kpiType);
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

    public function updateKpiType(int $id, array $data): array
    {
        try {
            $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            // Fetch the kpiType entity to update
            $kpiType = $this->entityManager->getRepository(KpiType::class)->find($id);

            if (!$kpiType) {
                return [
                    'status' => false,
                    'message' => 'KpiType not found',
                ];
            }

            // Validate the updated kpiType data
            $validationResult = $this->validatorService->validateKpiType($data);

            if (!$validationResult['status']) {
                return $validationResult;
            }
            // Update the kpiType entity with the new data
            $kpiType->setTitle($data['title']);
            $kpiType->setSlug($data['slug']);
            $kpiType->setUpdatedAt($date);

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
            $kpiType = $this->entityManager->getRepository(KpiType::class)->find($id);
            if (!$kpiType) {
                return [
                    'status' => false,
                    'message' => 'Data not found',
                ];
            }
            $this->entityManager->remove($kpiType);
            $this->entityManager->flush();

            return [
                'status' => true,
                'message' => 'Success! The data has been deleted.',
                ];
        } catch (\Exception $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
