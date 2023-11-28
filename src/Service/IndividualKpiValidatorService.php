<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class IndividualKpiValidatorService
{
    private ValidatorInterface $validator;
    private ValidationMessage $validationMessage;

    public function __construct(ValidatorInterface $validator, ValidationMessage $validationMessage)
    {
        $this->validator = $validator;
        $this->validationMessage = $validationMessage;
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
