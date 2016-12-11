<?php namespace BibleExperience\Http\Controllers\xAPI;

use \Illuminate\Routing\Controller;
use BibleExperience\Http\Controllers\Api\Base as APIBaseController;
use \BibleExperience\Locker\statements\xAPIValidation as XApiValidator;
use \BibleExperience\Helpers\Exceptions as Exceptions;

class BaseController extends APIBaseController {

  // Sets constants for status codes.
  const OK = 200;
  const NO_CONTENT = 204;
  const NO_AUTH = 403;
  const CONFLICT = 409;

  // Defines properties to be set by the constructor.
  protected $params, $method, $lrs;

  /**
   * Constructs a new xAPI controller.
   */
  public function __construct() {
    parent::__construct();
    $this->setMethod();
  }

  /**
   * Get all of the input and files for the request and store them in params.
   *
   */
  public function setParameters(){
    $this->params = \Request::all();
    $this->params['content'] = \Request::getContent();
  }

  /**
   * Selects a method to be called.
   * @return mixed Result of the method.
   */
  public function selectMethod() {
    switch ($this->method) {
      case 'HEAD':
      case 'GET': return $this->get();
      case 'PUT': return $this->update();
      case 'POST': return $this->store();
      case 'DELETE': return $this->destroy();
    }
  }

  public function get() {
    return \Request::hasParam($this->identifier) ? $this->show() : $this->index();
  }

  /**
   * Checks the request header for correct xAPI version.
   **/
  protected function checkVersion() {
    $version = \Request::header('X-Experience-API-Version');

    if (!isset($version) || substr($version, 0, 4) !== '1.0.') {
      throw new Exceptions\Exception('This is not an accepted version of xAPI.');
    }
  }

  /**
   * Sets the method (to support CORS).
   */
  protected function setMethod() {
    $this->setParameters();
    $this->method = \Request::getParam(
      'method',
      \Request::server('REQUEST_METHOD')
    );
  }

  protected function optionalValue($name, $value, $type) {
    $decodedValue = $this->decodeValue($value);
    if (isset($decodedValue)) $this->validateValue($name, $decodedValue, $type);
    return $decodedValue;
  }

  protected function requiredValue($name, $value, $type) {
    $decodedValue = $this->decodeValue($value);
    if (isset($decodedValue)) {
      $this->validateValue($name, $decodedValue, $type);
    } else {
      throw new Exceptions\Exception('Required parameter is missing - ' . $name);
    }
    return $decodedValue;
  }

  protected function validatedParam($type, $param, $default = null) {
    $paramValue = \Request::getParam($param, $default);
    $value = $this->decodeValue($paramValue);
    if (isset($value)) $this->validateValue($param, $value, $type);
    return $value;
  }

  protected function decodeValue($value) {
    $decoded = gettype($value) === 'string' ? json_decode($value, true) : $value;
    return isset($decoded) ? $decoded : $value;
  }

  protected function validateValue($name, $value, $type) {
    $validator = new XApiValidator();
    $validator->checkTypes($name, $value, $type, 'params');
    if ($validator->getStatus() !== 'passed') {
      throw new Exceptions\Exception(implode(',', $validator->getErrors()));
    }
  }
}
