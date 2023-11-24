<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setName("Biplob");
         $user->setEmail('biplob@gmail.com');
         $user->setEmployeeId(1);
         $user->setMobileNumber('+88012345678');
         $user->setPassword($this->userPasswordHasher->hashPassword($user, '123456'));
         $user->setVerificationCode(substr(md5((string) mt_rand(9999, 999999)), 0, 60));
         $user->setIsVerified(1);
         $user->setVerifiedAt(new \DateTimeImmutable('now'));
         $user->setApprovedBy(1);
         $user->setCreatedAt(new \DateTime('now'));
         $user->setUpdatedAt(new \DateTime('now'));
         $user->setRoles(["ROLE_USER"]);
         $user->setStatus(true);

         $manager->persist($user);
         $manager->flush();
    }
}
