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
         $user->setName("Admin");
         $user->setEmail('admin@gmail.com');
         $user->setEmployeeId(1);
         $user->setMobileNumber('+88012345678');
         $user->setPassword($this->userPasswordHasher->hashPassword($user, '123456'));
         $user->setVerificationCode(substr(md5((string) mt_rand(9999, 999999)), 0, 60));
         $user->setIsVerified(1);
         $user->setVerifiedAt(new \DateTimeImmutable('now'));
         $user->setApprovedBy(1);
         $user->setCreatedAt(new \DateTime('now'));
         $user->setUpdatedAt(new \DateTime('now'));
         $user->setRoles(["ROLE_ADMIN"]);
         $user->setStatus(true);

         $manager->persist($user);

        $approvedUser = new User();
        $approvedUser->setName("Approved User");
        $approvedUser->setEmail('approved@gmail.com');
        $approvedUser->setEmployeeId(1);
        $approvedUser->setMobileNumber('+88012345677');
        $approvedUser->setPassword($this->userPasswordHasher->hashPassword($approvedUser, '123456'));
        $approvedUser->setVerificationCode(substr(md5((string) mt_rand(9999, 999999)), 0, 60));
        $approvedUser->setIsVerified(1);
        $approvedUser->setVerifiedAt(new \DateTimeImmutable('now'));
        $approvedUser->setApprovedBy(1);
        $approvedUser->setCreatedAt(new \DateTime('now'));
        $approvedUser->setUpdatedAt(new \DateTime('now'));
        $approvedUser->setRoles(["ROLE_USER"]);
        $approvedUser->setStatus(true);
        $manager->persist($approvedUser);

        $rejectedUser = new User();
        $rejectedUser->setName("Rejected User");
        $rejectedUser->setEmail('rejected@gmail.com');
        $rejectedUser->setEmployeeId(1);
        $rejectedUser->setMobileNumber('+88012345676');
        $rejectedUser->setPassword($this->userPasswordHasher->hashPassword($rejectedUser, '123456'));
        $rejectedUser->setVerificationCode(substr(md5((string) mt_rand(9999, 999999)), 0, 60));
        $rejectedUser->setIsVerified(1);
        $rejectedUser->setVerifiedAt(new \DateTimeImmutable('now'));
        $rejectedUser->setApprovedBy(1);
        $rejectedUser->setCreatedAt(new \DateTime('now'));
        $rejectedUser->setUpdatedAt(new \DateTime('now'));
        $rejectedUser->setRoles(["ROLE_USER"]);
        $rejectedUser->setStatus(false);
        $manager->persist($rejectedUser);

        $unprocessed = new User();
        $unprocessed->setName("Unprocessed User");
        $unprocessed->setEmail('unprocessed@gmail.com');
        $unprocessed->setEmployeeId(1);
        $unprocessed->setMobileNumber('+88012345675');
        $unprocessed->setPassword($this->userPasswordHasher->hashPassword($unprocessed, '123456'));
        $unprocessed->setVerificationCode(substr(md5((string) mt_rand(9999, 999999)), 0, 60));
        $unprocessed->setIsVerified(1);
        $unprocessed->setVerifiedAt(new \DateTimeImmutable('now'));
        $unprocessed->setApprovedBy(1);
        $unprocessed->setCreatedAt(new \DateTime('now'));
        $unprocessed->setUpdatedAt(new \DateTime('now'));
        $unprocessed->setRoles(["ROLE_USER"]);
        $manager->persist($unprocessed);

        $manager->flush();
    }
}
