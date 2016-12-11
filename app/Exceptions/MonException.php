<?php namespace BibleExperience\Exceptions;

use Exception;

abstract class monException extends Exception
{
    protected $id;
    protected $details;
     
    public function __construct($message)
    {
        parent::__construct($message);
    }
 
    protected function create(array $args)
    {
        $this->id = array_shift($args);
        $error = $this->errors($this->id);
        $this->details = vsprintf($error['context'], $args);
        return $this->details;
    }
 
    private function errors($id)
    {
        $data = [
            'not_found' => [
                'context'  => 'The requested resource could not be found but may be available again in the future. Subsequent requests by the client are permissible.',
            ]

        ];
		
        return $data[$id];
    }
}