Feature: 
  In order to acces to the website protected pages   
  I need to be able to log in 

  Scenario: Log in 
    Given I am an unauthenticated user
    Given I am on "/login"
    When I fill in "username" with "celia68"
    When I fill in "password" with "test"
    When I press "Se connecter"

  Scenario: Log out
    Given I am an authenticated user
    When I follow "Se déconnecter"
    Then I should not see "Se déconnecter"

  Scenario Outline: Redirection to login page for unauthenticated users
    Given I am an unauthenticated user
    When I go to <url>
    Then I should be on "/login"

  Examples:
    | url               |
    | "/"               |
    | "/logout"         |
    | "/tasks"          |
    | "/tasks/create"   |
    | "/tasks/1/edit"   |
    | "/tasks/1/toggle" |
    | "/tasks/1/delete" |
# TO DO : restricted to admin:    | "/users"          |
# TO DO : restricted to admin:    | "/users/create"	|
# TO DO : restricted to admin:    | "/users/1/edit"	|
# TO DO : route doesn't exist yet:  | "/tasks/done"     |
