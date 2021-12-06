<?php
session_start();

include_once __DIR__ . "/vendor/autoload.php";
include_once __DIR__ . "/app/Cognito/Cognito.php";

/**
 * Include phpDotEnv to manage environment variables
 */
$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ );
$dotenv->load();