<?php

set_include_path("google-api-php-client/src/" . PATH_SEPARATOR . get_include_path());

require_once 'vendor/google/apiclient/src/Google/Client.php';
require_once 'vendor/google/apiclient/src/Google/Service.php';
require_once 'vendor/google/apiclient-services/src/Google/Service/Drive.php';
require_once 'vendor/autoload.php';


$client = new Google_Client();
// Get your credentials from the console
$client->setClientId('696383331717-80cqsh56kcmimqktgsjeeqmau2p1hnhu.apps.googleusercontent.com');
$client->setClientSecret('pnyLFFASAFNi2zwgc-Jh3ifb');
$client->setRedirectUri('http://localhost/indexoriginal.php');
$client->setScopes(array('https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/drive.apps.readonly'));

session_start();

if (isset($_GET['code']) || (isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
    } else
        $client->setAccessToken($_SESSION['access_token']);

    $service = new Google_Service_Drive($client);

    //Insert a file
    $file = new Google_Service_Drive_DriveFile();
    $file->setName(uniqid().'.jpg');
    $file->setDescription('A test document');
    $file->setMimeType('image/jpeg');

    $data = file_get_contents('a.jpg');

    $createdFile = $service->files->create($file, array(
          'data' => $data,
          'mimeType' => 'image/jpeg',
          'uploadType' => 'multipart'
        ));

    print_r($createdFile);

} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
}
?>