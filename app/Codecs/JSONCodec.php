<?php

namespace Web2CV\Codecs;

use Web2CV\Entities\Data;
use Web2CV\Entities\DataNode;

class JSONCodec implements Codec
{
    /**
     * {@inheritdoc }
     */
    public function toDataNode($data)
    {
        $arrayData = json_decode($data, true);
        $dataNode = new DataNode();
        $dataNode->fromArray($arrayData);
        return $dataNode;
    }

    /**
     * {@inheritdoc }
     */
    public function fromData(Data $data)
    {
        $arrayData = $data->toArray();
        return json_encode($arrayData);
    }
}
