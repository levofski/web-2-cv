<?php

namespace Web2CV\Repositories;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Web2CV\Entities\DataDocument;
use Web2CV\Codecs\Codec;

class DataDocumentFileSystemRepository implements DataDocumentRepository
{
    /**
     * @var string
     */
    protected $storageDirectory;

    /**
     * @var Codec
     */
    protected $codec;


    const FILE_EXTENSION = 'json';

    /**
     * Constructor, requires a storageDirectory path, and a Codec
     * @param Codec $codec
     * @param string $storageDirectory
     */
    public function __construct(Codec $codec, $storageDirectory)
    {
        if (!is_dir($storageDirectory))
        {
            throw new FileException("Directory {$storageDirectory} not found");
        }
        if (!is_writable($storageDirectory))
        {
            throw new FileException("Directory {$storageDirectory} is not writable");
        }
        $this->storageDirectory = $storageDirectory;
        $this->codec = $codec;
    }

    /**
     * Encode the data for storage
     *
     * @param DataDocument $dataDocument
     * @return string
     */
    protected function encodeData(DataDocument $dataDocument)
    {
        return $this->codec->fromData($dataDocument);
    }

    /**
     * Decode the data from storage
     *
     * @param string $data
     * @return DataNode
     */
    protected function decodeData($data)
    {
        return $this->codec->toDataNode($data);
    }

    /**
     * {@inheritdoc}
     */
    public function store(DataDocument $dataDocument)
    {
        $filePath = $this->getFilePath($dataDocument);
        $fileData = $this->encodeData($dataDocument);
        file_put_contents($filePath, $fileData);
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($name)
    {
        $filePath = $this->getFilePath($name);
        $fileData = file_get_contents($filePath);
        $dataNode = $this->decodeData($fileData);
        return $dataDocument = DataDocument::create($name, $dataNode);
    }

    /**
     * @param DataDocument|string $document
     * @return string
     */
    protected function getFilePath($document)
    {
        if ($document instanceof DataDocument)
        {
            $document = $document->getName();
        }
        $filePath = $this->storageDirectory . DIRECTORY_SEPARATOR . $document . '.' . static::FILE_EXTENSION;
        return $filePath;
    }
}
