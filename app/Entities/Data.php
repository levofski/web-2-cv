<?php

namespace Web2CV\Entities;

interface Data
{
    /**
     * Populate with the data from the array
     *
     * @param array $arrayData
     */
    public function fromArray(array $arrayData);

    /**
     * Return the data in array form
     *
     * @return array
     */
    public function toArray();

    /**
     * Access the data using a path
     * If a value is sent, the data will be updated
     *
     * @param $path
     * @param $value
     * @return mixed
     */
    public function path($path, $value = null);
}
