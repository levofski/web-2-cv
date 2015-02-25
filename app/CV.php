<?php

namespace Web2CV;

class CV
{
	
	/**
	 * @var CandidateDetails
	 */
	protected $candidateDetails;

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
}
