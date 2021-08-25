Feature: 
  In order to make a to do list
  As an authenticated user
  I need to be able to see my task list, create, modify, delete or toggled tasks.

  Scenario Outline: Using links
    Given I am an authenticated user
    Given I am on <page>
    When I follow <link>
    When I wait for 1 seconds
    Then I should be on <url>
    
  Examples:
    | page            | link                           | url             |
    | "/tasks/create" | "Retour à la liste des tâches" | "/tasks"        |
    | "/tasks"        | "Créer une tâche"              | "/tasks/create" |

 Scenario: Create a task 
    Given I am an authenticated user
    Given I am on "/tasks/create"
    When I fill in "task_title" with "New task"
    When I fill in "task_content" with:
    """
    This is the text describing the new task that. It should be done until the end of the week.
    """
    When I press "Ajouter"
    When I wait for 1 seconds
    Then I should be on "/tasks" 
    Then I should see text matching "La tâche a été bien été ajoutée."

# TO DO : status code 500:
#  Scenario: Edit a task 
#    Given I am an authenticated user
#    Given there is a "task" named "New task"
#    Given I am on the page to edit the "task" "New task"
#    When I fill in "task_title" with "Modified task"
#    When I press "Modifier"
#    When I wait for 1 seconds
#    Then I should be on "/tasks"  
#    Then I should see text matching "La tâche a bien été modifiée."
  
  Scenario Outline: interact with a task 
    Given I am an authenticated user
    Given there is a "task" named <title>
    Given I am on "/tasks"
    When I interact with the page to <action> <title> 
    When I wait for 1 seconds
    Then I should be on "/tasks" 
    Then I should see text matching <success>

  Examples:
    | title            | action   | success                                                     |
# TO DO : status code 500:   | "Modified Task"  | "delete" | "La tâche a bien été supprimée."                            |
# TO DO : status code 500:   | "Task to toggle" | "toggle" | "La tâche Task to toggle a bien été marquée comme faite."   |

