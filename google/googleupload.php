<?php
include "googleset.php";
$access_token=file_get_contents("/home/www/data/access_token");

$curlPost='
{
  "valueInputOption": "RAW",
  "data": [
    {
      "range": "Sheet1!A1:A2",
      "majorDimen
  ]
}';

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_HTTPHEADER,Array("Content-Type: application/json","Authorization: Bearer ".$access_token));
curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
echo curl_exec($ch);
echo "\n";
curl_close($ch);
?>
