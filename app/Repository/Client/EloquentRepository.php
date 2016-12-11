<?php namespace BibleExperience\Repository\Client;

use \Illuminate\Database\Eloquent\Model as Model;
use \BibleExperience\Repository\Base\EloquentRepository as BaseRepository;
use \Locker\XApi\Authority as XApiAuthority;
use \BibleExperience\Helpers\Helpers as Helpers;
use BibleExperience\Client;

class EloquentRepository extends BaseRepository implements Repository {

  protected $model = '\BibleExperience\Client';
  protected $defaults = [
    'authority' => [
      'name' => 'New Client',
      'mbox' => 'mailto:hello@learninglocker.net'
    ]
  ];

  protected function where(array $opts) {
    return (new $this->model)->where('lrs_id', $opts['lrs_id']);
  }

  protected function validateData(array $data) {
    if (isset($data['authority'])) Helpers::validateAtom(
      XApiAuthority::createFromJson(json_encode($data['authority'])),
      'client.authority'
    );
  }

  /**
   * Generates a random value.
   * Used for generating usernames and passwords.
   * @return String Randomly generated value.
   */
  private function getRandomValue(){
    return sha1(uniqid(mt_rand(), true));
  }

  /**
   * Constructs a store.
   * @param Model $model Model to be stored.
   * @param [String => Mixed] $data Properties to be used on the model.
   * @param [String => Mixed] $opts
   * @return Model
   */
  protected function constructStore(Model $model, array $data, array $opts) {
    $data = array_merge($this->defaults, $data);
    //$this->validateData($data);

    // Sets properties on model.
    $model->api = [
      'basic_key' => $this->getRandomValue(),
      'basic_secret' => $this->getRandomValue()
    ];
    $model->lrs_id = $opts['lrs_id'];
    $model->authority = $data['authority'];
    $model->scopes = ['all'];

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
    if (isset($data['authority_raw'])) $model->authority_raw = $data['authority_raw'];
    if (isset($data['scopes_raw'])) $model->scopes_raw = $data['scopes_raw'];
	if (isset($data['description'])) $model->description = $data['description'];

    return $model;
  }

  /**
   * Creates a new model.
   * @param [String => Mixed] $data Properties of the new model.
   * @param [String => Mixed] $opts
   * @return Model
   */
   
  public function store(array $data, array $opts) {
	$client = new Client;

	$api = new \stdClass;
	$api->client_id = $client->api['basic_key'];
	$api->client_secret = $client->api['basic_secret'];
	$api->redirect_uri = 'http://www.example.com/';
	
	$client->api_raw = JSON_ENCODE($api);
	$client->lrs_id = $opts['lrs_id'];
	$client->save();
	
    return $client;
  }

  /**
   * Destroys the model with the given ID and options.
   * @param String $id ID to match.
   * @param [String => Mixed] $opts
   * @return Boolean
   */
  public function destroy($id, array $opts) {
    $client = $this->show($id, $opts);
    \DB::getMongoDB()->oauth_clients->remove([
      'client_id' => $client->api['basic_key']
    ]);
    if ($this->where($opts)->count() < 2) {
      $this->store(['authority' => [
        'name' => 'Must have client',
        'mbox' => 'mailto:hello@learninglocker.net'
      ]], $opts);
    }
    return parent::destroy($id, $opts);
  }

  /**
   * Converts foreign ids to MongoIds, then
   * gets the model with the given ID and options.
   * @param String $id ID to match.
   * @param [String => Mixed] $opts
   * @return Model
   */
  public function show($id, array $opts) {
    return parent::show($id, $opts);
  }

  /**
   * Gets the model with the given username, password, and options.
   * @param String $username Username to match.
   * @param String $password Password to match.
   * @param [String => Mixed] $opts
   * @return Model
   */
  public function showFromUserPass($username, $password, array $opts) {
    $model = (new $this->model)
      ->where('api.basic_key', $username)
      ->where('api.basic_secret', $password)
      ->first();

    if ($model === null) throw new Exceptions\NotFound($id, $this->model);

    return $this->format($model);
  }
}