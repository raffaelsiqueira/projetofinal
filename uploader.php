<?php
require_once 'C:/wamp64/www/src/Google_Client.php';
require_once 'C:/wamp64/www/src/contrib/Google_DriveService.php';
require_once 'C:/wamp64/www/src/contrib/Google_Oauth2Service.php';
require_once 'C:/wamp64/www/google-api-php-client/vendor/autoload.php';

$client = new Google_Client();
    // Get your credentials from the console
    
	$client->setClientId('318842794290-2m1dl9daegafau6mcc1d1lpjm4jkv3h1.apps.googleusercontent.com');
	$client->setClientSecret('CPGW85NVauz9QEy4b83_pgvD');
	$client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
	$client->setScopes(array('https://www.googleapis.com/auth/drive'));
	$client->setAuthConfig('C:/wamp64/www/client_secret.json');
	$client->addScope(Google_Service_Drive::DRIVE);
	$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');

    $service = new Google_DriveService($client);

    $authUrl = $client->createAuthUrl();

    //Request authorization
    print "Please visit:\n$authUrl\n\n";
    print "Please enter the auth code:\n";
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for access token
    $accessToken = $client->authenticate($authCode);
    $client->setAccessToken($accessToken);

    //Insert a file
    $file = new Google_DriveFile();
   // $localfile = 'a.jpg';
    //$title = basename($localfile);
    $file->setTitle('My Document');
    $file->setDescription('Teste');
    $file->setMimeType('image/jpeg');

    $data = file_get_contents('a.jpg');

    $createdFile = $service->files->insert($file, array(
          'data' => $data,
          'mimeType' => 'image/jpeg',
        ));

    print_r($createdFile);
?>