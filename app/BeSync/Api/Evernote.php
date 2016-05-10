<?php namespace BibleExchange\BeSync\Api;

use Evernote\AdvancedClient;
use Evernote\Auth\OauthHandler as OAuth;
use Config;

class Evernote {

	public static function get_adv_client()
	{
		$token = 'S=s1:U=909b8:E=154ece69410:C=14d953564f0:P=1cd:A=en-devtoken:V=2:H=8fd1d616a226fdfc94315a23f03729f4';
		//notestore url: https://sandbox.evernote.com/shard/s1/notestore
		$sandbox = true;

		$advancedClient = new \Evernote\AdvancedClient($token, $sandbox);
		
		return $advancedClient;
		
	}
	
	public static function get_simple_client()
	{
		$token = 'S=s1:U=909b8:E=154ece69410:C=14d953564f0:P=1cd:A=en-devtoken:V=2:H=8fd1d616a226fdfc94315a23f03729f4';

		$sandbox = true;

		$client = new \Evernote\Client($token, $sandbox);
		
		return $client;
		
	}
	
	public static function create_note($title, $body, $tags)
	{
		
		$note = new \Evernote\Model\Note();
		$note->title  = $title;
		$note->content = new \Evernote\Model\PlainTextNoteContent($body);
		$note->tagNames = $tags;

		return $note;

	}
	
	public static function get_auth()
	{
		$sandbox = true;
		$consumer_key       = Config::get('evernote.oauth_consumer_key');
		$consumer_secret    = Config::get('evernote.oauth_consumer_secret');
		$callback_url       = Config::get('evernote.callback_url');//'http://host/pathto/evernote-cloud-sdk-php/sample/oauth/index.php';
		$request_token_url  = Config::get('evernote.evernote_server');
		$request_token_url .= Config::get('evernote.request_token_path');

		/*
		To include existing linked or business notebooks as options from which the user can choose their destination notebook, include 
		
			supportLinkedSandbox=true 
			suggestedNotebookName=BibleExchange
			
			in the OAuth URL during the authentication process:

		https://www.evernote.com/OAuth.action?oauth_token=[...]&preferRegistration=true&supportLinkedSandbox=true
		*/
		
			//http://www.bible.exchange/user/settings/evernote-auth
		$auth = new \Evernote\Auth\OauthHandler($sandbox);
		
			try {
				$oauth_data  = $oauth_handler->authorize($consumer_key, $consumer_secret, $callback_url);
				echo "\nOauth Token : " . $oauth_data['oauth_token'];
				// Now you can use this token to call the api
				$client = new \Evernote\Client($oauth_data['oauth_token']);
			} catch (Evernote\Exception\AuthorizationDeniedException $e) {
				//If the user decline the authorization, an exception is thrown.
				echo "Declined";
			}
			
			
	}
	
}