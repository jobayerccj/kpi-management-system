<?php

namespace App\Service;

use App\Entity\IndividualKpi;
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

    public function validateIndividualKpi(array $data): array
    {
        $individualKpi = new IndividualKpi();
        $individualKpi->setKpiSetupId($data['kpi_setup_id']);
        $individualKpi->setUserId($data['user_id']);
        $individualKpi->setKpiTypeId($data['kpi_type_id']);
        $individualKpi->setPeriodId($data['period_id']);
        $individualKpi->setWeight($data['weight']);
        $individualKpi->setCreatedBy(1);
        $individualKpi->setStatus(1);
        $errors = $this->validator->validate($individualKpi);

        if (count($errors)) {
            return $this->validationMessage->messages($errors);
        }

        return [
            'status' => true,
        ];
    }
}
