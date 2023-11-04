<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class MailerService
{
    private MailerInterface $mailer;
    private RouterInterface $router;

    public function __construct(
        MailerInterface $mailer,
        RouterInterface $router
    ) {
        $this->mailer = $mailer;
        $this->router = $router;
    }

    /**
     * @return JsonResponse|null
     */
    public function sendVerificationEmail(User $user)
    {
        $email = (new Email())
            ->from('info@kpimanagement.com')
            ->to($user->getEmail())
            ->subject('Please confirm your account')
            ->html($this->prepareApprovalEmailToAdminHtml($user));

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return null;
    }

    /**
     * @return JsonResponse|null
     */
    public function sendApprovalEmailToAdmin(User $user)
    {
        $email = (new Email())
            ->from($user->getEmail())
            ->to('info@kpimanagement.com')
            ->subject('Please approve account')
            ->html($this->prepareVerificationEmailHtml($user));

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return new JsonResponse([
            'success' => true
        ]);
    }

    private function prepareVerificationEmailHtml(User $user): string
    {
        return "<p>Please approve this user </p>" .
            "<p>User Email: " . $user->getEmail() . "</p>" .
            "<p>User Id: " . $user->getId() . "</p>"
            ;
    }

    private function prepareApprovalEmailToAdminHtml(User $user): string
    {
        $verificationUrl = $this->router->generate(
            'app_api_v1_user_confirm_registration',
            ['userId' => $user->getId(), 'verificationCode' => $user->getVerificationCode()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return "<a href=\"$verificationUrl\">Please click on this link to complete your registration</a>";
    }
}
