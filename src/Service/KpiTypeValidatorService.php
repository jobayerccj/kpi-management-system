<?php

namespace App\Service;

use App\Entity\KpiType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class KpiTypeValidatorService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly ValidationMessage $validationMessage
    ) {
    }

    public function validateKpiType(array $data): array
    {
        $kpiType = new KpiType();
        $kpiType->setTitle($data['title']);
        $kpiType->setSlug($data['slug']);
        $kpiType->setStatus(1);

        $errors = $this->validator->validate($kpiType);

        if (count($errors)) {
            return $this->validationMessage->messages($errors);
        }

        return [
            'status' => true,
        ];
    }
}
