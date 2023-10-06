<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserValidator extends AbstractValidator
{
    private ValidatorInterface $validator;
    private TranslatorInterface $translator;

    public function __construct(ValidatorInterface $validator, TranslatorInterface $translator)
    {
        $this->validator = $validator;
        $this->translator = $translator;
    }

    public function validateData(User $entity): array
    {
        $result['status'] = true;
        $violations = $this->validator->validate($entity);
        if (count($violations)) {
            $result['status'] = false;
            $result['message'] = $this->jsonCheckViolations($violations, $this->translator);
        }

        return $result;
    }
}
