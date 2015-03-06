<?php

namespace Web2CV\Repositories;

use PhpParser\Error;
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
        $result = false;
        $filePath = $this->getFilePath($name);
        // Catch file stream errors
        set_error_handler([$this, 'errorHandler']);
        try {
            $fileData = file_get_contents($filePath);
        }
        catch (\ErrorException $e)
        {
            // @todo, do something with the errors
            $fileData = false;
        }
        restore_error_handler();
        if ($fileData !== false)
        {
            $dataNode = $this->decodeData($fileData);
            $dataDocument = DataDocument::create($name, $dataNode);
            $result = $dataDocument;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */

    public function delete($name)
    {
        $filePath = $this->getFilePath($name);
        return unlink($filePath);
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

    /**
     * Custom error handler to wrap errors in Exceptions
     *
     * @param $severity
     * @param $message
     * @param $file
     * @param $line
     */
    protected function errorHandler($severity, $message, $file, $line)
    {
        throw new \ErrorException($message, $severity, $severity, $file, $line);
    }
}
