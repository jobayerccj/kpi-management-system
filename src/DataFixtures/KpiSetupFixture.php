<?php

namespace App\DataFixtures;

use App\Entity\KpiSetup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class KpiSetupFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        for ($i = 0; $i < 20; ++$i) {
            $kpiSetup = new KpiSetup();
            $kpiSetup->setTitle('Task number ' . $i . ' Authentication management system');
            $kpiSetup->setStatus(1);
            $kpiSetup->setCreatedBy(1);
            $kpiSetup->setCreatedAt($date);
            $kpiSetup->setUpdatedAt($date);
            $manager->persist($kpiSetup);
        }
        $manager->flush();
    }
}
