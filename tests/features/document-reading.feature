Feature: Document Reading
  In order to share my data documents
  As a data owner
  I want to be able to read my data documents

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

  Scenario Outline: Reading string values
    When I read the path <path>
    Then the data should be <data>
    Examples:
      | path | data |
      | "key1" | "value1" |
      | "/key2" | "value2" |
      | "key3/0" | "child1" |
      | "/key3/child2/key4" | "grandChild1" |
      | "key3/1" | "child3" |

  Scenario: Reading JSON values, root
    When I read the path "/"
    Then the JSON should be :
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

  Scenario: Listing Documents
    When I list the Documents
    Then "test-data" should be listed

  Scenario: Reading JSON values, key3
    When I read the path "/key3"
    Then the JSON should be :
    """
    {
      "0":"child1",
      "child2":{
        "key4":"grandChild1"
      },
      "1":"child3"
    }
    """