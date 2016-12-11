<?php

namespace BibleExperience\OAuth2\ClientAssertionType;

use BibleExperience\OAuth2\RequestInterface;
use BibleExperience\OAuth2\ResponseInterface;

/**
 * Interface for all OAuth2 Client Assertion Types
 */
interface ClientAssertionTypeInterface
{
    public function validateRequest(RequestInterface $request, ResponseInterface $response);
    public function getClientId();
}
