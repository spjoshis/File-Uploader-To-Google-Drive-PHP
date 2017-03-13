<?php

require_once __DIR__ . '/vendor/autoload.php';
/**
*   Google Drive Class
*/
class GoogleDrive
{
  
  function __construct()
  {
    $this->appName    = 'Upload File To Google Drive';
    $this->credPath   = __DIR__ . 'secrets\drive-php-upload.json';
    $this->secretPath =  __DIR__ . '\secrets\client_secret.json';
    $this->scopes     = implode(' ', array(Google_Service_Drive::DRIVE));
  }

  /**
   * Returns an authorized API client.
   * @return Google_Client the authorized client object
   */
  private function getClient() {
    $client = new Google_Client();
    $client->setApplicationName($this->appName);
    $client->setScopes($this->scopes);
    $client->setAuthConfig($this->secretPath);
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = $this->expandHomeDirectory($this->credPath);
    if (file_exists($credentialsPath)) {
      $accessToken = json_decode(file_get_contents($credentialsPath), true);
  
    } else {
  
      // Request authorization from the user.
      $authUrl = $client->createAuthUrl();
      printf("Open the following link in your browser:\n%s\n", $authUrl);
      print 'Enter verification code: ';
      $authCode = trim(fgets(STDIN));

      // Exchange authorization code for an access token.
      $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

      // Store the credentials to disk.
      if(!file_exists(dirname($credentialsPath))) {
        mkdir(dirname($credentialsPath), 0700, true);
      }
      file_put_contents($credentialsPath, json_encode($accessToken));
      printf("Credentials saved to %s\n", $credentialsPath);
    }
  
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
      $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
      file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
  }

  /**
   * Expands the home directory alias '~' to the full path.
   * @param string $path the path to expand.
   * @return string the expanded path.
   */
  private function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
      $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
  }

  public function upload($path, $fileName){
    $client = $this->getClient();
    $service = new Google_Service_Drive($client);
    $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => 'upload_'.$fileName));
    $content = file_get_contents($path. $fileName);
    $file = $service->files->create($fileMetadata, array(
      'data'       => $content,
      'mimeType'   => mime_content_type($path. $fileName), //'image/jpeg',
      'uploadType' => 'multipart',
      'fields'     => 'id')
    );
    return $file;
  }
}
