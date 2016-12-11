<?php

Route::get('/api/protected', ['middleware' => 'auth0.jwt', function() {
    return "Hello " . Auth0::jwtuser()->name;
}]);

Route::get('/test', function() {

return 3;
});

/*
\Auth::logout();
$user = \BibleExperience\User::find(1);
$user->setPassword('me');
$user->save();
*/
