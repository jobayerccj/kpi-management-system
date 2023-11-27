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

    public function findUserWiseWeight(int $userId)
    {
        $queryBuilder = $this->createQueryBuilder('individual_kpi');
        $queryBuilder->select('sum(individual_kpi.weight) as totalWeight');
        // add the where condition with a parameter
        $queryBuilder->andWhere('individual_kpi.userId = :user_id');
        // set the parameter value
        $queryBuilder->setParameter('user_id', $userId);
        // optionally, you can add other conditions or joins to your query
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
