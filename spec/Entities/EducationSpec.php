<?php

namespace spec\Web2CV\Entities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EducationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Web2CV\Entities\Education');
    }
}
