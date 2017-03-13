<?php

	require_once '/vendor/autoload.php';
	require_once 'src/Google/Client.php';
	require_once 'src/contrib/Google_DriveService.php';



	$client_id = '696383331717-80cqsh56kcmimqktgsjeeqmau2p1hnhu.apps.googleusercontent.com';
	$client_secret = 'pnyLFFASAFNi2zwgc-Jh3ifb';
	$redirect_uri = 'http://localhost/modeloImpacto.php';
	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	//$client->addScope("https://www.googleapis.com/auth/drive");
	 $client->setScopes(array('https://www.googleapis.com/auth/drive'));
	$service = new Google_Service_Drive($client);

	$authUrl = $client->createAuthUrl();

	$acessToken = $client->getAccessToken();
	print_r($accessToken);
	file_put_contents($credentialsPath, json_encode($accessToken));

	$fileMetadata = new Google_Service_Drive_DriveFile(array(
  'name' => 'funcionou.jpg'));
	$content = file_get_contents('funcionou.jpg');
	$file = $driveService->files->create($fileMetadata, array(
	  'data' => $content,
	  'mimeType' => 'image/jpeg',
	  'uploadType' => 'multipart',
	  'fields' => 'id'));
	printf("File ID: %s\n", $file->id);

?>