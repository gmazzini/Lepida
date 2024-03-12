<?php
$fp=fopen("prenotazioni.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  @ $acc[$dd[0]][substr($dd[2],0,3)]++;
}
fclose($fp);

uksort($acc,"mydata");
foreach($acc as $k => $v){
  @ printf("%s,%d,%d\n",$k,$v["BPT"],$v["BP1"]);
}
