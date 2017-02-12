<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';
/*
 * Configuration and setup Google API
 */
$clientId = '696383331717-agrn0e8i3nrf4ck0vt2c163i6n79772i.apps.googleusercontent.com';
$clientSecret = 'fvEiSJ6dK2J_FVE2SmVWMtxM';
$redirectURL = 'http://localhost/modeloImpacto.php';

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>