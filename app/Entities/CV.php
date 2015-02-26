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

	public function addWorkExperience(WorkExperience $workExperience)
	{
		$this->workExperiences[] = $workExperience;
	}

	public function countWorkExperience()
	{
		return count($this->workExperiences);
	}
}
