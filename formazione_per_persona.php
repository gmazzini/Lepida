<?php
include "token.php";

$fp=fopen("formazione","r");
for(;;){
  $aux=trim(fgets($fp));
  if(feof($fp))break;
  $act[$aux]=1;
}
fclose($fp);

$acc=array();
$from=date("0101y");
$to=date("3112y");
$all=file_get_contents("https://orelavorate.lepida.it/download/proc.php?token=$token&from=$from&to=$to");
$lines=explode("\n",$all);
foreach($lines as $aux){
  if(str_contains($aux,"\""))continue;
  $dd=explode(",",trim($aux));
  if(!isset($dd[2]))continue;
  if(!isset($act[$dd[2]]))continue;
  $rr=explode(":",$dd[3]);
  $oo=$rr[0]*60+$rr[1];
  @$acc[$dd[1]]+=$oo;
}

$oo="{ \"valueInputOption\":\"RAW\", \"data\":[{ \"range\":\"f_ore!A1:B800\", \"majorDimension\":\"ROWS\",";
$oo.="\"values\": [";
$n=0; 
foreach($acc as $k => $v){
  if($n>=800)break;
  if($n>0)$oo.=",";
  $oo.="[\"$k\",$v]";
  $n++;
}
for(;;){
  if($n>=800)break;
  if($n>0)$oo.=",";
  $oo.="[\"\",0]";
  $n++;
}
$oo.="] }] }";

$access_token=file_get_contents("/home/www/data/access_token");
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"https://sheets.googleapis.com/v4/spreadsheets/1vNh5kuo0xzQxOpPIiiUSCoG7csWNu1IFL4PPa4-t_Vo/values:batchUpdate");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_HTTPHEADER,Array("Content-Type: application/json","Authorization: Bearer ".$access_token));
curl_setopt($ch,CURLOPT_POSTFIELDS,$oo);
curl_exec($ch);
curl_close($ch);

?>
