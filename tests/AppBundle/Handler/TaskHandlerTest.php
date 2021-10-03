<?php

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Form\TaskType;
use AppBundle\Handler\TaskHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

final class TaskHandlerTest extends KernelTestCase
{
    private $taskHandler;
    private $task;
    private $form;

    public function setUp(): void
    {
        self::bootKernel();

        $this->taskHandler = static::$kernel->getContainer()->get(TaskHandler::class);

        $user = new User();
        $user->setUsername('User');
        $token = new UsernamePasswordToken($user, 'password', 'provider', ['ROLE_USER']);
        static::$kernel->getContainer()->get('security.token_storage')->setToken($token);

        $task = new Task();
        $this->task = $task;

        $form = static::$kernel->getContainer()->get('form.factory')->create(TaskType::class, $task);
        $this->form = $form;
    }

    public function testHandleTaskFormLinksTaskToUser(): void
    {
        $this->taskHandler->handleTaskForm($this->form);
        $this->assertEquals('User', $this->task->getUser()->getUsername());
    }

    public function testHandleUserFormReturnTrue(): void
    {
        $this->assertTrue($this->taskHandler->handleTaskForm($this->form));
    }
}
