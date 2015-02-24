Feature: Laravel Behat Extension
  In order to make testing setup easier
  As a teacher
  I want to show an example of installing and using the Laravel Behat extension.

  Scenario: Dummy Example
    Given I am on the homepage
    Then I should see "Laravel 5"
  
  Scenario: Dashboard Protected from guests
    When I go to "home"
    Then the url should match "auth/login"
    And I should be able to do something with Laravel
