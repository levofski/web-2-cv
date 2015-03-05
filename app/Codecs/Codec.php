<?php

namespace Web2CV\Codecs;

use Web2CV\Entities\Data;
use Web2CV\Entities\DataNode;

interface Codec
{
    /**
     * Converts the passed data to a DataNode, and returns it
     *
     * @param $data
     * @return DataNode
     */
    public function toDataNode($data);

    /**
     * Converts the passed Data to the correct format, and returns the result
     *
     * @param Data $data
     * @return mixed
     */
    public function fromData(Data $data);
}
