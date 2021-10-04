# Authentification

---

## Principle

- When the user tries to access a resource that is protected, the firewall initiates the authentication process by redirecting the user to the login form.

- The logic to display the login form and handle it is in the [SecurityController.php](../src/AppBundle/Controller/SecurityController.php). The routes names associated with theses actions should figure in the configuration file (see below).

- When the login form is requested, the SecurityController display the  [twig template](../app/Resources/views/security/login.html.twig). The user fill the login form by typing their username and password and press "Se connecter" button.

- When the user submits the form, the security system automatically handles the form submission. The request is intercepted and the user’s submitted credentials are checked : Doctrine make request to the database where user's datas are stored.

- If the user submits an invalid username or password, the SecurityController reads the form submission error from the security system, the user is sending back to the login form where the error message can be displayed.

- If the informations are correct, the user is authenticated : the user datas are put in a User object which is used to create an authentication token object, itself stored in a TokenStorageInterface object.  

- When access at some pages is limited to specific roles, you should retrieve the authentication token from the token storage to control information stored in it.

You can find further informations in Symfony documentation :

- [Security](https://symfony.com/doc/3.4/security.html)
- [Build a traditionnal login form](https://symfony.com/doc/3.4/security/form_login_setup.html)
- [Load Security Users from the Database (the Entity Provider)](https://symfony.com/doc/3.4/security/entity_provider.html)

---

## Configuration

The authentification configuration is made in [security.yml](../app/config/security.yml). In this file, you could :

- **choose the algorythm to encode user password**
Under "*encoders*" section.
Here we choose bcrypt but other algorythms are available. You should specify the the user entity namespace where the password are in.

- **defines how the application users are loaded**
Under "*providers*" section.
You should specify the provider which create the link between the database where users datas are stocked and the [User entity](../src/AppBundle/Entity/User.php) (to use the User entity in the security system, it must implement *Symfony\Component\Security\Core\User\UserInterface*).
In this project, we use *Doctrine* for this purpose.
You should also precise the User entity class and which User classe property will be used as username.

- **tell by which way users could authenticated themselves**
Under "*firewalls*" > "*main*".
In this project, we use a login form. You can specify route names to access the form (under "login_path") and handle it (under "check_path"). If you modify them, don't forget to change @Route annotations in [SecurityController.php](../src/AppBundle/Controller/SecurityController.php) too.

- **tell which minimal role users is needed to access some pages**
Under "*access_control*". It defines the roles allowed to access to the URLs of the application for security protection purposes. (e.g.: access to backend application only granted to ROLE_ADMIN)

- **specify the application role hierarchy**
Under "*role_hierarchy*" section. You could define role inheritance rules for the different roles available for your users. (e.g. : A user with ROLE_ADMIN has also ROLE_USER privileges.If you specify it in role hierarchy, it's no longer necessary to give the two roles to the user : ROLE_ADMIN becomes sufficent.)

You can find informations to configure other options in [Security configuration from Symfony documentation](https://symfony.com/doc/3.4/reference/configuration/security.html#access-denied-url)

---
