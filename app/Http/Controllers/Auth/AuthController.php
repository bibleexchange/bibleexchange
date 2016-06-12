<?php namespace BibleExchange\Http\Controllers\Auth;

use BibleExchange\Http\Controllers\Controller;
use Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
		//FROM: https://github.com/laravel/socialite
		/*
		The redirect method takes care of sending the user to the OAuth provider, while the user method will read the incoming request and retrieve the user's information from the provider. Before redirecting the user, you may also set "scopes" on the request using the scope method. This method will overwrite all existing scopes:

		return Socialite::driver('github')
            ->scopes(['scope1', 'scope2'])->redirect();
		*/
		
		/*
		A number of OAuth providers support optional parameters in the redirect request. To include any optional parameters in the request, call the with method with an associative array:

		return Socialite::driver('google')
            ->with(['hd' => 'example.com'])->redirect();
			
		When using the with method, be careful not to pass any reserved keywords such as state or response_type.
		*/
		
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
		dd($user);
        /*
		Once you have a user instance, you can grab a few more details about the user:

		$user = Socialite::driver('github')->user();

		// OAuth Two Providers
		$token = $user->token;
		$refreshToken = $user->refreshToken; // not always provided
		$expiresIn = $user->expiresIn;

		// OAuth One Providers
		$token = $user->token;
		$tokenSecret = $user->tokenSecret;

		// All Providers
		$user->getId();
		$user->getNickname();
		$user->getName();
		$user->getEmail();
		$user->getAvatar();
		*/
    }
}