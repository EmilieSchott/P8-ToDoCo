Feature: 
  In order to have a personnal todo list
  I need to be a registered user.

  @erase_datas
  Scenario: Create a user 
    Given I am an admin
    Given I am on "/users/create"
    When I fill in "user_username" with "User"
    When I fill in "user_password_first" with "test"
    When I fill in "user_password_second" with "test"
    When I fill in "user_email" with "user@example.com"
    When I press "Ajouter"
    When I wait for 1 seconds
    Then I should be on "/users" 
    Then I should see text matching "L'utilisateur a bien été ajouté."

  @erase_datas
  Scenario: Edit a user 
    Given I am an admin
    Given there is a "user" named "User"
    Given I am on the page to edit the "user"
    When I fill in "user_username" with "OtherUser"
    When I fill in "user_password_first" with "test"
    When I fill in "user_password_second" with "test"
    When I press "Modifier"
    When I wait for 1 seconds
    Then I should be on "/users"  
    Then I should see text matching "L'utilisateur a bien été modifié"

  Scenario Outline: Authenticated users other than admin can't access to users management pages.
    Given I am <role>
    When I go to <url>
    Then the response status code should be <code>

  Examples:
    | role                  | url             | code |
    | an authenticated user | "/users"        | 403  |
    | an authenticated user | "/users/create" | 403	 |
    | an authenticated user | "/users/1/edit" | 403	 |



