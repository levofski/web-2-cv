<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\WebApiExtension\Context\WebApiContext;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the API context, using browser (mink) to test.
 */
class APIContext extends WebApiContext implements Context, SnippetAcceptingContext
{
    /**
     * @var string
     * @todo this should come from environment config
     */
    protected $apiUrl = 'http://localhost:8000/api';
    /**
     * @var string
     */
    protected $documentName;

    /**
     * @var PyStringNode
     */
    protected $documentData;

    /**
     * @Given I have a Document named :documentName with data :
     */
    public function iHaveADocumentNamedWithData($documentName, PyStringNode $documentData)
    {
        $this->documentName = $documentName;
        $this->documentData = $documentData;
    }

    /**
     * @Given I store the Document
     */
    public function iStoreTheDocument()
    {
        $method = 'PUT';
        $url = $this->apiUrl.'/'.$this->documentName;
        $this->iSendARequestWithBody($method, $url, $this->documentData);
    }

    /**
     * @Then I should be able to fetch the :documentName Document
     */
    public function iShouldBeAbleToFetchTheDocument($documentName)
    {
        $method = 'GET';
        $url = $this->apiUrl.'/'.$this->documentName;
        $this->iSendARequest($method, $url);
    }

    /**
     * @Then the Document data should be :
     */
    public function theDocumentDataShouldBe(PyStringNode $data)
    {
        $this->theResponseShouldContainJson($data);
    }

    /**
     * @When I update the path :arg1 to :arg2
     */
    public function iUpdateThePathTo($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When I delete the path :arg1
     */
    public function iDeleteThePath($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I delete the :arg1 Document
     */
    public function iDeleteTheDocument($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should not be able to fetch the :arg1 Document
     */
    public function iShouldNotBeAbleToFetchTheDocument($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I read the path :arg1
     */
    public function iReadThePath($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the data should be :arg1
     */
    public function theDataShouldBe($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the JSON should be :
     */
    public function theJsonShouldBe(PyStringNode $string)
    {
        throw new PendingException();
    }
}
