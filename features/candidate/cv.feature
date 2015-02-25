Feature: CV display
  In order to get a job
  As a candidate
  I want to display my CV data

  Scenario: Add a new CV
    Given I am on the CV list
    Then I click "Add CV"
    Then I should see a new CV form
  
  Scenario: Edit existing CV
    Given I am on the CV list
    And I have a CV
    Then I click "Edit CV"
    Then I should see the edit CV form
