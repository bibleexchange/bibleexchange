<?php

namespace BibleExperience\OAuth2\OpenID\Controller;

use BibleExperience\OAuth2\RequestInterface;
use BibleExperience\OAuth2\ResponseInterface;

/**
 *  This controller is called when the user claims for OpenID Connect's
 *  UserInfo endpoint should be returned.
 *
 *  ex:
 *  > $response = new OAuth2\Response();
 *  > $userInfoController->handleUserInfoRequest(
 *  >     OAuth2\Request::createFromGlobals(),
 *  >     $response;
 *  > $response->send();
 *
 */
interface UserInfoControllerInterface
{
    public function handleUserInfoRequest(RequestInterface $request, ResponseInterface $response);
}
