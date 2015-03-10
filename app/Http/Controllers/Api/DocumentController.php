<?php namespace Web2CV\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Web2CV\Codecs\JSONCodec;
use Web2CV\Http\Requests;
use Web2CV\Http\Controllers\Controller;
use Web2CV\Entities\DataDocument;
use Web2CV\Repositories\DataDocumentFileSystemRepository;

class DocumentController extends Controller {

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
        $jsonCodec = new JSONCodec();
        $documentRepository = new DataDocumentFileSystemRepository($jsonCodec, storage_path());
        $documentRepository->store($document);
        return new JsonResponse(array("message" => "Created : {$documentName}"));
	}

	/**
	 * Display the specified Document.
	 *
	 * @param  string $documentName
	 * @return Response
	 */
	public function show($documentName)
	{
        $jsonCodec = new JSONCodec();
        $documentRepository = new DataDocumentFileSystemRepository($jsonCodec, storage_path());
        $document = $documentRepository->fetch($documentName);
        return new JsonResponse($document->toArray());
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
        $documentData = Request::json()->all();
        $jsonCodec = new JSONCodec();
        $documentRepository = new DataDocumentFileSystemRepository($jsonCodec, storage_path());
        $document = $documentRepository->fetch($documentName);
        $document->path($path, $documentData);
        $documentRepository->store($document);
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
        $jsonCodec = new JSONCodec();
        $documentRepository = new DataDocumentFileSystemRepository($jsonCodec, storage_path());
        $documentRepository->delete($documentName);
        return new JsonResponse(array("message" => "Destroyed : {$documentName}"));
	}

}
