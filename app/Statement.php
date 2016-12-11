<?php namespace BibleExperience;

use \BibleExperience\Helpers\Helpers;

class Statement extends BaseModel {

  protected $hidden = ['id', 'created_at', 'updated_at'];
  protected $fillable = ['statement', 'active', 'voided', 'refs', 'lrs_id', 'timestamp', 'stored'];
  protected $appends = ['actor','avatar','name'];
	
  public function lrs(){
    return $this->belongsTo('\BibleExperience\Lrs');
  }
  
  public function getActorAttribute(){
    return $this->statement;
  }
  
  public function statementToJson(){
	  return JSON_DECODE($this->statement);
  }
  
  public function getAvatarAttribute(){
	$statement = $this->statementToJson();
	if( isset($statement->actor->mbox) ){
      $avatar_id = substr($statement->actor->mbox, 7);
    } else {
      $avatar_id = 'hello@bible.exchange';
    }

    return Helpers::getGravatar( $avatar_id, '20');
	  
  }
  
	public function getNameAttribute(){
	  
	  $statement = $this->statementToJson();
	  
	  if( isset($statement->actor->name) && $statement->actor->name != ''){
		$name = $statement->actor->name;
	  }elseif(isset($statement->actor->mbox) && $statement->actor->mbox != '' ){
		$name = $statement->actor->mbox;
	  }elseif(isset($statement->actor->openid) && $statement->actor->openid != '' ){
		$name = $statement->actor->openid;
	  }elseif( isset($statement->actor->account->name) && $statement->actor->account->name != '' ){
		$name = $statement->actor->account->name;
	  }else{
		$name = 'no name available';
	  }

	return $name;
	  
  }
  
   public function displayVerb($lang){
	   
	   $statement = $this->statementToJson();
	   
	  if( isset($statement->verb->display) ){
		$verb = $statement->verb->display;

		if (isset($verb->$lang)) {
		  $verb = $verb->$lang;
		} else {
		  $verb = reset( $verb );
		}
	  }else{
		$verb = $statement->verb->id;
	  }

	  //if using verb id for display, or display is an iri, truncate for display
	  if(filter_var($verb, FILTER_VALIDATE_URL)){
		$verb = substr( $verb, strrpos( $verb, '/' )+1 );
	  }
	  
	  return $verb;
  
   }
  
   public function displayObjectId(){
	  $statement = $this->statementToJson();
	  $object_id = isset($statement->object->id) ? $statement->object->id : '#';
	  return $object_id;
   }
    
  public function displayObject($lang){
	  $statement = $this->statementToJson();
		//is the object of type agent?
	  if( isset($statement->object->objectType) && ($statement->object->objectType == 'Agent' || $statement->object->objectType == 'Group') ){
		if( isset($statement->object->name) ){
		  $object = $statement->object->name;
		}else{
		  $object = isset($statement->object->mbox) ? $statement->object->mbox : $statement->object->objectType;
		}
	  }elseif( isset($statement->object->objectType) && $statement->object->objectType == 'SubStatement' ){
		$object = 'A SubStatement'; //@todo not sure how to handle substatement display?
	  }else{
		//assume it is a statement ref or activity
		if( isset( $statement->object->definition->name )){
		  //does an acitivyt name exists?
		  $object = $statement->object->definition->name;
		  $lang = "en-US";
		  $object = $object->$lang;
		}elseif( isset( $statement->object->definition->description )){
		  //if not does a description exist?
		  $object = $statement->object->definition->description;
		  if (!is_array($object)) {
			$object = [$object];
		  }
		  $object = reset( $object );
		} elseif (isset($statement->object->id)) {
		  //last resort, or in the case of statement ref, use the id
		  $object = $statement->object->id;
		} else {
		  $object = "Unnamed Object";
		}
	  }
	  return $object;
	  
	}
  
}
