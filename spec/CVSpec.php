<?php

namespace spec\Web2CV;

use Web2CV\CandidateDetails;
use Web2CV\WorkExperience;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CVSpec extends ObjectBehavior
{
	function it_is_initializable()
	{
		$this->shouldHaveType('Web2CV\CV');
	}
	
	function it_can_contain_candidate_details(CandidateDetails $candidateDetails)
	{
		$this->setCandidateDetails($candidateDetails);
		$this->getCandidateDetails()->shouldHaveType('Web2CV\CandidateDetails');
	}
	
	function it_can_contain_work_experience(WorkExperience $workExperience)
	{
		$this->addWorkExperience($workExperience);
		$this->countWorkExperience()->shouldEqual(1);
	}
}
