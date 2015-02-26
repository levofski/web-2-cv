<?php

namespace Web2CV\Entities;

class CV
{

	/**
	 * @var CandidateDetails
	 */
	protected $candidateDetails;
	
	/**
	* @var array
	*/
	protected $workExperiences = array();

    /**
     * @var array
     */
    protected $educations = array();

	/**
	 * @param CandidateDetails
	 */
	public function setCandidateDetails(CandidateDetails $candidateDetails)
	{
		$this->candidateDetails = $candidateDetails;
	}

	/**
	 * @return CandidateDetails
	 */
	public function getCandidateDetails()
	{
		return $this->candidateDetails;
	}

	public function addWorkExperience($workExperience)
	{
        if (is_array($workExperience))
        {
            return array_map([$this,'addWorkExperience'], $workExperience);
        }
		$this->workExperiences[] = $workExperience;
	}

	public function countWorkExperiences()
	{
		return count($this->workExperiences);
	}

    public function addEducation($education)
    {
        if (is_array($education))
        {
            return array_map([$this,'addEducation'], $education);
        }
        $this->educations[] = $education;
    }

    public function countEducations()
    {
        return count($this->educations);
    }

    public function addHobby($hobby)
    {
        if (is_array($hobby))
        {
            return array_map([$this,'addHobby'], $hobby);
        }
        $this->hobbies[] = $hobby;
    }

    public function countHobbies()
    {
        return count($this->hobbies);
    }
}
