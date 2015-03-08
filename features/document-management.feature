Feature: Document Management
  In order to share my data documents
  As a data owner
  I want to be able to manage my data documents

  Background:
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
    And I store the Document

  Scenario: Creating a Document
    Then I should be able to fetch the "test-data" Document
    And the Document data should be :
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

  Scenario: A Simple Document Update
    When I update the path "key2" to "newValue2"
    Then the Document data should be :
    """
    {
      "key1":"value1",
      "key2":"newValue2",
      "key3":{
        "0":"child1",
        "child2":{
          "key4":"grandChild1"
        },
        "1":"child3"
      }
    }
    """

  Scenario: A Complex Document Update
    When I update the path "key3/child2/key4" to "newGrandChild1"
    Then the Document data should be :
    """
    {
      "key1":"value1",
      "key2":"value2",
      "key3":{
        "0":"child1",
        "child2":{
          "key4":"newGrandChild1"
        },
        "1":"child3"
      }
    }
    """

  Scenario: A Simple Data Insertion
    When I update the path "key5" to "value5"
    Then the Document data should be :
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
      },
      "key5":"value5"
    }
    """

  Scenario: A Complex Data Insertion
    When I update the path "key3/child2/key5" to "grandChild2"
    Then the Document data should be :
    """
    {
      "key1":"value1",
      "key2":"value2",
      "key3":{
        "0":"child1",
        "child2":{
          "key4":"grandChild1",
          "key5":"grandChild2"
        },
        "1":"child3"
      }
    }
    """

  Scenario: A Simple Data Deletion
    When I delete the path "key2"
    Then the Document data should be :
    """
    {
      "key1":"value1",
      "key3":{
        "0":"child1",
        "child2":{
          "key4":"grandChild1"
        },
        "1":"child3"
      }
    }
    """

  Scenario: A Complex Data Deletion
    When I delete the path "key3/child2/key4"
    Then the Document data should be :
    """
    {
      "key1":"value1",
      "key2":"value2",
      "key3":{
        "0":"child1",
        "child2":[],
        "1":"child3"
      }
    }
    """

  Scenario: Deleting a Document
    When I delete the "test-data" Document
    Then I should not be able to fetch the "test-data" Document
