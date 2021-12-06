<?php
/**
 * Bring in the stuff we need an initialize (how you handle this will be up to you - this is my simple way of getting
 * everything up and running for this tutorial
 */
require('../bootstrap.php');

/**
 * Bring in our Cognito class (See app/Cognito)
 */
use App\Cognito\Cognito;

/**
 * Initialize our class
 */
$cognito = new App\Cognito\Cognito;

/**
 * Call the login method.  I pass a username and password from our .env file but you could do this from a POST object
 * or some other method.  That's up to you.  The login method returns the AccessToken value so I'm just echoing it here
 * for example purposes.  You have to decide what to do with it from here for your app.
 */
echo $cognito->login($_ENV['COGNITO_USER'],$_ENV['COGNITO_PASSWORD']);

/**
 * I created a method that will allow you to get items from the authentication result array in case you want more than
 * the Access Token.
 *
 * Valid values: AccessToken, ExpiresIn, TokenType, RefreshToken, IdToken
 *
 * Anything other than the valid values will get a false as a return.
 */
echo $cognito->get_result_key('TokenType');