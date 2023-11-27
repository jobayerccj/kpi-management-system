<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date = new \DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        for ($i = 1; $i < 10; ++$i) {
            $department = new Department();
            $department->setTitle('Department ' . $i);
            $department->setSlug('department-' . $i);
            $department->setDescription('It is a long established fact that a reader will be distracted');
            $department->setStatus(1);
            $department->setCreatedAt($date);
            $department->setUpdatedAt($date);
            $manager->persist($department);
        }
        $manager->flush();
    }
}
