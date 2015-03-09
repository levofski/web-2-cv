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
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @Then I should be able to fetch the :documentName Document
     */
    public function iShouldBeAbleToFetchTheDocument($documentName)
    {
        $method = 'GET';
        $url = $this->apiUrl.'/'.$documentName;
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @Then the Document data should be :
     */
    public function theDocumentDataShouldBe(PyStringNode $data)
    {
        $this->theResponseShouldContainJson($data);
    }

    /**
     * @When I update the path :path to :data
     */
    public function iUpdateThePathTo($path, $data)
    {
        $method = 'POST';
        $url = $this->apiUrl.'/'.$this->documentName.'/'.$path;
        $this->iSendARequestWithBody($method, $url, $data);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @When I delete the path :path
     */
    public function iDeleteThePath($path)
    {
        $method = 'DELETE';
        $url = $this->apiUrl.'/'.$this->documentName.'/'.$path;
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @When I delete the :documentName Document
     */
    public function iDeleteTheDocument($documentName)
    {
        $method = 'DELETE';
        $url = $this->apiUrl.'/'.$documentName;
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @Then I should not be able to fetch the :documentName Document
     */
    public function iShouldNotBeAbleToFetchTheDocument($documentName)
    {
        $method = 'GET';
        $url = $this->apiUrl.'/'.$documentName;
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(404);
    }

    /**
     * @When I read the path :path
     */
    public function iReadThePath($path)
    {
        $method = 'GET';
        $url = $this->apiUrl.'/'.$this->documentName.'/'.$path;
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @Then the data should be :data
     */
    public function theDataShouldBe($data)
    {
        $this->theResponseShouldContain($data);
    }

    /**
     * @Then the JSON should be :
     */
    public function theJsonShouldBe(PyStringNode $data)
    {
        $this->theResponseShouldContainJson($data);
    }
}
