<?php

use AppBundle\Entity\User;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, KernelAwareContext
{
    private $id;
    protected $kernel;
    private $tokenStorage;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function setKernel(KernelInterface $kernelInterface)
    {
        $this->kernel = $kernelInterface;
    }

    /**
     * @Given I am an unauthenticated user
     */
    public function iAmAnUnauthenticatedUser()
    {
    }

    /**
     * @Given I am an authenticated user
     * @userLoggin
     */
    public function iAmAnAuthenticatedUser()
    {
        $this->visit('/login');
        $this->fillField('username', 'celia68');
        $this->fillField('password', 'test');
        $this->pressButton('Se connecter');
    }

    /**
     * @Given I am an admin
     * @userLoggin
     */
    public function iAmAnAdmin()
    {
        $this->visit('/login');
        $this->fillField('username', 'Emilie');
        $this->fillField('password', 'test');
        $this->pressButton('Se connecter');
        if (!$this->tokenStorage->getToken()) {
            return false;
        }
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user instanceof UserInterface && !\in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return false;
        }
    }

    /**
     * @Given there is a :entity named :name
     *
     * @param mixed $entity
     * @param mixed $name
     */
    public function thereIsANamed($entity, $name)
    {
        $entityExists = false;
        $this->visit(\sprintf('/%ss', $entity));
        $page = $this->getSession()->getPage();
        if ($page->find('named', ['content', $name])) {
            $entityExists = true;
        }

        if (false === $entityExists) {
            $this->visit(\sprintf('/%ss/create', $entity));

            if ('task' === $entity) {
                $this->fillTaskDatas($name);
            }

            if ('user' === $entity) {
                $this->fillUserData($name);
            }

            $this->pressButton('Ajouter');
        }

        $this->visit(\sprintf('/%ss', $entity));
        $link = $page->find('named', ['link', $name]);
        $url = $link->getAttribute('href');
        $explodedUrl = \explode('/', $url);
        $this->id = $explodedUrl[2];
    }

    public function fillTaskDatas($name)
    {
        $this->fillField('task_title', $name);
        $this->fillField('task_content', 'This is the text describing the task. It should be done until the end of the week.');
    }

    public function fillUserData($name)
    {
        $this->fillField('user_username', $name);
        $this->fillField('user_password_first', 'test');
        $this->fillField('user_password_second', 'test');
        $this->fillField('user_email', sprintf('%s@example.com', $name));
    }

    /**
     * @When I interact with the page to :action :name
     *
     * @param mixed $action
     * @param mixed $name
     */
    public function iInteractWithThePageTo($action, $name)
    {
        if ('edit' === $action) {
            $link = sprintf('/tasks/%s/edit', $this->id);
            $this->clickLink($link);
        } else {
            $selector = \sprintf('form[action="/tasks/%s/%s"] > .btn', $this->id, $action);
            $page = $this->getSession()->getPage();
            $button = $page->find('css', $selector);
            $this->pressButton($button);
        }
    }

    /**
     * @Given I am on the page to edit the :entity :name
     *
     * @param mixed $entity
     * @param mixed $name
     */
    public function iAmOnThePageToEditThe($entity, $name)
    {
        $this->visit(\sprintf('/%ss/%s/edit', $entity, $this->id));
        $this->assertResponseStatus(200);
    }

    /**
     * @When I wait for :secondsNumber seconds
     *
     * @param mixed $secondsNumber
     */
    public function iWaitForSeconds($secondsNumber)
    {
        \sleep($secondsNumber);
    }
}
