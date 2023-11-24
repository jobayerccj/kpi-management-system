<?php

namespace App\Controller\Api\v1;

use App\Entity\User;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/v1/user-management', name: 'app_api_v1_user_management_')]
#[IsGranted('ROLE_ADMIN')]
class UserManagementController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/user-list', name: 'user_list', methods: ["GET"])]
    public function userList(Request $request)
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

    #[Route('/approve-user', name: 'approve_user', methods: ["POST"])]
    public function approveUser(Request $request, Security $security)
    {
        try {
            /** @var User $user */
            $user = $security->getUser();
            $result = $this->userService->approveOrRejectUsers($request, $user);
            return $this->json(
                [
                    'status' => $result['status'],
                    'totalProcessed' => $result['totalProcessed']
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
