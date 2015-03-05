Feature: Document Management
  In order to share my data documents
  As a data owner
  I want to be able to manage my data documents

  Scenario: Creating a Document
    Given I have a Document named "test-data" with data :
    """
    {
      "key1":"value1",
      "key2":"value2",
      "key3":{
        "0":"child1",
        "child2":{
          "key4":"grandChild1"
        },
        "1":"child3"
      }
    }
    """
    When I store the "test-data" Document
    Then I should be able to view the "test-data" Document
    And the data should be :
    """
    {
      "key1":"value1",
      "key2":"value2",
      "key3":{
        "0":"child1",
        "child2":{
          "key4":"grandChild1"
        },
        "1":"child3"
      }
    }
    """
