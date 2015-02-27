<?php

namespace Web2CV\Entities;

class DataNode
{
	/**
	 * @var array $nodeData
	 */
	protected $nodeData = array();

    public function add($value, $key = null)
    {
		if (is_null($key))
		{
			$this->nodeData[] = $value;
		}
		else 
		{
			$this->nodeData[$key] = $value;
        }
    }

    public function get($key = null)
    {
		$nodeData = false;
		switch (true)
		{
			case (is_null($key)) :
				$nodeData = $this->nodeData;
				break;
			case (is_int($key)) :
				$nodeData = $this->nodeData[$key-1];
				break;
			case (is_string($key)) :
				$nodeData = $this->nodeData[$key];
				break;
			default :
				throw new UnexpectedValueException('Unexpected key sent to get()');
				break;
		}
        return $nodeData;
    }
}
