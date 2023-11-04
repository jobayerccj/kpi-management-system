<?php

namespace App\Service;

use App\Entity\Period;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PeriodValidatorService
{
    private ValidatorInterface $validator;
    private ValidationMessage $validationMessage;
    public function __construct(ValidatorInterface $validator, ValidationMessage $validationMessage)
    {
        $this->validator = $validator;
        $this->validationMessage = $validationMessage;
    }

    public function validatePeriod(array $data): array
    {
        $period = new Period();
        $period->setTitle($data['title']);
        $period->setSlug($data['slug']);
        $period->setStatus(1);
        $errors = $this->validator->validate($period);

        if (count($errors)) {
            return $this->validationMessage->messages($errors);
        }

        return [
            'status' => true,
        ];
    }
}
