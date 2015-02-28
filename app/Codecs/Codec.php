<?php

namespace Web2CV\Codecs;

use Web2CV\Entities\DataNode;

interface Codec
{
    /**
     * Converts the passed data to a DataNode, and returns it
     *
     * @param $data
     * @return DataNode
     */
    public static function toDataNode($data);

    /**
     * Converts the passed DataNode to the correct format, and returns the result
     *
     * @param DataNode $dataNode
     * @return mixed
     */
    public static function fromDataNode(DataNode $dataNode);
}
