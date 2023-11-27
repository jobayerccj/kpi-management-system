<?php

namespace App\DataFixtures;

use App\Entity\IndividualKpi;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IndividualKpiFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        for ($i = 1; $i < 6; ++$i) {
            $individualKpi = new IndividualKpi();
            $individualKpi->setKpiSetupId($i);
            $individualKpi->setUserId(1);
            $individualKpi->setKpiTypeId($i);
            $individualKpi->setPeriodId($i);
            $individualKpi->setWeight(20);
            $individualKpi->setStatus(1);
            $individualKpi->setCreatedBy(1);
            $individualKpi->setCreatedAt($date);
            $individualKpi->setUpdatedAt($date);
            $manager->persist($individualKpi);
        }
        $manager->flush();
    }
}
