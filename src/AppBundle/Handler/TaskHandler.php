<?php

namespace AppBundle\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TaskHandler
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function handleTaskForm(FormInterface $form)
    {
        $task = $form->getData();
        $user = $this->tokenStorage->getToken()->getUser();
        $task->setUser($user);

        return true;
    }
}
