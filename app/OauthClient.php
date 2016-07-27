<?php namespace BibleExperience;

class OAuthClient extends BaseModel {

  protected $table = 'oauth_clients';

  protected $fillable = ['client_id','client_secret','redirect_uri','grant_types','scope','user_id'];
}