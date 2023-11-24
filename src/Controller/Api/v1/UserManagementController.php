<?php

namespace App\Controller\Api\v1;

use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/user-management', name: 'app_api_v1_user_management_')]
class UserManagementController extends AbstractController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/user-list', name: 'user_list', methods: ["GET"])]
    public function userList(Request $request): JsonResponse
    {
        // status null = not verified, 1 = approved, 0 = rejected
        try {
            $result = $this->userService->findUsers($request);
            return $this->json(
                [
                    'status' => $result['status'],
                    'users' => $result['users'],
                    'message' => $result['message']
                ],
                Response::HTTP_OK
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
}
