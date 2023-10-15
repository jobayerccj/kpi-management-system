<?php

namespace App\Service;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private UserPasswordHasherInterface $userPasswordHasher;
    private MailerService $mailerService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $userPasswordHasher,
        MailerService $mailerService
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->mailerService = $mailerService;
    }

    public function processUserData(Request $request): array
    {
        // data validation using separate validator
        // update entity for validation unique values, different other conditions
        // send mail to admin using separate service which should initiate messenger handler

        return $this->saveUserData($request);
    }

    private function saveUserData(Request $request): array
    {
        $user = new User();
        $user->setName($request->get('name'));
        $user->setEmail($request->get('email'));
        $user->setMobileNumber($request->get('mobileNumber'));
        $user->setEmployeeId($request->get('employeeId'));
        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, $request->get('password'))
        );
        $user->setVerificationCode(substr(md5((string) mt_rand(9999, 999999)), 0, 60));

        $validData = $this->validateUserData($user);

        if ($validData['status']) {
            $user->setCreatedAt(new DateTime('now'));
            $user->setUpdatedAt(new DateTime('now'));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $validData['userId'] = $user->getId();
            $validData['message'] = 'Success! User registration is successful'
                                    . ', please check your email for verification';
            $this->mailerService->sendVerificationEmail($user);
        }

        return $validData;
    }

    private function validateUserData(User $user): array
    {
        $result['status'] = true;
        $errors = $this->validator->validate($user);
        // TODO need more improvement for this section like using key with error message, separate validator service etc
        if (count($errors)) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            $result['status'] = false;
            $result['message'] = $errorMessages;
        }

        return $result;
    }
}
