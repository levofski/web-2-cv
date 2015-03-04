Feature: Document Management
  In order to share my data documents
  As a data owner
  I want to be able to manage my data documents

  Scenario: Creating a Document
    Given I have a Document named "test-data"
    When I upload the "test-data" Document
    Then I should be able to access the "test-data" Document
