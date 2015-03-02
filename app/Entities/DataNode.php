<?php

namespace Web2CV\Entities;

class DataNode
{
    const PATH_SEPARATOR = '/';

	/**
	 * @var array $nodeData
	 */
	protected $nodeData = array();

    /**
     * @param array $arrayData
     */
    public function __construct($arrayData = null)
    {
        if (!is_null($arrayData))
        {
            $this->fromArray($arrayData);
        }
    }

    /**
     * Get a value
     *
     * @param string $offset
     * @return mixed
     */
    public function get($offset = null)
    {
		switch (true)
		{
			case (is_null($offset)) :
				$nodeData = $this->nodeData;
				break;
			case (is_int($offset)) :
				$nodeData = $this->nodeData[$offset];
				break;
			case (is_string($offset)) :
				$nodeData = $this->nodeData[$offset];
				break;
			default :
				throw new UnexpectedValueException('Unexpected offset type sent to get()');
				break;
		}
        return $nodeData;
    }

    /**
     * Get a value via object notation
     *
     * @param string $offset
     * @return mixed
     */
    public function __get($offset)
    {
        return $this->get($offset);
    }

    /**
     * Set a value
     *
     * @param $value
     * @param string $offset
     */
    public function set($value, $offset = null)
    {
        if ( is_array($value) ) {
            $value = new static($value);
        }
        if (is_null($offset))
        {
            $this->nodeData[] = $value;
        }
        else
        {
            $this->nodeData[$offset] = $value;
        }
    }

    /**
     * Set a value via object notation
     *
     * @param string $offset
     * @param mixed $value
     */
    public function __set($offset, $value)
    {
        return $this->set($value, $offset);
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
        array_walk_recursive($nodeData, function(&$val, $key){
            if ($val instanceof static)
            {
                $val = $val->toArray();
            }
        });
        return $nodeData;
    }

    /**
     * Access the data using a path
     *
     * @param $path
     * @return mixed
     */
    public function path($path)
    {
        // Trim away any leading slash
        $path = ltrim($path, self::PATH_SEPARATOR);
        $pathParts = explode(self::PATH_SEPARATOR, $path);
        $offset = array_shift($pathParts);
        $result = $this->get($offset);
        if (count($pathParts) > 0)
        {
            // Recurse
            $newPath = implode(self::PATH_SEPARATOR, $pathParts);
            $result = $result->path($newPath);
        }
        return $result;
    }
}
