<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractValidator
{
    /**
     * @param ConstraintViolationListInterface $violations
     */
    public function jsonCheckViolations(
        ConstraintViolationListInterface $violations,
        TranslatorInterface $translator,
        bool $singleResult = false
    ): array {
        $errors = [];

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $message = $translator->trans(
                    'exc.invalid_parameter',
                    [
                        '%message%' => $violation->getMessage(),
                    ]
                );

                $errors[$violation->getPropertyPath()] = $message;

                if ($singleResult) {
                    throw new HttpException(
                        Response::HTTP_BAD_REQUEST,
                        $message,
                        null,
                        [],
                        400
                    );
                }
            }
        }

        return $errors;
    }

    /**
     * @param User $entity
     * @return mixed
     */
    abstract public function validateData(User $entity);
}
