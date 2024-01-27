<?php
include "googleset.php";
$access_token=file_get_contents("/home/www/data/access_token");

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://sheets.googleapis.com/v4/spreadsheets/1Zr8VNAexXZvq3r1oZZ2x9DdyOVBS1jCNM6-035mR0bo/values/Sheet1!A1:A1");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_HTTPHEADER,Array("Authorization: Bearer ".$access_token));
echo curl_exec($ch);
echo "\n";
curl_close($ch);
?>
