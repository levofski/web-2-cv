<?php

namespace spec\Web2CV\Repositories;

use Web2CV\Entities\DataDocument;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataDocumentFileSystemRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Web2CV\Repositories\DataDocumentFileSystemRepository');
    }

    public function it_should_store_a_data_document(DataDocument $dataDocument)
    {
        $dataDocumentName = 'test-document';
        $dataDocument->getName()->willReturn($dataDocumentName);
        $this::store($dataDocument);
        $this::fetch($dataDocumentName)->shouldReturn($dataDocument);
    }
}
