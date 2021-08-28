Feature: 
  Application smoke tests  

  Scenario Outline: Acces to application pages
    Given I am <role>
    When I go to <url>
    Then the response status code should be 200

  Examples:
    | role                      | url               |
    | an unauthenticated user   | "/login"          |
    | an authenticated user     | "/logout"         |
    | an authenticated user     | "/"               |
    | an authenticated user     | "/tasks"          |
    | an authenticated user     | "/tasks/create"   |
    | an authenticated user     | "/tasks/1/edit"   |
    | an admin                  | "/users"          |
    | an admin                  | "/users/create"	|
    | an admin                  | "/users/1/edit"	|
# TO DO : add method in TaskController: | an authenticated user     | "/tasks/done"     |








 

    