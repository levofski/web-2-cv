<?php

namespace spec\Web2CV\Entities;

use Web2CV\Entities\DataNode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataNodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Web2CV\Entities\DataNode');
    }

    /** Primitive Children */
    function it_can_contain_a_primitive()
    {
        $this->set("string");
        $this->get()->shouldReturn(["string"]);
        $this->get(1)->shouldReturn("string");
    }

    function it_can_contain_a_named_primitive()
    {
        $this->set("string", 'child');
        $this->get()->shouldReturn(['child' => "string"]);
        $this->get('child')->shouldReturn("string");
    }

    function it_can_contain_multiple_primitives()
    {
        $this->set("string");
        $this->get()->shouldReturn(["string"]);
        $this->set(99);
        $this->get()->shouldReturn(["string", 99]);
        $this->get(1)->shouldReturn("string");
        $this->get(2)->shouldReturn(99);
    }

    function it_can_contain_multiple_named_primitives()
    {
        $this->set("string", 'child1');
        $this->get()->shouldReturn(['child1' => "string"]);
        $this->set(99, 'child2');
        $this->get()->shouldReturn(['child1' => "string", 'child2' => 99]);
        $this->get('child1')->shouldReturn("string");
        $this->get('child2')->shouldReturn(99);
    }

    function it_can_contain_multiple_named_and_unnamed_primitives()
    {
        $this->set("string", 'child1');
        $this->get()->shouldReturn(['child1' => "string"]);
        $this->set(99);
        $this->get()->shouldReturn(['child1' => "string", 99]);
        $this->set(3.14, 'child2');
        $this->get()->shouldReturn(['child1' => "string", 99, 'child2' => 3.14]);
        $this->get('child1')->shouldReturn("string");
        $this->get(1)->shouldReturn(99);
        $this->get('child2')->shouldReturn(3.14);
    }

    /** DataNode children */
    function it_can_contain_a_data_node(DataNode $dataNode)
    {
		$this->set($dataNode);
		$this->get()->shouldReturn([$dataNode]);
        $this->get(1)->shouldReturn($dataNode);
    }
    
    function it_can_contain_a_named_data_node(DataNode $dataNode)
    {
		$this->set($dataNode, 'child');
		$this->get()->shouldReturn(['child' => $dataNode]);
		$this->get('child')->shouldReturn($dataNode);
    }
    
    function it_can_contain_multiple_data_nodes(DataNode $dataNode1, DataNode $dataNode2)
    {
		$this->set($dataNode1);
		$this->get()->shouldReturn([$dataNode1]);
		$this->set($dataNode2);
		$this->get()->shouldReturn([$dataNode1, $dataNode2]);
		$this->get(1)->shouldReturn($dataNode1);
		$this->get(2)->shouldReturn($dataNode2);
    }
    
    function it_can_contain_multiple_named_data_nodes(DataNode $dataNode1, DataNode $dataNode2)
    {
		$this->set($dataNode1, 'child1');
		$this->get()->shouldReturn(['child1' => $dataNode1]);
		$this->set($dataNode2, 'child2');
		$this->get()->shouldReturn(['child1' => $dataNode1, 'child2' => $dataNode2]);
		$this->get('child1')->shouldReturn($dataNode1);
		$this->get('child2')->shouldReturn($dataNode2);
    }
    
    function it_can_contain_multiple_named_and_unnamed_data_nodes(DataNode $dataNode1, DataNode $dataNode2, DataNode $dataNode3)
    {
		$this->set($dataNode1, 'child1');
		$this->get()->shouldReturn(['child1' => $dataNode1]);
		$this->set($dataNode2);
		$this->get()->shouldReturn(['child1' => $dataNode1, $dataNode2]);
		$this->set($dataNode3, 'child2');
		$this->get()->shouldReturn(['child1' => $dataNode1, $dataNode2, 'child2' => $dataNode3]);
		$this->get('child1')->shouldReturn($dataNode1);
		$this->get(1)->shouldReturn($dataNode2);
		$this->get('child2')->shouldReturn($dataNode3);
    }

    /** Mixed children */
    function it_can_contain_multiple_mixed_data(DataNode $dataNode)
    {
        $this->set($dataNode);
        $this->get()->shouldReturn([$dataNode]);
        $this->set("string");
        $this->get()->shouldReturn([$dataNode, "string"]);
        $this->get(1)->shouldReturn($dataNode);
        $this->get(2)->shouldReturn("string");
    }

    function it_can_contain_multiple_named_mixed_data(DataNode $dataNode)
    {
        $this->set($dataNode, 'child1');
        $this->get()->shouldReturn(['child1' => $dataNode]);
        $this->set("string", 'child2');
        $this->get()->shouldReturn(['child1' => $dataNode, 'child2' => "string"]);
        $this->get('child1')->shouldReturn($dataNode);
        $this->get('child2')->shouldReturn("string");
    }

    function it_can_contain_multiple_named_and_unnamed_mixed_data(DataNode $dataNode)
    {
        $this->set($dataNode, 'child1');
        $this->get()->shouldReturn(['child1' => $dataNode]);
        $this->set("string");
        $this->get()->shouldReturn(['child1' => $dataNode, "string"]);
        $this->set(99, 'child2');
        $this->get()->shouldReturn(['child1' => $dataNode, "string", 'child2' => 99]);
        $this->get('child1')->shouldReturn($dataNode);
        $this->get(1)->shouldReturn("string");
        $this->get('child2')->shouldReturn(99);
    }

    /** To/From array */
    function it_can_be_populated_from_an_array_of_primitives()
    {
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        $this->fromArray($arrayData);
        $this->get()->shouldReturn($arrayData);

    }

    function it_can_return_an_array_when_populated_with_primitives()
    {
        $arrayData = ["key1" => "value1", "key2" => "value2", "key3" => ["child1","child2" => ["key4" => "grandChild1"],"child3"]];
        array_walk($arrayData, [$this, 'set']);
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

    /** Array Access */
    function it_can_be_read_from_as_an_array(DataNode $dataNode1, DataNode $dataNode2, DataNode $dataNode3)
    {
        $arrayData = ["key1" => "value1", "key2" => $dataNode1, "key3" => ["child1","child2" => ["key4" => $dataNode2],"child3"], $dataNode3];
        $this->fromArray($arrayData);
        $this["key1"]->shouldReturn("value1");
        $this["key2"]->shouldReturn($dataNode1);
        $this["key3"]->shouldReturn(["child1","child2" => ["key4" => $dataNode2],"child3"]);
        $this[0]->shouldReturn($dataNode3);
    }

    function it_can_be_read_from_as_a_multidimensional_array(DataNode $dataNode1, DataNode $dataNode2, DataNode $dataNode3)
    {
        $arrayData = ["key1" => "value1", "key2" => $dataNode1, "key3" => ["child1","child2" => ["key4" => $dataNode2],"child3"], $dataNode3];
        $this->fromArray($arrayData);
        $this["key3"]["child2"]["key4"]->shouldReturn($dataNode2);
    }

    function it_can_be_read_from_as_a_multidimensional_array_of_data_nodes(DataNode $dataNode1)
    {
        // $dataNode1Data = ["dataNode1Key1" => "dataNode1Value1", "dataNode1Value2"];
        $dataNode1->offsetGet("dataNode1Key1")->willReturn("dataNode1Value1");
        $dataNode1->offsetGet(0)->willReturn("dataNode1Value2");
        $inputArrayData = ["key1" => "value1", "key2" => $dataNode1];
        $this->fromArray($inputArrayData);
        $this["key2"]->shouldReturn($dataNode1);
        $this["key2"]["dataNode1Key1"]->shouldReturn("dataNode1Value1");
        $this["key2"][0]->shouldReturn("dataNode1Value2");
    }
}
