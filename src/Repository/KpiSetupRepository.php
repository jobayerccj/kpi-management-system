<?php

namespace App\Repository;

use App\Entity\KpiSetup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<KpiSetup>
 *
 * @method KpiSetup|null find($id, $lockMode = null, $lockVersion = null)
 * @method KpiSetup|null findOneBy(array $criteria, array $orderBy = null)
 * @method KpiSetup[]    findAll()
 * @method KpiSetup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KpiSetupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KpiSetup::class);
    }
    /**
     * @return KpiSetup[] Returns an array of KpiSetup objects
     */
    public function getKpiSetupData(): array
    {
        return $this->createQueryBuilder('kpi_setup')
            ->select('kpi_setup.id, kpi_setup.title')
            ->orderBy('kpi_setup.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
