<?php namespace BibleExperience\Repository\Lrs;

use \Illuminate\Database\Eloquent\Model as Model;
use \BibleExperience\Repository\Base\EloquentRepository as BaseRepository;
use \Locker\XApi\Helpers as XAPIHelpers;
use \BibleExperience\Helpers\Helpers as Helpers;
use \Event as Event;
use \Client as ClientModel;
use \BibleExperience\Statement as StatementModel;
use Cache;
use \BibleExperience\User;

class EloquentRepository extends BaseRepository implements Repository {
  protected $model = '\BibleExperience\Lrs';
  protected $defaults = [
    'title' => 'New LRS',
    'description' => ''
  ];

  /**
   * Constructs a query restricted by the given options.
   * @param [String => Mixed] $opts
   * @return \Jenssegers\Mongodb\Eloquent\Builder
   */
  protected function where(array $opts) {
    return (new $this->model);
  }

  /**
   * Validates data.
   * @param [String => Mixed] $data Properties to be changed on the model.
   * @throws \Exception
   */
  protected function validateData(array $data) {
    if (isset($data['title'])) XAPIHelpers::checkType('title', 'string', $data['title']);
    if (isset($data['description'])) XAPIHelpers::checkType('description', 'string', $data['description']);
    if (isset($data['owner_id'])) XAPIHelpers::checkType('owner_id', 'MongoId', $data['owner_id']);

    // Validate users.
    if (isset($data['users'])) {
      XAPIHelpers::checkType('users', 'array', $data['users']);
      foreach ($data['users'] as $key => $field) {
        XAPIHelpers::checkType("fields.$key", 'array', $field);
				
        if (isset($field['_id'])) XAPIHelpers::checkType("fields.$key._id", 'MongoId', $field['_id']);
        if (isset($field['email'])) XAPIHelpers::checkType("fields.$key.email", 'string', $field['email']);
        if (isset($field['name'])) XAPIHelpers::checkType("fields.$key.name", 'string', $field['name']);
        if (isset($field['role'])) XAPIHelpers::checkType("fields.$key.role", 'string', $field['role']);
      }
    }
  }

  /**
   * Constructs a store.
   * @param Model $model Model to be stored.
   * @param [String => Mixed] $data Properties to be used on the model.
   * @param [String => Mixed] $opts
   * @return Model
   */
  protected function constructStore(Model $model, array $data, array $opts) {
    // Merges and validates data with defaults.
    $data = array_merge($this->defaults, $data, [
      'owner_id' => $opts['user']->id,
      'users' => [[
        'id'   => $opts['user']->id,
        'email' => $opts['user']->email,
        'name'  => $opts['user']->name,
        'role'  => 'admin'
      ]]
    ]);
    $this->validateData($data);

    // Sets properties on model.
    $model->title = $data['title'];
    $model->description = $data['description'];
    $model->owner_id = $data['owner_id'];
    //$model->users = $data['users'];

    return $model;
  }

  /**
   * Constructs a update.
   * @param Model $model Model to be updated.
   * @param [String => Mixed] $data Properties to be changed on the model.
   * @param [String => Mixed] $opts
   * @return Model
   */
  protected function constructUpdate(Model $model, array $data, array $opts) {
    $this->validateData($data);

    // Sets properties on model.
    if (isset($data['title'])) $model->title = $data['title'];
    if (isset($data['description'])) $model->description = $data['description'];

    return $model;
  }

  /**
   * Gets all of the available models with the options.
   * @param [String => Mixed] $opts
   * @return [Model]
   */
  public function index(array $opts) {

    if ($opts['user']->hasRole("SUPER")) {
      $query = $this->where($opts);
    } else {

	  $query = $this->where([])->whereHas('members', function ($q) use($opts){
		$q->where('user_id', $opts['user']->id);
	  });

    }

    $obj_result = $query->get()->sortBy(function (Model $model) {
      return strtolower($model->title);
    })->each(function (Model $model) {
      return $this->format($model);
    });

    // Annoying hack to convert stupid Laravel collection object to an array
    // WITHOUT converting the models to associative arrays!!!
    $result = [];
    foreach ($obj_result->getIterator() as $model) {
      $result[] = $model;
    }

    return $result;
  }

  /**
   * Destroys the model with the given ID and options.
   * @param String $lrs_id ID to match.
   * @param [String => Mixed] $opts
   * @return Boolean
   */
  public function destroy($lrs_id, array $opts) {
    // Delete related documents from client and oauth_clients collections.
    $clients = ClientModel::where('lrs_id', $lrs_id)->get();
    foreach ($clients as $client) {
      $client->delete();
    }
    
    StatementModel::where('lrs_id', $lrs_id)->delete();
    return parent::destroy($lrs_id, $opts);
  }

  public function removeUser($id, $user_id) {
    return $this->where([])->where('_id', $id)->pull('users', ['id' => $user_id]);
  }

  public function getLrsOwned($user_id) {
	  
    return $this->where([])->where('owner_id', $user_id)->select('title')->get()->toArray();
  }

  public function getLrsMember($user_id) {
	
	$user = User::find($user_id);
	
    return $user->lrs()->select('title')->get()->toArray();
  }

  /**
   * Get a statement count, either for an LRS or for the entire site if no lrs_id passed
   */
  public function getStatementCount( $lrs_id = null ) {
	
	$count = false;
	
    if( $lrs_id ){
      $count = StatementModel::where('lrs_id',$lrs_id)->count();
    }else{
	  $count = StatementModel::all()->count();
	}

    return $count;
  }

  public function changeRole($id, $user_id, $role) {
    $lrs = $this->show($id, []);
    $lrs->users = array_map(function ($user) use ($user_id, $role) {
      $user['role'] = (string)$user['_id'] === $user_id ? $role : $user['role'];
      return $user;
    }, $lrs->users);
    return $lrs->save();
  }
}
