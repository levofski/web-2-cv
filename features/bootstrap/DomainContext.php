<?php

use Web2CV\Entities\DataDocument;
use Web2CV\Repositories\DataDocumentFileSystemRepository as DocumentRepository;
use Web2CV\Codecs\JSONCodec as Codec;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the domain context.
 */
class DomainContext implements Context, SnippetAcceptingContext
{
    /**
     * @var DataDocument $dataDocument
     */
    protected $dataDocument;

    /**
     * @var vfsStreamDirectory
     */
    private $storageDirectory;

    /**
     * @var DocumentRepository $documentRepository
     */
    protected $documentRepository;

    /**
     * @var Codec $codec
     */
    protected $codec;

    /**
     * @BeforeScenario
     */
    public function setupScenario(BeforeScenarioScope $scope)
    {
        $this->codec = new Codec();
        $this->storageDirectory = vfsStream::setup('storage');
        $this->documentRepository = new DocumentRepository($this->codec, vfsStream::url('storage'));
    }

    /**
     * @Given I have a Document named :documentName with data :
     */
    public function iHaveADocumentNamedWithData($documentName, PyStringNode $data)
    {
        $decodedData = $this->codec->toDataNode($data);
        $this->dataDocument = DataDocument::create($documentName, $decodedData);
    }

    /**
     * @When I store the :documentName Document
     */
    public function iStoreTheDocument($documentName)
    {
        $this->documentRepository->store($this->dataDocument);
    }

    /**
     * @Then I should be able to view the :documentName Document
     */
    public function iShouldBeAbleToViewTheDocument($documentName)
    {
        $dataDocument = $this->documentRepository->fetch($documentName);
        PHPUnit::assertInstanceOf('Web2CV\Entities\DataDocument', $dataDocument);
        $this->dataDocument = $dataDocument;
    }

    /**
     * @Then the data should be :
     */
    public function theDataShouldBe(PyStringNode $data)
    {
        $documentData = $this->codec->fromData($this->dataDocument);
        PHPUnit::assertJsonStringEqualsJsonString($data->getRaw(), $documentData);
    }
}
