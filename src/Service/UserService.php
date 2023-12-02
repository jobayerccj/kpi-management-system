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
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserValidator $userValidator,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly MailerService $mailerService,
        private readonly UserRepository $userRepository
    ) {
    }

    public function processUserData(Request $request): array
    {
        $user = new User();
        $user->setName($request->get('name'));
        $user->setEmail($request->get('email'));
        $user->setMobileNumber($request->get('mobileNumber'));
        $user->setEmployeeId($request->get('employeeId'));
        $user->setPassword($request->get('password'));
        $user->setRoles(['ROLE_USER']);
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

    public function findUsers(Request $request): array
    {
        $response['status'] = false;
        $response['users'] = [];
        $response['message'] = '';
        $requestData = json_decode($request->getContent());

        if (is_null($requestData) || !property_exists($requestData, 'status')) {
            $response['message'] = 'status field is required';
            return $response;
        }

        $response['status'] = true;
        $response['users'] = $this->userRepository->findBy(['status' => $requestData->status]);
        return $response;
    }

    public function approveOrRejectUsers(Request $request, User $approvedBy): array
    {
        $response['status'] = false;
        $response['users'] = [];
        $response['message'] = '';
        $requestData = json_decode($request->getContent());

        if (is_null($requestData) || !property_exists($requestData, 'users')) {
            $response['message'] = 'status field is required';
            return $response;
        }

        $processedUsers = [];

        if (count($requestData->users)) {
            foreach ($requestData->users as $user) {
                $currentUser = $this->userRepository->findOneBy(['id' => $user[0]]);
                if ($currentUser && $currentUser->getIsVerified() && is_null($currentUser->isStatus())) {
                    $currentUser->setStatus($user[1]);
                    $processedUsers[] = $currentUser;
                    $currentUser->setApprovedBy($approvedBy->getId());
                }
            }
        }

        $this->entityManager->flush();

        foreach ($processedUsers as $processedUser) {
            $this->mailerService->sendApprovalEmailToUser($processedUser);
        }

        $response['status'] = true;
        $response['totalProcessed'] = count($processedUsers);
        return $response;
    }
}
