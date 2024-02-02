<?php
include "googleset.php";
$access_token=file_get_contents("/home/www/data/access_token");

$file_content=file_get_contents($target_file); 
$mime_type=mime_content_type($target_file); 
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_HTTPHEADER,Array("Content-Type: ".$mime_type,"Authorization: Bearer ".$access_token));
curl_setopt($ch,CURLOPT_POSTFIELDS,$file_content);
echo curl_exec($ch);
echo "\n";
curl_close($ch);
?>
