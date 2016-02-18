<?php namespace BibleExchange\Http\Controllers\Api;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiController extends Controller {
	
	/*
	 * 
	 * @var int
	 * 
	 * */
	protected $statusCode = 200;
	
	public function getStatusCode()
	{
		return $this->statusCode;
	}
	
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		
		return $this;
	}
	
	public function respond($data, $headers = []){
		
		return new JsonResponse($data, $this->getStatusCode(), $headers);
	}
	
	public function respondWithError($message){
		
		return $this->respond([
					
				'error' => [
		
						'message'=> $message,
						'status_code' => $this->getStatusCode()
				]
			]);
	}
	
	public function respondWithPagination(LengthAwarePaginator $items,$data)
	{
		$data = array_merge($data, [
				
				'total'=>$items->total(),
				'total_pages'=>ceil($items->total() / $items->perPage()),
				'current_page'=>$items->currentPage(),
				'limit'=>$items->perPage()
				]);
	
		return $this->respond($data);
	}
	
	public function respondNotFound($message = 'Not Found'){
	
		return $this->setStatusCode(404)->respondWithError($message);
	
	}
	
	public function respondInternalError($message = 'Something went wrong on our end!'){
	
		return $this->setStatusCode(500)->respondWithError($message);
	
	}
}