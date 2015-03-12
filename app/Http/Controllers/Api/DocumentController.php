<?php namespace Web2CV\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Web2CV\Entities\DataNode;
use Web2CV\Http\Requests;
use Web2CV\Http\Controllers\Controller;
use Web2CV\Entities\DataDocument;
use Web2CV\Repositories\DataDocumentRepository;

class DocumentController extends Controller {

    /**
     * @var DataDocumentRepository
     */
    protected $documentRepository;
    /**
     * Construct with dependencies
     */
    public function __construct(DataDocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

	/**
	 * Store a newly created Document.
	 *
     * @param  string $documentName
	 * @return Response
	 */
	public function store($documentName)
	{
        $documentData = Request::json()->all();
        $document = DataDocument::create($documentName, $documentData);
        $this->documentRepository->store($document);
        return new JsonResponse(array("message" => "Created : {$documentName}"));
	}

	/**
	 * Display the specified Document.
	 *
     * @param  string $documentName
     * @param  string $path
     * @return Response
	 */
	public function show($documentName, $path=null)
	{
        $document = $this->documentRepository->fetch($documentName);
        if (!$document instanceof DataDocument)
        {
            return new JsonResponse(array("message" => "Document '{$documentName}' not found"), 404);
        }
        if ($path)
        {
            $arrayData = $document->path($path);
            if ($arrayData instanceof DataNode)
            {
                $arrayData = $arrayData->toArray();
            }
        }
        else
        {
            $arrayData = $document->toArray();
        }
        return new JsonResponse($arrayData);
	}

	/**
	 * Update the specified path on the specified Document.
	 *
	 * @param  string $documentName
     * @param  string $path
	 * @return Response
	 */
	public function update($documentName, $path)
	{
        $requestContent = Request::getContent();
        $requestJson = Request::json();
        $decodedRequestContent = json_decode($requestContent);
        // We want to accept a valid JSON strings, not just valid JSON objects
        // If the $requestJson is not the same as the decoded $requestContent
        $requestData = $requestJson;
        if ($decodedRequestContent != $requestJson)
        {
            $requestData = $decodedRequestContent;
        }
        $document = $this->documentRepository->fetch($documentName);
        if (!$document instanceof DataDocument)
        {
            return new JsonResponse(array("message" => "Document '{$documentName}' not found"), 404);
        }
        $document->path($path, $requestData);
        $this->documentRepository->store($document);
        return new JsonResponse(array("message" => "Updated : {$documentName} : {$path}"));
	}

	/**
	 * Remove the specified Document.
	 *
	 * @param  string $documentName
	 * @return Response
	 */
	public function destroy($documentName)
	{
        $this->documentRepository->delete($documentName);
        return new JsonResponse(array("message" => "Destroyed : {$documentName}"));
	}

}
