<?php

namespace spec\Web2CV\Entities;

use Web2CV\Entities\CandidateDetails;
use Web2CV\Entities\WorkExperience;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CVSpec extends ObjectBehavior
{
	function it_is_initializable()
	{
		$this->shouldHaveType('Web2CV\Entities\CV');
	}
	
	function it_can_contain_candidate_details(CandidateDetails $candidateDetails)
	{
		$this->setCandidateDetails($candidateDetails);
		$this->getCandidateDetails()->shouldHaveType('Web2CV\Entities\CandidateDetails');
	}
	
	function it_can_contain_work_experience(WorkExperience $workExperience)
	{
		$this->addWorkExperience($workExperience);
		$this->countWorkExperience()->shouldEqual(1);
	}

    function it_can_accept_multiple_work_experiences(WorkExperience $workExperience1, WorkExperience $workExperience2)
    {
        $this->addWorkExperience($workExperience1);
        $this->addWorkExperience($workExperience2);
        $this->countWorkExperience()->shouldEqual(2);
    }

    function it_can_accept_multiple_work_experiences_at_once(WorkExperience $workExperience1, WorkExperience $workExperience2)
    {
        $this->addWorkExperience([$workExperience1, $workExperience2]);
        $this->countWorkExperience()->shouldEqual(2);
    }
}
