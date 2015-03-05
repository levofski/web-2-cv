<?php

namespace spec\Web2CV\Entities;

use Web2CV\Entities\DataNode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataDocumentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Web2CV\Entities\DataDocument');
    }

    function let($name)
    {
        $this->beConstructedThrough('create', [$name]);
    }

    /** To/From array */
    function it_can_be_created_from_an_array_of_primitives()
    {
        $name = "test-document";
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        $this->beConstructedThrough('create', [$name, $arrayData]);
        $this->toArray()->shouldReturn($arrayData);
    }

    function it_can_be_populated_from_an_array_of_primitives()
    {
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        $this->fromArray($arrayData);
        $this->toArray()->shouldReturn($arrayData);
    }

    function it_can_be_populated_from_an_array_of_data_nodes(DataNode $dataNode1, DataNode $dataNode2, DataNode $dataNode3)
    {
        $dataNode1Data = ["dataNode1Key1" => "dataNode1Value1"];
        $dataNode2Data = ["dataNode2Key1" => "dataNode2Value1", "dataNode2Value2"];
        $dataNode3Data = ["dataNode3Key1" => "dataNode3Value1", "dataNode3Value2", "dataNode3Key3" => "dataNode3Value3"];
        $dataNode1->toArray()->willReturn($dataNode1Data);
        $dataNode2->toArray()->willReturn($dataNode2Data);
        $dataNode3->toArray()->willReturn($dataNode3Data);
        $inputArrayData = ["key1" => "value1", "key2" => $dataNode1, "key3" => ["child1","child2" => ["key4" => $dataNode2],"child3"], $dataNode3];
        $this->fromArray($inputArrayData);
        $outputArrayData = ["key1" => "value1", "key2" => $dataNode1Data, "key3" => ["child1","child2" => ["key4" => $dataNode2Data],"child3"], $dataNode3Data];
        $this->toArray()->shouldReturn($outputArrayData);
    }

}
