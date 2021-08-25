Feature: 
  In order to have a personnal todo list
  I need to be a registered user.

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

# TO DO : status code 500: 
#  Scenario: Edit a user 
#    Given I am an authenticated user
#    Given there is a "user" named "User"
#    Given I am on the page to edit the "user" "User"
#    When I fill in "user_email" with "other.user@example.com"
#    When I press "Modifier"
#    When I wait for 1 seconds
#    Then I should be on "/users"  
#    Then I should see text matching "L'utilisateur a bien été modifié"
