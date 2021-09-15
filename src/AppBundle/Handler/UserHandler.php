<?php

namespace AppBundle\Handler;

use AppBundle\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandler
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function handleUserForm(FormInterface $form)
    {
        /** @var User $user */
        $user = $form->getData();
        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        return true;
    }
}
