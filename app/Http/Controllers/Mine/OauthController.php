<?php namespace BibleExperience\Http\Controllers\Mine;

use OAuth2\HttpFoundationBridge\Request;
use OAuth2\HttpFoundationBridge\Response;
use Request as LaravelRequest;

class OauthController extends BaseController
{

    public function initiate()
    {
        return 1;
    }

    public function authorizeIt()
    {
        $bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
		$bridgedResponse = new OAuth2\HttpFoundationBridge\Response();
		
		if (App::make('oauth2')->verifyResourceRequest($bridgedRequest, $bridgedResponse)) {
			
			$token = App::make('oauth2')->getAccessTokenData($bridgedRequest);
			
			return Response::json(array(
				'private' => 'stuff',
				'user_id' => $token['user_id'],
				'client'  => $token['client_id'],
				'expires' => $token['expires'],
			));
		}
		else {
			return Response::json(array(
				'error' => 'Unauthorized'
			), $bridgedResponse->getStatusCode());
		}
    }

    public function token()
    {
      	$bridgedRequest  = Request::createFromRequest(LaravelRequest::instance());
		$bridgedResponse = new Response();
		$bridgedResponse = \App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);
		
		return $bridgedResponse;

    }

}
