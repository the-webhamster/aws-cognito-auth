<?php
require('bootstrap.php');

use App\Cognito\CognitoAuth;

$cognito = new App\Cognito\CognitoAuth;
echo $cognito->cognito_login();
