<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\WebApiExtension\Context\WebApiContext;

/**
 * Defines application features from the API context, using browser (mink) to test.
 */
class APIContext extends WebApiContext implements Context, SnippetAcceptingContext
{
    /**
     * @var string
     * @todo this should come from environment config
     */
    protected $apiUrl = 'http://web-2-cv.dev/api';
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
     * @AfterScenario
     */
    public function tearDown()
    {
        $method = 'DELETE';
        $url = $this->buildUrl($this->documentName);
        $this->iSendARequest($method, $url);
    }

    /**
     * Build a well-formed URL
     * @param string $documentName
     * @param string $path
     */
    protected function buildUrl($documentName, $path=null)
    {
        $url = $this->apiUrl;
        if ($documentName)
        {
            $url .= '/'.trim($documentName, '/');
        }
        if ($path)
        {
            $url .= '/'.trim($path, '/');
        }
        return $url;
    }

    /**
     * @Given I store the Document
     */
    public function iStoreTheDocument()
    {
        $method = 'PUT';
        $url = $this->buildUrl($this->documentName);
        $this->iSendARequestWithBody($method, $url, $this->documentData);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @Then I should be able to fetch the :documentName Document
     */
    public function iShouldBeAbleToFetchTheDocument($documentName)
    {
        $method = 'GET';
        $url = $this->buildUrl($documentName);
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @Then the Document data should be :
     */
    public function theDocumentDataShouldBe(PyStringNode $data)
    {
        $method = 'GET';
        $url = $this->buildUrl($this->documentName);
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(200);
        $this->theResponseShouldContainJson($data);
    }

    /**
     * @When I update the path :path to :data
     */
    public function iUpdateThePathTo($path, $data)
    {
        $method = 'POST';
        $url = $this->buildUrl($this->documentName, $path);
        // To be a Json string, the data must be wrapped in double-quotes
        $data = '"'.$data.'"';
        $jsonData = new PyStringNode(array($data), 0);
        $this->iSendARequestWithBody($method, $url, $jsonData);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @When I delete the path :path
     */
    public function iDeleteThePath($path)
    {
        $method = 'DELETE';
        $url = $this->buildUrl($this->documentName, $path);
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @When I delete the :documentName Document
     */
    public function iDeleteTheDocument($documentName)
    {
        $method = 'DELETE';
        $url = $this->buildUrl($documentName);
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * @Then I should not be able to fetch the :documentName Document
     */
    public function iShouldNotBeAbleToFetchTheDocument($documentName)
    {
        $method = 'GET';
        $url = $this->buildUrl($documentName);
        $this->iSendARequest($method, $url);
        $this->theResponseCodeShouldBe(404);
    }

    /**
     * @When I read the path :path
     */
    public function iReadThePath($path)
    {
        $method = 'GET';
        $url = $this->buildUrl($this->documentName, $path);
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
