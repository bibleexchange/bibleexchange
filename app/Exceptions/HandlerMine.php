<?php namespace BibleExperience\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
		{
			if ( $request->segment(1) == "data" || $request->segment(1) == "api" ) {
			$error = array(
			  'error'     =>  true,
			  'message'   =>  $exception->getMessage(),
			  'code'      =>  $exception->getStatusCode()
			);

			return \Response::json( $error, $e->getStatusCode());
		  } else {
			return parent::render($request, $e);
			/*return \Response::view( 'errors.missing', array( 
				'message'=>$e->getMessage(),
				'title'=> "Status: ".$e->getStatusCode()." Error: ".$e->getMessage(),
				'exception'=> $this->renderHttpException($e)
				
				), 404);*/
			
		  }
		
		} 
		else if ($this->isHttpException($e))
		{
			$code = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

			  if ($request->segment(1) == "data" || $request->segment(1) == "api") {
				  
						return \Response::json([
						  'error' => true,
						  'success' => false,
						  'message' => method_exists($e, 'getErrors') ? $e->getErrors() : $e->getMessage(),
						  'code' => $code,
						  'trace' => Config::get('app.debug') ? $e->getTraceAsString() : trans('api.info.trace')
						], $code);
			  } else {
				
				echo "<center>Status: ".$code." Error: ".$e->getMessage() . "</center>";
				return $this->renderHttpException($e);
			  }
		}
		else if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException){
			
			return new JsonResponse(['error'=>['message'=>'Resource not found']],404);
		}else{
			return parent::render($request, $e);
		}
		

  }
}