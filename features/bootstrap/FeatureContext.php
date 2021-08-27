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
    private $Id;
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
        $page = $this->getSession()->getPage();
        if ($page->find('named', ['content', $name])) {
            $entityExists = true;
        }

        if (false === $entityExists) {
            if ('task' === $entity) {
                $this->visit('/tasks/create');
                $this->fillField('task_title', $name);
                $this->fillField('task_content', 'This is the text describing the task. It should be done until the end of the week.');
                $this->pressButton('Ajouter');
            }

            if ('user' === $entity) {
                $this->visit('/users/create');
                $this->fillField('user_username', $name);
                $this->fillField('user_password_first', 'test');
                $this->fillField('user_password_second', 'test');
                $this->fillField('user_email', sprintf('%s@example.com', $name));
            }
        }

        if ('task' === $entity) {
            $link = $page->find('named', ['link', $name]);
            $url = $link->getAttribute('href');
            $explodedUrl = \explode('/', $url);
            $this->id = $explodedUrl[1];
        }

        if ('user' === $entity) {
            $tdTags = $page->findAll('css', 'td');
            $nameKey = \array_search($name, $tdTags, true);
            $linkKey = $nameKey + 2;
            $link = (string) $tdTags[$linkKey];
            $explodedLink = \explode('/', $link);
            $this->id = $explodedLink[2];
        }
    }

    /**
     * @When I interact with the page to :action :name
     *
     * @param mixed $action
     * @param mixed $name
     */
    public function iInteractWithThePageTo($action, $name)
    {
        $page = $this->getSession()->getPage();
        $link = $page->find('named', ['link', $name]);
        $url = $link->getAttribute('href');
        $explodedUrl = \explode('/', $url);
        $this->id = $explodedUrl[1];
        if ('edit' === $action) {
            $link = sprintf('/tasks/%s/edit', $this->id);
            $this->clickLink($link);
        } else {
            $selector = \sprintf('form[action="/tasks/%s/%s"] > .btn', $this->id, $action);
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
        $this->visit(\sprintf('/%s/%s/edit', $entity, $this->id));
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

    /*
     * @AfterSuite
     */
}
