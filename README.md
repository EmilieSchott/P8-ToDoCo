# An application to make Todo list

---

## Installation

1. Clone this repository.

2. With a CLI, place yourself in the project folder and run "composer install" command.

3. In .env, choose your DBMS by remove the # before the DATABASE_URL required and complete asked informations. Then, type in the CLI the 2 following commands :
    "php bin/console doctrine:database:create"
    "php bin/console doctrine:schema:create"

4. To update tables in the database, type in CLI :
    "symfony console doctrine:migrations:migrate"

5. Check fixtures directory to decide which fixtures you want in your database and define an account login and password for you (in fixtures/User.yaml > user1).
    Don't forget to hash your password before type it in the fixtures. Use "symfony console security:hash-password" command to obtain it. If the hashed password contains "\$" character, you should escape it.
    Then type in CLI : "php bin/console hautelook:fixtures:load".

6. In a CLI, type : "composer dump-autoload --optimize" to generate optimize classmap.

---

## Documentation

Regarding:

- [Authentification](./docs/authentification.md)
- [Contribution](./docs/contribution.md)
- [Tests](./docs/tests.md)

---
