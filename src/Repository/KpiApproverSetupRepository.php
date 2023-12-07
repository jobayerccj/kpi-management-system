<?php

namespace App\Repository;

use App\Entity\KpiApproverSetup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<KpiApproverSetup>
 *
 * @method KpiApproverSetup|null find($id, $lockMode = null, $lockVersion = null)
 * @method KpiApproverSetup|null findOneBy(array $criteria, array $orderBy = null)
 * @method KpiApproverSetup[]    findAll()
 * @method KpiApproverSetup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KpiApproverSetupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KpiApproverSetup::class);
    }
}
