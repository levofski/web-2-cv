<?php

namespace Web2CV\Entities;

class DataDocument
{
	/**
	 * @var DataNode $dataNode
	 */
	protected $dataNode;

    public function setDataNode(DataNode $dataNode)
    {
        $this->dataNode = $dataNode;
    }

    public function getDataNode()
    {
        return $this->dataNode;
    }
}
