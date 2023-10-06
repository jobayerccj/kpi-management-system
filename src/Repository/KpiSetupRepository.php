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

//    /**
//     * @return KpiSetup[] Returns an array of KpiSetup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('k.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?KpiSetup
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
