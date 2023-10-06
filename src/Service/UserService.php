<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Validator\UserValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;
    private MailerService $mailerService;
    private UserRepository $userRepository;
    private UserValidator $userValidator;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserValidator $userValidator,
        UserPasswordHasherInterface $userPasswordHasher,
        MailerService $mailerService,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->mailerService = $mailerService;
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
    }

    public function processUserData(Request $request): array
    {
        $user = new User();
        $user->setName($request->get('name'));
        $user->setEmail($request->get('email'));
        $user->setMobileNumber($request->get('mobileNumber'));
        $user->setEmployeeId($request->get('employeeId'));
        $user->setPassword($request->get('password'));
        $user->setVerificationCode(substr(md5((string) mt_rand(9999, 999999)), 0, 60));
        $validData = $this->userValidator->validateData($user);

        if ($validData['status']) {
            $user->setPassword(
                $this->userPasswordHasher->hashPassword($user, $request->get('password'))
            );
            $user->setCreatedAt(new \DateTime('now'));
            $user->setUpdatedAt(new \DateTime('now'));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $validData['userId'] = $user->getId();
            $validData['message'] = 'Success! User registration is successful'
                . ', please check your email for verification';
            $this->mailerService->sendVerificationEmail($user);
        }

        return $validData;
    }

    public function verifyUser(int $userId, string $verificationCode): string
    {
        $user = $this->userRepository->findOneBy(['id' => $userId, 'verificationCode' => $verificationCode]);

        if (!empty($user) && is_null($user->getVerifiedAt())) {
            $user->setVerifiedAt(new \DateTimeImmutable('now'));
            $this->entityManager->flush();
            $this->mailerService->sendApprovalEmailToAdmin($user);

            return 'Thank you for your verification, an admin will approve your request, please wait.';
        } elseif (empty($user)) {
            return 'Invalid verification code provided';
        } elseif (!is_null($user->getVerifiedAt())) {
            return 'You have already verified your account, an admin will approve your request, please wait.';
        } else {
            return 'Wrong information provided';
        }
    }
}
