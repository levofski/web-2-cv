<?php

namespace Web2CV\Codecs;

use Web2CV\Entities\DataNode;

class JSONCodec implements Codec
{
    /**
     * {@inheritdoc }
     */
    public static function toDataNode($data)
    {
        $arrayData = json_decode($data, true);
        $dataNode = new DataNode();
        $dataNode->fromArray($arrayData);
        return $dataNode;
    }

    /**
     * {@inheritdoc }
     */
    public static function fromDataNode(DataNode $dataNode)
    {
        $arrayData = $dataNode->toArray();
        return json_encode($arrayData);
    }
}
