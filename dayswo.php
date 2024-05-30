<?php

$fp=fopen("ore.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  $rr=explode(":",$dd[3]);
  $oo=$rr[0]*60+$rr[1];
  $rr=explode(":",$dd[4]);
  $mm=$rr[0]*60+$rr[1];
  $rr=explode(":",$dd[5]);
  $nn=$rr[0]*60+$rr[1];
  if($mm==0 && $nn==0)@$acc[$dd[1]][$dd[0]]+=$oo;
}
fclose($fp);

$swo=0;
$fp=fopen("swo.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  if($dd[2]>0 && $acc[$dd[1]][$dd[0]]>0)$swo++;
}
fclose($fp);

echo "$swo\n";

?>
