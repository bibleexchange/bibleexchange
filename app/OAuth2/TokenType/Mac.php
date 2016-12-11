<?php

namespace BibleExperience\OAuth2\TokenType;

use BibleExperience\OAuth2\RequestInterface;
use BibleExperience\OAuth2\ResponseInterface;

/**
* This is not yet supported!
*/
class Mac implements TokenTypeInterface
{
    public function getTokenType()
    {
        return 'mac';
    }

    public function getAccessTokenParameter(RequestInterface $request, ResponseInterface $response)
    {
        throw new \LogicException("Not supported");
    }
}
