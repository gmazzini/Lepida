<?php
include "googleset.php";
$access_token=file_get_contents("/home/www/data/access_token");

$curlPost='
{
  "valueInputOption": "RAW",
  "data": [
    {
      "range": "Sheet1!A1:A2",
      "majorDimension": "COLUMNS",
      "values": [
        [10.1, "12.4"]
      ]
    },
    {
      "range": "Sheet1!B1:C2",
      "majorDimension": "ROWS",
      "values": [
        ["22.3", "44.2"]
      ]
    }
  ]
}';

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://sheets.googleapis.com/v4/spreadsheets/1Zr8VNAexXZvq3r1oZZ2x9DdyOVBS1jCNM6-035mR0bo/values:batchUpdate");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_HTTPHEADER,Array("Content-Type: application/json","Authorization: Bearer ".$access_token));
curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
echo curl_exec($ch);
echo "\n";
curl_close($ch);
?>
