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
    
    function it_can_contain_a_data_node(DataNode $dataNode)
    {
		$this->setDataNode($dataNode);
		$this->getDataNode()->shouldReturn($dataNode);
    }
    
}
