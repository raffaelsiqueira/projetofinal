<?php
require_once "google/google-api-php-client/src/Google_Client.php";

require_once "google/google-api-php-client/src/contrib/Google_DriveService.php";

require_once "google/google-api-php-client/src/contrib/Google_Oauth2Service.php";
 
require_once "google/vendor/autoload.php";


$DRIVE_SCOPE = 'https://www.googleapis.com/auth/drive';
$SERVICE_ACCOUNT_EMAIL = 'YOUR_SERVICE_EMAIL';
$SERVICE_ACCOUNT_PKCS12_FILE_PATH = 'YOUR_DOWNLOADED_SERVICE_P12FILE_PATH';

function buildService() {//function for first build up service
global $DRIVE_SCOPE, $SERVICE_ACCOUNT_EMAIL, $SERVICE_ACCOUNT_PKCS12_FILE_PATH;

  $key = file_get_contents($SERVICE_ACCOUNT_PKCS12_FILE_PATH);
  $auth = new Google_AssertionCredentials(
      $SERVICE_ACCOUNT_EMAIL,
      array($DRIVE_SCOPE),
      $key);
  $client = new Google_Client();
  $client->setUseObjects(true);
  $client->setAssertionCredentials($auth);
  return new Google_DriveService($client);
}

function insertFile($service, $title, $description, $parentId, $mimeType, $filename) {//function for insert a file
 
  $file = new Google_DriveFile();
  $file->setTitle($title);
  $file->setDescription($description);
  $file->setMimeType($mimeType);

  // Set the parent folder.
  if ($parentId != null) {
    $parent = new Google_ParentReference();
    $parent->setId($parentId);
    $file->setParents(array($parent));
  }

  try {
    $data = file_get_contents($filename);

    $createdFile = $service->files->insert($file, array(
      'data' => $data,
      'mimeType' => $mimeType,
    ));


//set the file with MIME
$permission = new Google_Permission();
$permission->setRole( 'writer' );
$permission->setType( 'anyone' );
$permission->setValue( 'me' );
$service->permissions->insert( $createdFile->getId(), $permission );

//insert permission for the file


    
    return $createdFile;
  } catch (Exception $e) {
print "An error occurred1: " . $e->getMessage();
  }
}

try {


$root_id='YOUR_FOLDER_ID';

$service=buildService();

$title="test";
$description='';
$parentId=$root_id;
$file="YOUR_EXCEL_FILE_PATH";
$mimeType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";//For Excel File
$filename=$file;
$parentId=insertFile($service, $title, $description, $parentId, $mimeType, $filename);


  } catch (Exception $e) {
  print "An error occurred1: " . $e->getMessage();
  }
?>