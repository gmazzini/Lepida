<?php
include "googleset.php";

$curlPost="client_id=".$client_id
."&redirect_uri=".$redirect_uri
."&client_secret=".$client_secret
."&code=".$_GET["code"]
."&access_type=offline"
."&grant_type=authorization_code";

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://oauth2.googleapis.com/token");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
$oo=json_decode(curl_exec($ch),true);
file_put_contents('/home/www/data/access_token',$oo["access_token"]);
file_put_contents('/home/www/data/refresh_token',$oo["refresh_token"]);
curl_close($ch);
?>
