<?php

namespace Web2CV\Entities;

class DataDocument
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
     * Get the document data
     *
     * @return DataNode
     */
    public function getDataNode()
    {
        return $this->dataNode;
    }


}
