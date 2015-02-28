<?php

namespace Web2CV\Entities;

class DataNode
{
	/**
	 * @var array $nodeData
	 */
	protected $nodeData = array();

    /**
     * Set a value
     *
     * @param $value
     * @param string $key
     */
    public function set($value, $key = null)
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

    /**
     * Get a value
     *
     * @param string $key
     * @return mixed
     */
    public function get($key = null)
    {
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

    /**
     * Populate with the data from the array
     *
     * @param array $arrayData
     */
    public function fromArray(array $arrayData)
    {
        array_walk($arrayData, [$this, "set"]);
    }

    /**
     * Return the data in array form
     *
     * @return array
     */
    public function toArray()
    {
        $nodeData = $this->nodeData;
        array_walk($nodeData, function(&$val, $key){
            if ($val instanceof static)
            {
                $val = $val->toArray();
            }
        });
        return $nodeData;
    }
}
