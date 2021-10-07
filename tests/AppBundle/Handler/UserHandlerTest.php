<?php

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Handler\UserHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UserHandlerTest extends KernelTestCase
{
    private $userHandler;
    private $user;
    private $form;

    public function setUp(): void
    {
        self::bootKernel();

        $this->userHandler = static::$kernel->getContainer()->get(UserHandler::class);

        $user = new User();
        $user->setPassword('test');
        $user->setRoles(['ROLE_USER']);
        $this->user = $user;

        $form = static::$kernel->getContainer()->get('form.factory')->create(UserType::class, $user);
        $this->form = $form;
    }

    public function testHandleUserFormEncodePassword(): void
    {
        $this->userHandler->handleUserForm($this->form);
        $this->assertStringStartsWith('$2y$', $this->user->getPassword());
    }

    public function testHandleUserFormReturnTrue(): void
    {
        $this->assertTrue($this->userHandler->handleUserForm($this->form));
    }
}