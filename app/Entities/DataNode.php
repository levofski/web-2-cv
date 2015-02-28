<?php

namespace Web2CV\Entities;

class DataNode implements \ArrayAccess
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

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->nodeData[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->nodeData[$offset];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->nodeData[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->nodeData[$offset]);
    }
}
