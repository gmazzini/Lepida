<?php

$access_token=file_get_contents("/home/www/data/access_token");
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"https://oauth2.googleapis.com/tokeninfo?access_token=".$access_token);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
$oo=json_decode(curl_exec($ch),true);
print_r($oo);
curl_close($ch);
?>
