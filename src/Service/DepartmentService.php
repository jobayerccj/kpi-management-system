<?php

namespace App\Service;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;

class DepartmentService
{
    private EntityManagerInterface $entityManager;
    private DepartmentValidatorService $validatorService;

    public function __construct(EntityManagerInterface $entityManager, DepartmentValidatorService $validatorService)
    {
        $this->entityManager = $entityManager;
        $this->validatorService = $validatorService;
    }

    public function list(): array
    {
        try {
            $departments = $this->entityManager->getRepository(Department::class)->findAll();
            $data = [];
            foreach ($departments as $department) {
                $data[] = [
                    'id' => $department->getId(),
                    'title' => $department->getTitle(),
                    'slug' => $department->getSlug(),
                    'description' => $department->getDescription(),
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
            $department = $this->entityManager->getRepository(Department::class)->find($id);

            if (!$department) {
                return [
                    'status' => false,
                    'message' => 'Data is not found',
                ];
            }
            $data = [
                'id' => $department->getId(),
                'title' => $department->getTitle(),
                'slug' => $department->getSlug(),
                'description' => $department->getDescription(),
            ];
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

    public function createDepartment(array $data): array
    {
        try {
            $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            // Validate department data
            $validationResult = $this->validatorService->validateDepartmentData($data);

            if (!$validationResult['status']) {
                return $validationResult;
            }

            $department = new Department();
            $department->setTitle($data['title']);
            $department->setSlug($data['slug']);
            $department->setDescription($data['description']);
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

    public function updateDepartment(int $id, array $data): array
    {
        try {
            $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));

            // Fetch the department entity to update
            $department = $this->entityManager->getRepository(Department::class)->find($id);

            if (!$department) {
                return [
                    'status' => false,
                    'message' => 'Department not found',
                ];
            }

            // Validate the updated department data
            $validationResult = $this->validatorService->validateDepartmentData($data);

            if (!$validationResult['status']) {
                return $validationResult;
            }
            // Update the department entity with the new data
            $department->setTitle($data['title']);
            $department->setSlug($data['slug']);
            $department->setDescription($data['description']);
            $department->setUpdatedAt($date);
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
            $department = $this->entityManager->getRepository(Department::class)->find($id);
            if (!$department) {
                return [
                    'status' => false,
                    'message' => 'Data is not found',
                ];
            }
            $this->entityManager->remove($department);
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
