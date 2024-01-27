<?php
include "googleset.php";

$refresh_token=file_get_contents("/home/www/data/refresh_token");
$curlPost="client_id=".$client_id
."&client_secret=".$client_secret
."&refresh_token=".$refresh_token
."&grant_type=refresh_token";

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://oauth2.googleapis.com/token");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
$oo=json_decode(curl_exec($ch),true);
file_put_contents('/home/www/data/access_token',$oo["access_token"]);
curl_close($ch);
?>
