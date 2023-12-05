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
    public function findUserWiseWeight(int $userId): float|bool|int|string|null
    {
        return $this->createQueryBuilder('individual_kpi')
            ->select('sum(individual_kpi.weight) as totalWeight')
            ->andWhere('individual_kpi.userId = :user_id')
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function checkUniqKpiSetupId($userId, $kpi_setup_id): int
    {
        return $this->createQueryBuilder('individual_kpi')
            ->select('Count(individual_kpi.id) as kpiSetupCount')
            ->andWhere('individual_kpi.userId = :user_id')
            ->andWhere('individual_kpi.kpiSetupId = :kpi_setup_id')
            ->setParameter('user_id', $userId)
            ->setParameter('kpi_setup_id', $kpi_setup_id)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
