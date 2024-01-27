<?php
include "googleset.php";
$access_token=file_get_contents("/home/www/data/access_token");

$curlPost="token=".$access_token;

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://oauth2.googleapis.com/revoke");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
curl_exec($ch);
curl_close($ch);
?>
