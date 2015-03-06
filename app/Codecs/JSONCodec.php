<?php

namespace Web2CV\Codecs;

use Web2CV\Entities\Data;
use Web2CV\Entities\DataNode;

class JSONCodec implements Codec
{
    /**
     * {@inheritdoc }
     */
    public function decode($data)
    {
        $arrayData = json_decode($data, true);
        $dataNode = new DataNode();
        $dataNode->fromArray($arrayData);
        return $dataNode;
    }

    /**
     * {@inheritdoc }
     */
    public function encode($data)
    {
        if ($data instanceof Data)
        {
            $data = $data->toArray();
        }
        if (is_array($data))
        {
            array_walk_recursive($data, function(&$val, $key){
                if ($val instanceof Data)
                {
                    $val = $val->toArray();
                }
            });
            $data = json_encode($data);
        }
        return $data;
    }
}
