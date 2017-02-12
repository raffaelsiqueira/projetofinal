<?php
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_DriveService.php';


$client = new Google_Client();
// Get your credentials from the console
$client->setClientId('696383331717-80cqsh56kcmimqktgsjeeqmau2p1hnhu.apps.googleusercontent.com');
$client->setClientSecret('pnyLFFASAFNi2zwgc-Jh3ifb');
$client->setRedirectUri('http://localhost');
$client->setScopes(array('https://www.googleapis.com/auth/drive',));
//urn:ietf:wg:oauth:2.0:oob

$service = new Google_DriveService($client);

$authUrl = $client->createAuthUrl();

//Request Authorization
print "Please visit:<br>\n$authUrl\n\n<br>";
//print "Please enter the auth code:\n";
$authCode = trim(fgets(STDIN));

//Exchance authorization code for access token
$accessToken = $client->authenticate($authCode);
$client->setAccessToken($accessToken);

//Insert a file
$file = new Google_DriveFile();
$file->setName('My document');
$file->setDescription('A test document');
$file->setMimeType('text/plain');

$data = file_get_contents('document.txt');

$createdFile = $service->files->create($file, array(
          'data' => $data,
          'mimeType' => 'text/plain',
        ));

print_r($createdFile);
?>