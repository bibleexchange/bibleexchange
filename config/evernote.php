<?php

return array(	
	'oauth_consumer_key'=>env('EVERNOTE_CONSUMER_KEY'),
	'oauth_consumer_secret'=>env('EVERNOTE_CONSUMER_SECRET'),	//Your Consumer Secret should be kept private and not shared.
	'callback_url'=>'localhost/user/settings/evernote-auth',
	'evernote_server'=>'',
	'request_token_path'=>''
);