<?php namespace BibleExperience;

use BibleExperience\OauthClient;

class Client extends BaseModel {

  protected $fillable = ['authority_id', 'authority_raw','description',  'api_raw','api_basic_key',  'api_basic_secret', 'lrs_id', 'scopes_raw'];
  
  protected $appends = array('lrs','scopes','authority','api');
  
  /**
   * Delete the model from the database.
   *
   * @return bool|null
   * @throws \Exception
   */
  public function delete() {
    OauthClient::remove([
      'client_id' => $this->api['basic_key']
    ]);
    
    parent::delete();
  }
  
  public static function findByKeySecret($key, $secret) {
	return Self::where('api_basic_key',$key)->where('api_basic_secret',$secret)->first();
  }
  
  public function getAuthorityAttribute() {
    //return $this->belongsTo('BibleExperience\Authority');
	
	if($this->authority_raw !== ''){
		$obj = JSON_DECODE($this->authority_raw);
	}else{
		$obj = new \stdClass;
		$obj->name = '';
		$obj->mbox = '';
		$obj->mbox_sha1sum = '';
		$obj->openid = '';
		$obj->account = new \stdClass;
		$obj->account->homePage = ''; 
		$obj->account->name = '';
	}
	return $obj;
  }
  
    public function getApiAttribute() {
    //return $this->belongsTo('BibleExperience\Authority');
	
	if($this->api_raw !== ''){
		$obj = JSON_DECODE($this->authority_raw);
	}else{
		//'client_secret','redirect_uri','grant_types','scope','user_id'
		$obj = new \stdClass;
		$obj->basic_key = '';
		$obj->basic_secret = '';
	}
	return $obj;
  }
  
  /**
   * All clients belong to an LRS
   *
   **/
  public function lrs() {
    return $this->belongsTo('BibleExperience\Lrs');
  }

    public function getScopesAttribute(){
    	return explode(' ', $this->scopes_raw);
    }
	
  /**
   * Add a basic where clause to the client query.
   * Normally, Illuminate\Database\Eloquent\Model handles this method (through __call()).
   * This implementation converts foreign ids from strings to MongoIds.
   *
   * @param  string  $column
   * @param  string  $operator
   * @param  mixed   $value
   * @param  string  $boolean
   * @return Jenssegers\Mongodb\Eloquent\Builder
   */
  public static function where($column, $operator = null, $value = null, $boolean = 'and') {
    if (func_num_args() == 2) {
      list($value, $operator) = array($operator, '=');
    }
    if ($column == 'lrs_id') {
        $value = $value;
    }
    $instance = new static;
    $query = $instance->newQuery();
    return $query->where($column, $operator, $value, $boolean);
  }

}