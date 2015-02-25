<?php

namespace spec\Web2CV;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CandidateDetailsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Web2CV\CandidateDetails');
    }
}
