<?php

namespace BibleExperience\OAuth2\GrantType;

use BibleExperience\OAuth2\ResponseType\AccessTokenInterface;
use BibleExperience\OAuth2\RequestInterface;
use BibleExperience\OAuth2\ResponseInterface;

/**
 * Interface for all OAuth2 Grant Types
 */
interface GrantTypeInterface
{
    public function getQuerystringIdentifier();
    public function validateRequest(RequestInterface $request, ResponseInterface $response);
    public function getClientId();
    public function getUserId();
    public function getScope();
    public function createAccessToken(AccessTokenInterface $accessToken, $client_id, $user_id, $scope);
}
