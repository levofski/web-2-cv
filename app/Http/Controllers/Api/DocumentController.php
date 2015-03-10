<?php namespace Web2CV\Http\Controllers\Api;

use Web2CV\Http\Requests;
use Web2CV\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DocumentController extends Controller {

	/**
	 * Store a newly created Document.
	 *
     * @param  string $documentName
	 * @return Response
	 */
	public function store($documentName)
	{
        return "Creating : {$documentName}";
	}

	/**
	 * Display the specified Document.
	 *
	 * @param  string $documentName
	 * @return Response
	 */
	public function show($documentName)
	{
        return "Showing : {$documentName}";
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
		return "Updating : {$documentName} : {$path}";
	}

	/**
	 * Remove the specified Document.
	 *
	 * @param  string $documentName
	 * @return Response
	 */
	public function destroy($documentName)
	{
        return "Destroying : {$documentName}";
	}

}
