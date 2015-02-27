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
    
    function it_can_contain_a_data_node(DataNode $dataNode)
    {
		$this->set($dataNode);
		$this->get()->shouldReturn([$dataNode]);
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
}
