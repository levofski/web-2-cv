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
        $dataNode1->toArray()->shouldBeCalled();
        // Since $dataNode2 is effectively in a child, it should be the child calling toArray() not this Unit
        $dataNode2->toArray()->shouldNotBeCalled();
        $dataNode3->toArray()->shouldBeCalled();
        $arrayData = ["key1" => "value1", "key2" => $dataNode1, "key3" => ["child1","child2" => ["key4" => $dataNode2],"child3"], $dataNode3];
        $this->fromArray($arrayData);
        $this->toArray();
    }
}
