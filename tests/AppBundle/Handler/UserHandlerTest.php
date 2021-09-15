<?php

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Handler\UserHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UserHandlerTest extends KernelTestCase
{
    private $userHandler;

    public function setUp():void
    {
        self::bootKernel();

        $this->userHandler = static::$kernel->getContainer()->get(UserHandler::class);
    }

    public function testHandleUserFormEncodePassword(): void
    {
        $user = new User();
        $user->setPassword('test');
        $form = static::$kernel->getContainer()->get('form.factory')->create(UserType::class, $user);
        $this->userHandler->handleUserForm($form);
        $this->assertStringStartsWith('$2y$', $user->getPassword());
    }

    public function testHandleUserFormReturnTrue(): void
    {
        $user = new User();
        $user->setPassword('test');
        $form = static::$kernel->getContainer()->get('form.factory')->create(UserType::class, $user);
        $this->assertTrue($this->userHandler->handleUserForm($form));
    }
}
