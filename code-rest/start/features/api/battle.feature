Feature: Battle
  In order to get a lot done and save the world
  As a user
  I need to be able to start battles against projects

  Background:
    Given the user "weaverryan" exists
    And "weaverryan" has an authentication token "ABCD123"
    And I set the "Authorization" header to be "token ABCD123"

  Scenario: Create a battle
    Given there is a project called "my_project"
    And there is a programmer called "Fred"
    And I have the payload:
      """
      {
        "programmerId": "%programmers.Fred.id%",
        "projectId": "%projects.my_project.id%"
      }
      """
    When I request "POST /api/battles"
    Then the response status code should be 201
    And the "Content-Type" header should be "application/hal+json"
    And the "Location" header should exist
    And the "didProgrammerWin" property should exist

  Scenario: GET'ing a single battle
    Given there is a programmer called "Fred"
    And there is a project called "project_facebook"
    And there has been a battle between "Fred" and "project_facebook"
    When I request "GET /api/battles/%battles.last.id%"
    Then the response status code should be 200
    And the following properties should exist:
    """
    didProgrammerWin
    notes
    """
    And the embedded "programmer" should have a "nickname" property equal to "Fred"
    #And the link "programmer" should exist and its value should be "/api/programmers/Fred"

  Scenario: GET a collection of battles for a programmer
    Given there is a project called "projectA"
    Given there is a project called "projectB"
    And there is a programmer called "Fred"
    And there has been a battle between "Fred" and "projectA"
    And there has been a battle between "Fred" and "projectB"
    When I request "GET /api/programmers/Fred/battles"
    Then the response status code should be 200
    And the "_embedded.items" property should be an array
    And the "_embedded.items" property should contain 2 items
    And the "_embedded.items.0.didProgrammerWin" property should exist
