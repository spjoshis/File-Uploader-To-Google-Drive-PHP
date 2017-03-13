# File-Uploader-To-Google-Drive-PHP
Upload File to Google Drive Using PHP

Author : Gopal Joshi<br/ >
Website: www.sgeek.org<br/ >
Tutorial : Upload File to Google Drive using PHP<br/ >
Usage:

<b>Update Composer</b>
<pre><code>$ composer update</code></pre>

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
