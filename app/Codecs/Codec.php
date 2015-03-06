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
    public function decode($data);

    /**
     * Converts the passed data to the correct format, and returns the result
     *
     * @param mixed $data
     * @return mixed
     */
    public function encode($data);
}
