<?php

namespace Web2CV\Repositories;

use Web2CV\Entities\DataDocument;

interface DataDocumentRepository
{
    /**
     * Adds the passed DataDocument to the repository
     *
     * @param DataDocument $dataDocument
     */
    public function store(DataDocument $dataDocument);

    /**
     * Fetches a DataDocument with the passed name
     *
     * @param string $name
     * @return mixed
     */
    public function fetch($name);
}
