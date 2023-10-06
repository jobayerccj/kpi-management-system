<?php

namespace App\Service;

use App\Entity\Department;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DepartmentValidatorService
{
    private ValidatorInterface $validator;
    private ValidationMessage $validationMessage;

    public function __construct(ValidatorInterface $validator, ValidationMessage $validationMessage)
    {
        $this->validator = $validator;
        $this->validationMessage = $validationMessage;
    }

    public function validateDepartmentData(array $data): array
    {
        $department = new Department();
        $department->setTitle($data['title']);
        $department->setSlug($data['slug']);
        $department->setDescription($data['description']);
        $department->setStatus(1);
        $errors = $this->validator->validate($department);

        if (count($errors)) {
            return $this->validationMessage->messages($errors);
        }

        return [
            'status' => true,
        ];
    }
}
