[![GitHub issues](https://img.shields.io/github/issues/spjoshis/File-Uploader-To-Google-Drive-PHP.svg)](https://github.com/spjoshis/File-Uploader-To-Google-Drive-PHP/issues) [![GitHub stars](https://img.shields.io/github/stars/spjoshis/File-Uploader-To-Google-Drive-PHP.svg)](https://github.com/spjoshis/File-Uploader-To-Google-Drive-PHP/stargazers) [![GitHub license](https://img.shields.io/github/license/spjoshis/File-Uploader-To-Google-Drive-PHP.svg)](https://github.com/spjoshis/File-Uploader-To-Google-Drive-PHP)
    
# File-Uploader-To-Google-Drive-PHP
Upload File to Google Drive Using PHP

Author : Gopal Joshi <br>
Usage:

<b>Update Composer</b>
<pre><code>$ composer update</code></pre>
<p>Generate Google Secret File from https://console.developers.google.com/ and save it in `secrets` folder.</p>

<b>Include upload.php</b>
<pre><code>&lt;?php
  include 'upload.php';
  $drive = new GoogleDrive();
  $file = $drive->upload('files/', 'photo.gif');
  if (!empty($file->id)) {
    printf("File Uploaded Successfully! [ID: %s\n", $file->id.']');
  }
?&gt;
</code></pre>
