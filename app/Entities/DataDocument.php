<?php

namespace Web2CV\Entities;

class DataDocument implements Data
{
    /**
     * The name is immutable
     *
     * @var string $name
     */
    protected $name;

	/**
	 * @var DataNode $dataNode
	 */
	protected $dataNode;

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        // @todo validate the name
        $this->name = $name;
        $this->dataNode = new DataNode();
    }

    /**
     * Named constructor
     *
     * @param $name
     * @param $data
     * @return static
     */
    public static function create($name, $data=null)
    {
        $dataDocument = new static($name);
        if ($data instanceof DataNode)
        {
            $data = $data->toArray();
        }
        if (is_array($data))
        {
            $dataDocument->fromArray($data);
        }
        return $dataDocument;
    }

    /**
     * Get the document name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Populate with the data from the array
     *
     * @param array $arrayData
     */
    public function fromArray(array $arrayData)
    {
        $this->dataNode->fromArray($arrayData);
    }

    /**
     * Return the data in array form
     *
     * @return array
     */
    public function toArray()
    {
        return $this->dataNode->toArray();
    }

    /**
     * Access the data using a path
     * If a value is sent, the data will be updated
     *
     * @param $path
     * @param $value
     * @return mixed
     */
    public function path($path, $value = null)
    {
        return $this->dataNode->path($path, $value);
    }

    /**
     * Unset data using a path
     *
     * @param $path
     */
    public function unsetPath($path)
    {
        $this->dataNode->unsetPath($path);
    }
}
