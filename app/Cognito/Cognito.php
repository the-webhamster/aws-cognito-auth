<?php
namespace App\Cognito;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

class Cognito {
    private $_cognito;
    private $_auth_result;

    /**
     * Class constructor
     */
    public function __construct() {
        $this->_initialize();
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
        unset($this->_cognito);
        unset($this->_auth_result);
    }

    /**
     * Initialize the Cognito Identity Provider Client
     */
    private function _initialize() {
        $this->_cognito = new CognitoIdentityProviderClient([
            'region' => $_ENV['AWS_REGION'],
            'version' => $_ENV['AWS_VERSION'],
            'credentials' => array(
                'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                'secret'  => $_ENV['AWS_SECRET_ACCESS_KEY'],
            )
        ]);
    }

    /**
     * Calls the _authenticate() method to set the $_auth_result array.  Will return the AccessToken value if found
     * otherwise false.
     *
     * @param $username
     * @param $password
     * @return false|mixed
     */
    public function login($username, $password) {
        $this->_authenticate($username, $password);
        if (is_array($this->_auth_result)) {
            return $this->_auth_result['AccessToken'];
        }
        return false;
    }

    /**
     * Allows you to access any value from the _auth_result array, if set.  Returns false if the value is not found.
     *
     * Valid keys: AccessToken, ExpiresIn, TokenType, RefreshToken, IdToken
     *
     * @param $key
     * @return false|mixed
     */
    public function get_result_key($key) {
        if (array_key_exists($key,$this->_auth_result)) {
            return $this->_auth_result[$key];
        }
        return false;
    }

    /**
     * Function that makes the authentication call to the Cognito User Pool and gets back the result.  It then sets it
     * as a private class variable.
     *
     * @param $username
     * @param $password
     */
    private function _authenticate($username, $password) {
        if (isset($this->_cognito)) {
            $auth_result = $this->_cognito->adminInitiateAuth([
                'AuthFlow' => 'ADMIN_USER_PASSWORD_AUTH',
                'ClientId' => $_ENV['COGNITO_APP_CLIENT_ID'],
                'UserPoolId' => $_ENV['COGNITO_USER_POOL_ID'],
                'AuthParameters' => [
                    'USERNAME' => $username,
                    'PASSWORD' => $password,
                ]
            ]);

            if ($auth_result->get('AuthenticationResult')) {
                $this->_auth_result = $auth_result->get('AuthenticationResult');
            }
        }
    }
}