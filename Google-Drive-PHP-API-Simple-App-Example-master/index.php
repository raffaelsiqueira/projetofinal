<?php
session_start();
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];
//require_once 'google-api-php-client/src/Google_Client.php';
//require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
require_once 'vendor/autoload.php';
$client = new Google_Client();
$client->setClientId('696383331717-80cqsh56kcmimqktgsjeeqmau2p1hnhu.apps.googleusercontent.com');
$client->setClientSecret('pnyLFFASAFNi2zwgc-Jh3ifb');
$client->setRedirectUri('http://localhost/Google-Drive-PHP-API-Simple-App-Example-master/index.html');
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
if (isset($_GET['code'])) {
    //$_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    try{
    $_SESSION['accessToken'] = $client->getAccessToken($_GET['code']);
    print_r($accessToken);
    header('location:'.$url);exit;
    }
    catch (InvalidArgumentException $e){
      var_dump($accessToken);  
    }
} elseif (!isset($_SESSION['accessToken'])) {
    //$client->authenticate();
    try{
    $_SESSION['accessToken'] = $client->getAccessToken();
    print_r($accessToken);
    header('location:'.$url);exit;
    }
    catch (InvalidArgumentException $e){
      var_dump($accessToken);  
    }
    //print_r($accessToken);
}
$files= array();
$dir = dir('files');
while ($file = $dir->read()) {
    if ($file != '.' && $file != '..') {
        $files[] = $file;
    }
}
$dir->close();
if (!empty($_POST)) {
    $client->setAccessToken($_SESSION['accessToken']);
    $service = new Google_DriveService($client);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file = new Google_DriveFile();
    foreach ($files as $file_name) {
        $file_path = 'files/'.$file_name;
        $mime_type = finfo_file($finfo, $file_path);
        $file->setTitle($file_name);
        $file->setDescription('This is a '.$mime_type.' document');
        $file->setMimeType($mime_type);
        $service->files->insert(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type
            )
        );
    }
    finfo_close($finfo);
    header('location:'.$url);exit;
}
include 'index.html';
