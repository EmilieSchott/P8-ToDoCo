# An application to make Todo list

## Installation

---

1.  Clone this repository.

2.  With a CLI, place yourself in the project folder and run "composer install" command.

3.  In .env, choose your DBMS by remove the # before the DATABASE_URL required and complete asked informations. Then, type in the CLI the 2 following commands :
    "php bin/console doctrine:database:create"
    "php bin/console doctrine:schema:create"

4.  To update tables in the database, type in CLI :
    "symfony console doctrine:migrations:migrate"

5.  Check fixtures directory to decide which fixtures you want in your database and define an account login and password for you (in fixtures/User.yaml > user1).
    Don't forget to hash your password before type it in the fixtures. Use "symfony console security:hash-password" command to obtain it. If the hashed password contains "\$" character, you should escape it.
    Then type in CLI : "php bin/console hautelook:fixtures:load".

## Tests

---

With a CLI, place you at the project folder root and :

- To launch all tests : type in the CLI "vendor/bin/phpunit"
- To launch only failed tests and stop when a test failed again : type in the CLI "vendor/bin/phpunit --order-by=defects --stop-on-defect"
- To launch a specific functionnal test and see resulting page : type in the CLI "vendor/bin/phpunit --filter=yourTestNameHere > web/resultTest.html", then, in your browser, go to "https://127.0.0.1:8000/resultTest.html"
- To generate code coverage report : type in the CLI "vendor/bin/phpunit --coverage-html web/test-coverage"
