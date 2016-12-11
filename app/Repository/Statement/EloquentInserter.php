<?php namespace BibleExperience\Repository\Statement;

use \BibleExperience\Helpers\Exceptions as Exceptions;
use \BibleExperience\Helpers\Helpers as Helpers;
use \BibleExperience\Statement;

interface Inserter {
  public function insert(array $statements, StoreOptions $opts);
}

class EloquentInserter extends EloquentReader implements Inserter {

  /**
   * Inserts statements with the given options.
   * @param [\stdClass] $statements
   * @param StoreOptions $opts
   * @throws Exceptions\Conflict
   */
  public function insert(array $statements, StoreOptions $opts) {
    $models = [];

    foreach($statements as $statement) {
      //$duplicate = $this->checkForConflict($statement, $opts);
      //if (!$duplicate) {
        $models[$statement->id] = $this->constructModel($statement, $opts);
      //}
    }

    return $this->insertModels($models, $opts);
  }

  /**
   * Checks for a duplicate statement with the given options.
   * @param [\stdClass] $statements
   * @param StoreOptions $opts
   * @throws Exceptions\Conflict
   */
  private function checkForConflict(\stdClass $statement, StoreOptions $opts) {
	 
	 //temporary hack to skip past this
	 return true;
	 
    $duplicate = $this->where($opts)
      ->where('id', $statement->id)
      ->where('active', true)
      ->first();

    if ($duplicate === null) return false;

    $this->compareForConflict($statement, json_decode($this->formatModel($duplicate)));
    return true;
  }

  /**
   * Compares two statements.
   * Throws Exceptions\Conflict if the two statements match.
   * @param \stdClass $statement_x
   * @param \stdClass $statement_y
   * @throws Exceptions\Conflict
   */
  public function compareForConflict(\stdClass $statement_x, \stdClass $statement_y) {
    $matchable_x = $this->matchableStatement($statement_x);
    $matchable_y = $this->matchableStatement($statement_y);

    if ($matchable_x != $matchable_y) {
      $encoded_x = json_encode($statement_x);
      $encoded_y = json_encode($statement_y);
	  
	  throw new \BibleExperience\Exceptions\StatementConflictException("Conflicts\r\n`$encoded_x`\r\n`$encoded_y`.");

	};
  }

  /**
   * Decodes the encoded statement.
   * Removes properties not necessary for matching.
   * @param \stdClass $statement
   * @return \stdClass $statement
   */
  private function matchableStatement(\stdClass $statement) {
    $statement = json_decode(json_encode($statement));
    unset($statement->stored);
    unset($statement->timestamp);
    unset($statement->authority);
    return $statement;
  }

  /**
   * Constructs a model from the given statement and options.
   * @param \stdClass $statement
   * @param StoreOptions $opts
   * @return [String => Mixed] $model
   */
  private function constructModel(\stdClass $statement, StoreOptions $opts) {
    $timestamp = new \Carbon\Carbon($statement->timestamp);
    $stored    = new \Carbon\Carbon($statement->stored);
    return [
      'lrs' => ['_id' => $opts->getOpt('lrs_id')], // Deprecated.
      'lrs_id' => $opts->getOpt('lrs_id'),
      'client_id' => $opts->getOpt('client')->id,
      'statement' => Helpers::replaceFullStop(json_decode(json_encode($statement), true)),
      'active' => false,
      'voided' => false,
      'timestamp' => $timestamp->timestamp,
      'stored'    => $stored->timestamp];
  }

  /**
   * Inserts models with the given options.
   * @param [[String => Mixed]] $models
   * @param StoreOptions $opts
   */
  private function insertModels(array $models, StoreOptions $opts) {

    if(empty($models)) {
      return;
    }
	
	$newStatement = new Statement;
	$newArray = [];

	foreach($models as $key => $m){

		$newStatement->refs= $key;
		 $newStatement->lrs_id = $m['lrs_id'];
		 //$newStatement->client_id = $m['client_id'];
		 $newStatement->statement = json_encode($m['statement']);
		 $newStatement->active = $m['active'];
		 $newStatement->voided = $m['voided'];
		 $newStatement->timestamp = $m['timestamp'];
		 $newStatement->stored = $m['stored'];
		 $newStatement->save();
		 $newArray[] = $newStatement;
	 }
	return $newArray;

  }
}
