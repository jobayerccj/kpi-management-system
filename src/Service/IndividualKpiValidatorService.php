<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class IndividualKpiValidatorService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly ValidationMessage $validationMessage
    ) {
    }

    public function validateIndividualKpi($data): array
    {
        $errors = $this->validator->validate($data);
        if (count($errors)) {
            return $this->validationMessage->messages($errors);
        }

        return [
            'status' => true,
        ];
    }
}
