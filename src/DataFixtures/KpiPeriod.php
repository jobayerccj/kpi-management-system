<?php

namespace App\DataFixtures;

use App\Entity\Period;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class KpiPeriod extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $periods = ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Yearly'];
        foreach ($periods as $period) {
            $kpiPeriod = new Period();
            $kpiPeriod->setTitle($period);
            $kpiPeriod->setSlug(strtolower($period));
            $kpiPeriod->setStatus(1);
            $kpiPeriod->setCreatedAt($date);
            $kpiPeriod->setUpdatedAt($date);
            $manager->persist($kpiPeriod);
        }
        $manager->flush();
    }
}
