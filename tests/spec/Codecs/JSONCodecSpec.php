<?php

namespace spec\Web2CV\Codecs;

use Web2CV\Entities\DataNode;
use Web2CV\Entities\DataDocument;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JSONCodecSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Web2CV\Codecs\JSONCodec');
    }

    function it_should_convert_json_to_data_node()
    {
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        $jsonData = json_encode($arrayData);
        $this->decode($jsonData)->shouldHaveType('Web2CV\Entities\DataNode');
        $this->decode($jsonData)->toArray()->shouldReturn($arrayData);
    }

    function it_should_convert_data_node_to_json(DataNode $dataNode)
    {
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        $jsonData = json_encode($arrayData);
        $dataNode->toArray()->willReturn($arrayData);
        $this->encode($dataNode)->shouldReturn($jsonData);
    }

    function it_should_convert_data_document_to_json(DataDocument $dataDocument)
    {
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        $jsonData = json_encode($arrayData);
        $dataDocument->toArray()->willReturn($arrayData);
        $this->encode($dataDocument)->shouldReturn($jsonData);
    }
}
