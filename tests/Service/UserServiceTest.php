<?php

namespace App\Tests\Service;

use App\Repository\UserRepository;
use App\Service\MailerService;
use App\Service\UserService;
use App\Validator\UserValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServiceTest extends WebTestCase
{
    protected static $client;
    protected static $entityManager;
    protected static $validator;
    protected static $userPasswordHasherInterface;
    protected static $mailerService;
    protected static $userRepository;
    protected static $userService;

    protected function setUp(): void
    {
        parent::setUp();

        self::$client = self::createClient();
        self::$entityManager = self::$client->getContainer()->get('doctrine')->getManager();
        self::$validator = self::$client->getContainer()->get(UserValidator::class);
        self::$userPasswordHasherInterface = self::$client->getContainer()->get(UserPasswordHasherInterface::class);
        self::$mailerService = self::$client->getContainer()->get(MailerService::class);
        self::$userRepository = self::$client->getContainer()->get(UserRepository::class);

        self::$userService = new UserService(
            self::$entityManager,
            self::$validator,
            self::$userPasswordHasherInterface,
            self::$mailerService,
            self::$userRepository
        );
    }

    /**
     * @dataProvider provideRequest
     */
    public function testProcessUserDataStatus($request = null, $expectedResult = true)
    {
        $processedData = self::$userService->processUserData($request);
        $this->assertSame($expectedResult, $processedData['status']);
    }

    public static function provideRequest(): array
    {
        // appropriate data
        $request = new Request();
        $request->setMethod('POST');
        $request->request->set('name', 'User2');
        $request->request->set('email', 'user2@gmail.com');
        $request->request->set('password', '123456');
        $request->request->set('mobileNumber', '12345678');
        $request->request->set('employeeId', 2);

        // same user
        $request2 = new Request();
        $request2->setMethod('POST');
        $request2->request->set('name', 'User2');
        $request2->request->set('email', 'user2@gmail.com');
        $request2->request->set('password', '123456');
        $request2->request->set('mobileNumber', '12345678');
        $request2->request->set('employeeId', 2);

        // user with wrong email address
        $request3 = new Request();
        $request3->setMethod('POST');
        $request3->request->set('name', 'User3');
        $request3->request->set('email', 'user2');
        $request3->request->set('password', '123456');
        $request3->request->set('mobileNumber', '12345678');
        $request3->request->set('employeeId', 3);

        $request4 = new Request();
        $request4->setMethod('POST');
        $request4->request->set('name', '');
        $request4->request->set('email', '');
        $request4->request->set('password', '');
        $request4->request->set('mobileNumber', '');
        $request4->request->set('employeeId', null);

        return [
            [$request, true],
            [$request2, false],
            [$request3, false],
            [$request4, false]
        ];
    }
}
