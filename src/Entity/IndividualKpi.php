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
    #[ORM\Column, Assert\NotBlank(message: 'The user id field should not be blank.')]
    private ?int $userId = null;
    #[ORM\Column, Assert\NotBlank(message: 'The kpi weight field should not be blank.')]
    private ?int $weight = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;
    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?int $createdBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?float $JanuaryTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $FebruaryTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $MarchTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $AprilTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $MayTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $JuneTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $JulyTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $AugustTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $SeptemberTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $OctoberTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $NovemberTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $DecemberTarget = null;

    #[ORM\Column(nullable: true)]
    private ?float $JanuaryResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $FebruaryResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $MarchResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $AprilResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $MayResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $JuneResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $JulyResutl = null;

    #[ORM\Column(nullable: true)]
    private ?float $AugustResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $SeptemberResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $OctoberResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $NovemberResult = null;

    #[ORM\Column(nullable: true)]
    private ?float $DecemberResult = null;

    #[ORM\Column(nullable: true)]
    private ?int $JanuaryStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $FebruaryStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $MarchStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $AprilStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $MayStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $JuneStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $JulyStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $AugustStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $SeptemberStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $OctoberStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $NovemberStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $DecemberStatus = null;

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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getJanuaryTarget(): ?float
    {
        return $this->JanuaryTarget;
    }

    public function setJanuaryTarget(?float $JanuaryTarget): static
    {
        $this->JanuaryTarget = $JanuaryTarget;

        return $this;
    }

    public function getFebruaryTarget(): ?float
    {
        return $this->FebruaryTarget;
    }

    public function setFebruaryTarget(?float $FebruaryTarget): static
    {
        $this->FebruaryTarget = $FebruaryTarget;

        return $this;
    }

    public function getMarchTarget(): ?float
    {
        return $this->MarchTarget;
    }

    public function setMarchTarget(?float $MarchTarget): static
    {
        $this->MarchTarget = $MarchTarget;

        return $this;
    }

    public function getAprilTarget(): ?float
    {
        return $this->AprilTarget;
    }

    public function setAprilTarget(?float $AprilTarget): static
    {
        $this->AprilTarget = $AprilTarget;

        return $this;
    }

    public function getMayTarget(): ?float
    {
        return $this->MayTarget;
    }

    public function setMayTarget(?float $MayTarget): static
    {
        $this->MayTarget = $MayTarget;

        return $this;
    }

    public function getJuneTarget(): ?float
    {
        return $this->JuneTarget;
    }

    public function setJuneTarget(?float $JuneTarget): static
    {
        $this->JuneTarget = $JuneTarget;

        return $this;
    }

    public function getJulyTarget(): ?float
    {
        return $this->JulyTarget;
    }

    public function setJulyTarget(?float $JulyTarget): static
    {
        $this->JulyTarget = $JulyTarget;

        return $this;
    }

    public function getAugustTarget(): ?float
    {
        return $this->AugustTarget;
    }

    public function setAugustTarget(?float $AugustTarget): static
    {
        $this->AugustTarget = $AugustTarget;

        return $this;
    }

    public function getSeptemberTarget(): ?float
    {
        return $this->SeptemberTarget;
    }

    public function setSeptemberTarget(?float $SeptemberTarget): static
    {
        $this->SeptemberTarget = $SeptemberTarget;

        return $this;
    }

    public function getOctoberTarget(): ?float
    {
        return $this->OctoberTarget;
    }

    public function setOctoberTarget(?float $OctoberTarget): static
    {
        $this->OctoberTarget = $OctoberTarget;

        return $this;
    }

    public function getNovemberTarget(): ?float
    {
        return $this->NovemberTarget;
    }

    public function setNovemberTarget(?float $NovemberTarget): static
    {
        $this->NovemberTarget = $NovemberTarget;

        return $this;
    }

    public function getDecemberTarget(): ?float
    {
        return $this->DecemberTarget;
    }

    public function setDecemberTarget(?float $DecemberTarget): static
    {
        $this->DecemberTarget = $DecemberTarget;

        return $this;
    }

    public function getJanuaryResult(): ?float
    {
        return $this->JanuaryResult;
    }

    public function setJanuaryResult(?float $JanuaryResult): static
    {
        $this->JanuaryResult = $JanuaryResult;

        return $this;
    }

    public function getFebruaryResult(): ?float
    {
        return $this->FebruaryResult;
    }

    public function setFebruaryResult(?float $FebruaryResult): static
    {
        $this->FebruaryResult = $FebruaryResult;

        return $this;
    }

    public function getMarchResult(): ?float
    {
        return $this->MarchResult;
    }

    public function setMarchResult(?float $MarchResult): static
    {
        $this->MarchResult = $MarchResult;

        return $this;
    }

    public function getAprilResult(): ?float
    {
        return $this->AprilResult;
    }

    public function setAprilResult(?float $AprilResult): static
    {
        $this->AprilResult = $AprilResult;

        return $this;
    }

    public function getMayResult(): ?float
    {
        return $this->MayResult;
    }

    public function setMayResult(?float $MayResult): static
    {
        $this->MayResult = $MayResult;

        return $this;
    }

    public function getJuneResult(): ?float
    {
        return $this->JuneResult;
    }

    public function setJuneResult(?float $JuneResult): static
    {
        $this->JuneResult = $JuneResult;

        return $this;
    }

    public function getJulyResutl(): ?float
    {
        return $this->JulyResutl;
    }

    public function setJulyResutl(?float $JulyResutl): static
    {
        $this->JulyResutl = $JulyResutl;

        return $this;
    }

    public function getAugustResult(): ?float
    {
        return $this->AugustResult;
    }

    public function setAugustResult(?float $AugustResult): static
    {
        $this->AugustResult = $AugustResult;

        return $this;
    }

    public function getSeptemberResult(): ?float
    {
        return $this->SeptemberResult;
    }

    public function setSeptemberResult(?float $SeptemberResult): static
    {
        $this->SeptemberResult = $SeptemberResult;

        return $this;
    }

    public function getOctoberResult(): ?float
    {
        return $this->OctoberResult;
    }

    public function setOctoberResult(?float $OctoberResult): static
    {
        $this->OctoberResult = $OctoberResult;

        return $this;
    }

    public function getNovemberResult(): ?float
    {
        return $this->NovemberResult;
    }

    public function setNovemberResult(?float $NovemberResult): static
    {
        $this->NovemberResult = $NovemberResult;

        return $this;
    }

    public function getDecemberResult(): ?float
    {
        return $this->DecemberResult;
    }

    public function setDecemberResult(?float $DecemberResult): static
    {
        $this->DecemberResult = $DecemberResult;

        return $this;
    }

    public function getJanuaryStatus(): ?int
    {
        return $this->JanuaryStatus;
    }

    public function setJanuaryStatus(?int $JanuaryStatus): static
    {
        $this->JanuaryStatus = $JanuaryStatus;

        return $this;
    }

    public function getFebruaryStatus(): ?int
    {
        return $this->FebruaryStatus;
    }

    public function setFebruaryStatus(?int $FebruaryStatus): static
    {
        $this->FebruaryStatus = $FebruaryStatus;

        return $this;
    }

    public function getMarchStatus(): ?int
    {
        return $this->MarchStatus;
    }

    public function setMarchStatus(?int $MarchStatus): static
    {
        $this->MarchStatus = $MarchStatus;

        return $this;
    }

    public function getAprilStatus(): ?int
    {
        return $this->AprilStatus;
    }

    public function setAprilStatus(?int $AprilStatus): static
    {
        $this->AprilStatus = $AprilStatus;

        return $this;
    }

    public function getMayStatus(): ?int
    {
        return $this->MayStatus;
    }

    public function setMayStatus(?int $MayStatus): static
    {
        $this->MayStatus = $MayStatus;

        return $this;
    }

    public function getJuneStatus(): ?int
    {
        return $this->JuneStatus;
    }

    public function setJuneStatus(?int $JuneStatus): static
    {
        $this->JuneStatus = $JuneStatus;

        return $this;
    }

    public function getJulyStatus(): ?int
    {
        return $this->JulyStatus;
    }

    public function setJulyStatus(?int $JulyStatus): static
    {
        $this->JulyStatus = $JulyStatus;

        return $this;
    }

    public function getAugustStatus(): ?int
    {
        return $this->AugustStatus;
    }

    public function setAugustStatus(?int $AugustStatus): static
    {
        $this->AugustStatus = $AugustStatus;

        return $this;
    }

    public function getSeptemberStatus(): ?int
    {
        return $this->SeptemberStatus;
    }

    public function setSeptemberStatus(?int $SeptemberStatus): static
    {
        $this->SeptemberStatus = $SeptemberStatus;

        return $this;
    }

    public function getOctoberStatus(): ?int
    {
        return $this->OctoberStatus;
    }

    public function setOctoberStatus(?int $OctoberStatus): static
    {
        $this->OctoberStatus = $OctoberStatus;

        return $this;
    }

    public function getNovemberStatus(): ?int
    {
        return $this->NovemberStatus;
    }

    public function setNovemberStatus(?int $NovemberStatus): static
    {
        $this->NovemberStatus = $NovemberStatus;

        return $this;
    }

    public function getDecemberStatus(): ?int
    {
        return $this->DecemberStatus;
    }

    public function setDecemberStatus(?int $DecemberStatus): static
    {
        $this->DecemberStatus = $DecemberStatus;

        return $this;
    }
}
