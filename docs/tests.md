# Tests

---

## Unit tests

With a CLI, place you at the project folder root and :

- To launch all tests : type in the CLI "vendor/bin/phpunit"
- To launch only failed tests and stop when a test failed again : type in the CLI "vendor/bin/phpunit --order-by=defects --stop-on-defect"
- To generate code coverage report : type in the CLI "vendor/bin/phpunit --coverage-html web/test-coverage" then, in your browser, visit "https://your-website/test-coverage/"

---

## Functional tests

With a CLI, place you at the project folder root and :

- To launch all tests : type in the CLI "vendor/bin/behat"
- To stop tests when failed : "vendor/bin/behat --stop-on-failure"
- To launch tests from a specific feature file (in features folder) : "vendor/bin/behat features/file.feature"

---
