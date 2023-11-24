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
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly RouterInterface $router
    ) {
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
            ->html($this->prepareVerificationEmailHtml($user));

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
            ->html($this->prepareApprovalEmailToAdminHtml($user));

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

    /**
     * @return JsonResponse|null
     */
    public function sendApprovalEmailToUser(User $user)
    {
        $email = (new Email())
            ->from('info@kpimanagement.com')
            ->to($user->getEmail())
            ->subject('Your account is processed')
            ->html($this->prepareApprovalEmailToUserHtml($user));

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

    private function prepareApprovalEmailToAdminHtml(User $user): string
    {
        return "<p>Please approve this user </p>" .
            "<p>User Email: " . $user->getEmail() . "</p>" .
            "<p>User Id: " . $user->getId() . "</p>"
            ;
    }

    private function prepareVerificationEmailHtml(User $user): string
    {
        $verificationUrl = $this->router->generate(
            'app_api_v1_user_confirm_registration',
            ['userId' => $user->getId(), 'verificationCode' => $user->getVerificationCode()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return "<a href=\"$verificationUrl\">Please click on this link to complete your registration</a>";
    }

    private function prepareApprovalEmailToUserHtml(User $user): string
    {
        if ($user->isStatus()) {
            return sprintf("Hello %s, Your account is approved, now you can access our system", $user->getName());
        }

        return sprintf(
            "Hello %s, Your account is rejected, sorry for the inconvenience, please contact with admin",
            $user->getName()
        );
    }
}
