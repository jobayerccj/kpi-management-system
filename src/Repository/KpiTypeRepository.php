<?php

namespace App\Repository;

use App\Entity\KpiType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<KpiType>
 *
 * @method KpiType|null find($id, $lockMode = null, $lockVersion = null)
 * @method KpiType|null findOneBy(array $criteria, array $orderBy = null)
 * @method KpiType[]    findAll()
 * @method KpiType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KpiTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KpiType::class);
    }
}
