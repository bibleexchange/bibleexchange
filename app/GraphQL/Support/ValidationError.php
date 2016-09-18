<?php namespace BibleExperience\GraphQL\Support;

use GraphQL\Error;

class ValidationError extends Error
{
    /**
     * The validator.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Set validator instance.
     *
     * @param mixed $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get the messages from the validator.
     *
     * @return array
     */
    public function getValidatorMessages()
    {
        return $this->validator ? $this->validator->messages() : [];
    }
}
