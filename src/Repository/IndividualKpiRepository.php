<?php

namespace App\Repository;

use App\Entity\IndividualKpi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    /**
     * @param int $userId
     * @return bool|float|int|string|null
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findUserWiseWeight(int $userId)
    {
        return $this->createQueryBuilder('individual_kpi')
            ->select('sum(individual_kpi.weight) as totalWeight')
            ->andWhere('individual_kpi.userId = :user_id')
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
