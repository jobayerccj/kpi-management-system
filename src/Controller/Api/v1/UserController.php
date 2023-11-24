<?php

namespace App\Controller\Api\v1;

use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/api/v1/user', name: 'app_api_v1_user_')]
class UserController extends AbstractController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/register', name: 'register', methods: ["POST"])]
    public function register(Request $request): JsonResponse
    {
        try {
            $result = $this->userService->processUserData($request);

            return $this->json(
                [
                    'status' => $result['status'],
                    'message' => $result['message'],
                ],
                $result['status'] ? Response::HTTP_CREATED : Response::HTTP_UNPROCESSABLE_ENTITY
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
        string $verificationCode
    ): Response {
        $message = $this->userService->verifyUser($userId, $verificationCode);

        return $this->render('verification/message.html.twig', [
            'message' => $message,
        ]);
    }
}
