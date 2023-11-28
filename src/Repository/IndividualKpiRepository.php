<?php

namespace App\Repository;

use App\Entity\IndividualKpi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IndividualKpi>
 *
 * @method IndividualKpi|null find($id, $lockMode = null, $lockVersion = null)
 * @method IndividualKpi|null findOneBy(array $criteria, array $orderBy = null)
 * @method IndividualKpi[]    findAll()
 * @method IndividualKpi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndividualKpiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IndividualKpi::class);
    }
}
