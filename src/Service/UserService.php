<?php

namespace App\Service;

use App\Entity\KpiApproverSetup;
use App\Entity\User;
use App\Repository\KpiApproverSetupRepository;
use App\Repository\UserRepository;
use App\Validator\UserValidator;
use DateTimeImmutable;
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
            $user->setVerifiedAt(new DateTimeImmutable('now'));
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
        $response['message'] = 'successfully processed';
        $response['totalProcessed'] = 0;
        $requestData = json_decode($request->getContent());

        if (is_null($requestData) || !property_exists($requestData, 'users') || !count($requestData->users)) {
            $response['message'] = 'users data is required';

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

    public function addKpiApproverSetup(Request $request, User $addedBy)
    {
        $requestData = json_decode($request->getContent(), true);
        $validationResult = $this->validateAddKpiApproverRequest($requestData);

        if (!$validationResult['status']) {
            return [
                'status' => false,
                'message' => $validationResult['message'],
                'totalProcessed' => 0
            ];
        }

        $today = new DateTimeImmutable('now', new \DateTimeZone('Asia/Dhaka'));
        $totalProcessed = 0;

        foreach ($requestData as $key => $approversList) {
            $processed = 0;
            foreach ($approversList as $approver) {
                if (is_null($this->checkIfApproverAdded($key, $approver[0]))) {
                    $kpiApproverSetup = new KpiApproverSetup();
                    $kpiApproverSetup->setUserId($key);
                    $kpiApproverSetup->setApproverId($approver[0]);
                    $kpiApproverSetup->setSerial($approver[1]);
                    $kpiApproverSetup->setStatus(true);
                    $kpiApproverSetup->setAddedBy($addedBy->getId());
                    $kpiApproverSetup->setCreatedAt($today);
                    $this->entityManager->persist($kpiApproverSetup);
                    $processed = 1;
                }
            }

            $totalProcessed += $processed;
        }

        $this->entityManager->flush();

        return [
            'status' => true,
            'message' => 'Successfully processed',
            'totalProcessed' => $totalProcessed
        ];
    }

    private function validateAddKpiApproverRequest(array $requestData): array
    {
        if (!count($requestData)) {
            return [
                'status' => false,
                'message' => 'Users & approver data are required'
            ];
        }

        if (!$this->validateUsers($requestData)) {
            return [
                'status' => false,
                'message' => 'Invalid User / Approver data provided'
            ];
        }

        return [
            'status' => true
        ];
    }

    private function checkIfApproverAdded(int $userId, int $approverId): ?KpiApproverSetup
    {
        /** @var KpiApproverSetupRepository $kpiApproverRepository */
        $kpiApproverRepository = $this->entityManager->getRepository(KpiApproverSetup::class);

        return $kpiApproverRepository->findOneBy(['userId' => $userId, 'approverId' => $approverId]);
    }

    private function validateUsers(array $requestData): bool
    {
        $userIds = array_keys($requestData);

        foreach ($requestData as $users) {
            foreach ($users as $user) {
                $userIds[] = $user[0];
            }
        }

        $usersFromRequest = array_unique($userIds);
        $users = $this->userRepository->findUserByIds($usersFromRequest);
        return count($users) === count(array_unique($usersFromRequest));
    }
}
