<?php

use Web2CV\Entities\DataDocument;
use Web2CV\Repositories\DataDocumentFileSystemRepository as DocumentRepository;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the domain context.
 */
class DomainContext implements Context, SnippetAcceptingContext
{
    /**
     * @Given I have a Document named :documentName
     */
    public function iHaveADocumentNamed($documentName)
    {
        $this->dataDocument = DataDocument::create($documentName);
    }

    /**
     * @When I store the :documentName Document
     */
    public function iStoreTheDocument($documentName)
    {
        DocumentRepository::store($this->dataDocument);
    }

    /**
     * @Then I should be able to view the :documentName Document
     */
    public function iShouldBeAbleToViewTheDocument($documentName)
    {
        $dataDocument = DocumentRepository::load($documentName);
        PHPUnit::assertInstanceOf('DataDocument', $dataDocument);
    }
}
