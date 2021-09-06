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
            throw new \Exception("L'entité existe déjà");
            $entityExists = true;
        }

        if (false === $entityExists) {
            $this->visit(\sprintf('/%ss/create', $entity));

            if ('task' === $entity) {
                $this->fillTaskDatas($name);
            }

            if ('user' === $entity) {
                $this->fillUserDatas($name);
            }

            $this->pressButton('Ajouter');
            $this->visit(\sprintf('/%ss', $entity));
            $page = $this->getSession()->getPage();
        }

        $link = $page->findLink($name);
        if (null === $link) {
            throw new \Exception('The link is not found');
        }
        $url = $link->getAttribute('href');
        $explodedUrl = \explode('/', $url);
        $this->id = $explodedUrl[2];
    }

    public function fillTaskDatas($name)
    {
        $this->fillField('task_title', $name);
        $this->fillField('task_content', 'This is the text describing the task. It should be done until the end of the week.');
    }

    public function fillUserDatas($name)
    {
        $this->fillField('user_username', $name);
        $this->fillField('user_password_first', 'test');
        $this->fillField('user_password_second', 'test');
        $this->fillField('user_email', sprintf('%s@example.com', $name));
    }

    /**
     * @When I interact with the :action button on :entity list page
     *
     * @param mixed $action
     * @param mixed $entity
     */
    public function iInteractWithTheButtonOnListPage($action, $entity)
    {
        $page = $this->getSession()->getPage();
        $selector = \sprintf('form[action="/%ss/%s/%s"]', $entity, $this->id, $action);
        $form = $page->find('css', $selector);
        if (null === $form) {
            throw new \Exception('The element is not found');
        }

        $button = $form->find('css', '.btn');
        $button->press();
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
