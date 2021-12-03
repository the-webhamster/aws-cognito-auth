<?php
namespace App\Cognito;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

class CognitoAuth {

    public function __construct() {
    }

    public function __destruct() {
    }

    public function cognito_login() {
        $cognito = new CognitoIdentityProviderClient([
            'region' => $_ENV['AWS_REGION'],
            'version' => $_ENV['AWS_VERSION'],
            'credentials' => array(
                'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                'secret'  => $_ENV['AWS_SECRET_ACCESS_KEY'],
            )
        ]);

        $result = $cognito->adminInitiateAuth([
            'AuthFlow' => 'ADMIN_USER_PASSWORD_AUTH',
            'ClientId' => $_ENV['COGNITO_APP_CLIENT_ID'],
            'UserPoolId' => $_ENV['COGNITO_USER_POOL_ID'],
            'AuthParameters' => [
                'USERNAME' => $_ENV['COGNITO_USER'],
                'PASSWORD' => $_ENV['COGNITO_PASSWORD'],
            ]
        ]);

        if ($result->get('AuthenticationResult')) {
            return $result->get('AuthenticationResult')['AccessToken'];
        }
        return 0;
    }
}