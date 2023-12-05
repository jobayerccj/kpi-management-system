<?php

namespace App\Service;

use App\Repository\IndividualKpiRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IndividualKpiValidatorService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly ValidationMessage $validationMessage,
        private readonly IndividualKpiRepository $individualKpiRepository
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function validateIndividualKpi($data): array
    {
        $errors = $this->validator->validate($data);
        if (count($errors)) {
            return $this->validationMessage->messages($errors);
        }

        $checkUnique = $this->individualKpiRepository->checkUniqKpiSetupId($data->getUserId(), $data->getKpiSetupId());

        if ($checkUnique > 0) {
            return [
                'status' => false,
                'message' => 'You already added this kpi setup',
            ];
        }
        $existingWeight = $this->individualKpiRepository->findUserWiseWeight($data->getUserId()) ?? 0;

        if ($existingWeight + $data->getWeight() > 100) {
            return [
                'status' => false,
                'message' => sprintf('You have reached your weight limit. Your current weight %d', $existingWeight),
            ];
        }

        return [
            'status' => true,
        ];
    }
}
