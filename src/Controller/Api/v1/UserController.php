<?php

namespace App\Controller\Api\v1;

use App\Repository\UserRepository;
use App\Service\MailerService;
use App\Service\UserService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/user', name: 'app_api_v1_user_')]
class UserController extends AbstractController
{
    #[Route("/register", name: "register")]
    public function register(Request $request, UserService $userService)
    {
        try {
            $result = $userService->processUserData($request);

            return $this->json(
                [
                    'status' => $result['status'],
                    'message' => $result['message'],
                ],
                $result['status'] ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } catch (Exception $exc) {
            return $this->json(
                [
                    'status' => false,
                    'message' => $exc->getMessage(),
                ],
                RESPONSE::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    #[Route('/confirm-registration/{userId}/{verificationCode}', name: 'confirm_registration')]
    public function verifyRegistration(
        int $userId,
        string $verificationCode,
        UserRepository $userRepository,
        UserService $userService,
        MailerService $mailerService,
        EntityManagerInterface $entityManager
    ): Response {

        // TODO move everything to service
        $user = $userRepository->findOneBy(['id' => $userId, 'verificationCode' => $verificationCode]);

        // check if already user registered using that email address
        // or check if another expired data available for that user
        if ($user && is_null($user->getVerifiedAt())) {
            // update user data to verified & verified_at
            $user->setVerifiedAt(new DateTimeImmutable('now'));
            $entityManager->flush();

            // send email to Admin for approval
            $mailerService->sendApprovalEmailToAdmin($user);
            // send success message
            return $this->render('verification/message.html.twig', [
                'message' => 'Thank you for your verification, an admin will approve your request, please wait.',
            ]);
        } elseif (!is_null($user->getVerifiedAt())) {
            return $this->render('verification/message.html.twig', [
                'message' => 'You have already verified your account, an admin will approve your request, please wait.',
            ]);
        } else {
            return $this->render('verification/message.html.twig', [
                'message' => 'Wrong information provided',
            ]);
        }
    }
}
