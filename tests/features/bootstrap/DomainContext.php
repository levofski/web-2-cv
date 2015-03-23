<?php

use Web2CV\Entities\DataDocument;
use Web2CV\Entities\DataNode;
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
     * @var array $dataDocuments
     */
    protected $dataDocuments;

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
     * @Given I am authenticating as :username with :password password
     */
    public function iAmAuthenticatingAsWithPassword($username, $password)
    {
        // Auth is outside scope of the Domain Context, do nothing
    }

    /**
     * @Given I have a Document named :documentName with data :
     */
    public function iHaveADocumentNamedWithData($documentName, PyStringNode $data)
    {
        $decodedData = $this->codec->decode($data);
        $this->dataDocument = DataDocument::create($documentName, $decodedData);
    }

    /**
     * @When I store the Document
     */
    public function iStoreTheDocument()
    {
        $this->documentRepository->store($this->dataDocument);
    }

    /**
     * @When I delete the :documentName Document
     */
    public function iDeleteTheDocument($documentName)
    {
        $this->documentRepository->delete($documentName);
    }

    /**
     * @Then I should be able to fetch the :documentName Document
     */
    public function iShouldBeAbleToFetchTheDocument($documentName)
    {
        $dataDocument = $this->documentRepository->fetch($documentName);
        PHPUnit::assertInstanceOf('Web2CV\Entities\DataDocument', $dataDocument);
        $this->dataDocument = $dataDocument;
    }

    /**
     * @Then I should not be able to fetch the :documentName Document
     */
    public function iShouldNotBeAbleToFetchTheDocument($documentName)
    {
        $dataDocument = $this->documentRepository->fetch($documentName);
        PHPUnit::assertFalse($dataDocument);
    }

    /**
     * @Then the data should be :data
     */
    public function theDataShouldBe($data)
    {
        PHPUnit::assertEquals($data, $this->pathData);
    }

    /**
     * @Then the JSON should be :
     */
    public function theJsonShouldBe(PyStringNode $data)
    {
        PHPUnit::assertJsonStringEqualsJsonString($data->getRaw(), $this->pathData);
    }

    /**
     * @Then the Document data should be :
     */
    public function theDocumentDataShouldBe(PyStringNode $data)
    {
        $documentData = $this->codec->encode($this->dataDocument);
        PHPUnit::assertJsonStringEqualsJsonString($data->getRaw(), $documentData);
    }

    /**
     * @When I read the path :path
     */
    public function iReadThePath($path)
    {
        $pathData = $this->dataDocument->path($path);
        // Ensure the data is encoded
        $this->pathData = $this->codec->encode($pathData);
    }

    /**
     * @When I update the path :path to :data
     */
    public function iUpdateThePathTo($path, $data)
    {
        $this->dataDocument->path($path, $data);
    }

    /**
     * @When I delete the path :path
     */
    public function iDeleteThePath($path)
    {
        $this->dataDocument->unsetPath($path);
    }

    /**
     * @When I list the Documents
     */
    public function iListTheDocuments()
    {
        $this->dataDocuments = $this->documentRepository->fetchAll();
    }

    /**
     * @Then :documentName should be listed
     */
    public function shouldBeListed($documentName)
    {
        PHPUnit::assertEquals($this->dataDocument->toArray(), $this->dataDocuments[$documentName]->toArray());
    }
}
