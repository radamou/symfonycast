Feature: Authentication
  In order to access protected resource
  As an API client
  I need to be able to authenticate

  Scenario: Create a programmer without authentication
    When I request "POST /api/programmers"
    Then the response status code should be 401
    And the "detail" property should equal "Authentication Required"

  Scenario: Invalid token gives us a 401
    Given I set the "Authorization" header to be "token ABCDFAKE"
    When I request "POST /api/programmers"
    Then the response status code should be 401
    And the "Content-Type" header should be "application/problem+json"
    And the "detail" property should equal "Invalid Credentials!"
    And the "title" property should equal "Invalid or missing authentication!"
