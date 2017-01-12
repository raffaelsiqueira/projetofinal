<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';
/*
 * Configuration and setup Google API
 */
$clientId = '318842794290-2m1dl9daegafau6mcc1d1lpjm4jkv3h1.apps.googleusercontent.com';
$clientSecret = 'CPGW85NVauz9QEy4b83_pgvD';
$redirectURL = 'http://localhost/modeloImpacto.php';

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>