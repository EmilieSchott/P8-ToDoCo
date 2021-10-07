Feature: 
  Test homepage navigation

  Scenario Outline: Using links
    Given I am an authenticated user
    Given I am on homepage
    When I follow <link>
    Then I should be on <linkUrl>
    
  Examples:
    | link                                      | linkUrl           |
    | "Créer une nouvelle tâche"                | "/tasks/create"   |
    | "Consulter la liste des tâches à faire"   | "/tasks"          |
# TO DO : give path in link href attribute:    | "Consulter la liste des tâches terminées" | "/tasks/done"     |

