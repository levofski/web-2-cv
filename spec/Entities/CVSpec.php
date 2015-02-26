<?php

namespace spec\Web2CV\Entities;

use Web2CV\Entities\CandidateDetails;
use Web2CV\Entities\WorkExperience;
use Web2CV\Entities\Education;
use Web2CV\Entities\Hobby;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CVSpec extends ObjectBehavior
{
	function it_is_initializable()
	{
		$this->shouldHaveType('Web2CV\Entities\CV');
	}

    /** Candidate Details */
	function it_can_contain_candidate_details(CandidateDetails $candidateDetails)
	{
		$this->setCandidateDetails($candidateDetails);
		$this->getCandidateDetails()->shouldHaveType('Web2CV\Entities\CandidateDetails');
	}

    /** Work Experience */
	function it_can_contain_work_experience(WorkExperience $workExperience)
	{
		$this->addWorkExperience($workExperience);
		$this->countWorkExperiences()->shouldEqual(1);
	}

    function it_can_accept_multiple_work_experiences(WorkExperience $workExperience1, WorkExperience $workExperience2)
    {
        $this->addWorkExperience($workExperience1);
        $this->addWorkExperience($workExperience2);
        $this->countWorkExperiences()->shouldEqual(2);
    }

    function it_can_accept_multiple_work_experiences_at_once(WorkExperience $workExperience1, WorkExperience $workExperience2)
    {
        $this->addWorkExperience([$workExperience1, $workExperience2]);
        $this->countWorkExperiences()->shouldEqual(2);
    }

    /** Education */
    function it_can_contain_education(Education $education)
    {
        $this->addEducation($education);
        $this->countEducations()->shouldEqual(1);
    }

    function it_can_accept_multiple_educations(Education $education1, Education $education2)
    {
        $this->addEducation($education1);
        $this->addEducation($education2);
        $this->countEducations()->shouldEqual(2);
    }

    function it_can_accept_multiple_educations_at_once(Education $education1, Education $education2)
    {
        $this->addEducation([$education1, $education2]);
        $this->countEducations()->shouldEqual(2);
    }

    /** Hobbies */
    function it_can_contain_a_hobby(Hobby $hobby)
    {
        $this->addHobby($hobby);
        $this->countHobbies()->shouldEqual(1);
    }

    function it_can_accept_multiple_hobbies(Hobby $hobby1, Hobby $hobby2)
    {
        $this->addHobby($hobby1);
        $this->addHobby($hobby2);
        $this->countHobbies()->shouldEqual(2);
    }

    function it_can_accept_multiple_hobbies_at_once(Hobby $hobby1, Hobby $hobby2)
    {
        $this->addHobby([$hobby1, $hobby2]);
        $this->countHobbies()->shouldEqual(2);
    }
}
