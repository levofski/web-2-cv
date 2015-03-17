<?php

namespace spec\Web2CV\Repositories;

use org\bovigo\vfs\vfsStream;
use Web2CV\Entities\DataNode;
use Web2CV\Entities\DataDocument;
use Web2CV\Codecs\Codec;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataDocumentFileSystemRepositorySpec extends ObjectBehavior
{
    /**
     * @var vfsStreamDirectory
     */
    private $storageDirectory;

    function let(Codec $codec)
    {
        $this->storageDirectory = vfsStream::setup('storage');
        $this->beConstructedWith($codec, vfsStream::url('storage'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Web2CV\Repositories\DataDocumentFileSystemRepository');
    }

    function it_should_store_a_data_document(DataDocument $dataDocument, DataNode $dataNode, Codec $codec)
    {
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        $jsonData = json_encode($arrayData);
        $dataDocumentName = 'test-document';
        // Setup mocks
        $dataDocument->getName()->willReturn($dataDocumentName);
        $dataDocument->toArray()->willReturn($arrayData);
        $dataNode->toArray()->willReturn($arrayData);
        $codec->encode($dataDocument)->willReturn($jsonData);
        $codec->decode($jsonData)->willReturn($dataNode);
        // Store and fetch the data
        $this->store($dataDocument);
        $this->fetch($dataDocumentName)->toArray()->shouldReturn($arrayData);
    }

    public function it_should_delete_a_data_document(DataDocument $dataDocument, DataNode $dataNode, Codec $codec)
    {
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        $jsonData = json_encode($arrayData);
        $dataDocumentName = 'test-document';
        // Setup mocks
        $dataDocument->getName()->willReturn($dataDocumentName);
        $dataDocument->toArray()->willReturn($arrayData);
        $dataNode->toArray()->willReturn($arrayData);
        $codec->encode($dataDocument)->willReturn($jsonData);
        $codec->decode($jsonData)->willReturn($dataNode);
        // Store and fetch the data
        $this->store($dataDocument);
        $this->fetch($dataDocumentName)->toArray()->shouldReturn($arrayData);
        $this->delete($dataDocumentName);
        $this->fetch($dataDocumentName)->shouldReturn(false);
    }
}
