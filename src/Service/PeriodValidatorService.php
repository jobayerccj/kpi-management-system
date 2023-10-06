<?php

namespace App\Service;

use App\Entity\Period;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PeriodValidatorService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly ValidationMessage $validationMessage
    ) {
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
