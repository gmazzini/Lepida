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
print_r($lines);
foreach($lines as $aux){
  if(str_contains($aux,"\""))continue;
  $dd=explode(",",trim($aux));
  if(!isset($dd[2]))continue;
  if(!isset($act[$dd[2]]))continue;
  $rr=explode(":",$dd[3]);
  $oo=$rr[0]*60+$rr[1];
  @$acc[$dd[1]]+=$oo;
}
foreach($acc as $k => $v)printf("%s,%d\n",$k,$v);

?>
