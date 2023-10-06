<?php

namespace App\Entity;

use App\Repository\IndividualKpiRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IndividualKpiRepository::class)]
class IndividualKpi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column, Assert\NotBlank(message: 'The kpi setup id field should not be blank.')]
    private ?int $kpiSetupId = null;

    #[ORM\Column, Assert\NotBlank(message: 'The kpi type id field should not be blank.')]
    private ?int $kpiTypeId = null;

    #[ORM\Column, Assert\NotBlank(message: 'The period id field should not be blank.')]
    private ?int $periodId = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?int $createdBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKpiSetupId(): ?int
    {
        return $this->kpiSetupId;
    }

    public function setKpiSetupId(int $kpiSetupId): static
    {
        $this->kpiSetupId = $kpiSetupId;

        return $this;
    }

    public function getKpiTypeId(): ?int
    {
        return $this->kpiTypeId;
    }

    public function setKpiTypeId(int $kpiTypeId): static
    {
        $this->kpiTypeId = $kpiTypeId;

        return $this;
    }

    public function getPeriodId(): ?int
    {
        return $this->periodId;
    }

    public function setPeriodId(int $periodId): static
    {
        $this->periodId = $periodId;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
