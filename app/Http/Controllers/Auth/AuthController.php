<?php namespace BibleExperience\Http\Controllers\Auth;

use BibleExperience\Http\Controllers\Controller;
use Socialite;
use BibleExperience\User;
use Auth;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
		
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
		
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/github');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('email', $githubUser->email)->first()) {
            return $authUser;
        }

        return User::create([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
			'verified' => 'yes'/*,
            'github_id' => $githubUser->id,
            'avatar' => $githubUser->avatar*/
        ]);
    }
}