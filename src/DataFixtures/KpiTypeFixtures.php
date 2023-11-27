<?php

namespace App\DataFixtures;

use App\Entity\KpiType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class KpiTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        for ($i = 1; $i < 6; ++$i) {
            $kpiType = new KpiType();
            $kpiType->setTitle('Kpi Type' . $i);
            $kpiType->setSlug('kpi-type-' . $i);
            $kpiType->setStatus(1);
            $kpiType->setCreatedAt($date);
            $kpiType->setUpdatedAt($date);
            $manager->persist($kpiType);
        }
        $manager->flush();
    }
}
