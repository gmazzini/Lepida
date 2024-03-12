<?php

function mydata($a,$b){
  $aa=substr($a,4,2).substr($a,2,2).substr($a,0,2);
  $bb=substr($b,4,2).substr($b,2,2).substr($b,0,2);
  return strcmp($aa,$bb);
}

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
  @ printf("%s,%d,%d,%d,%d,%d,%d\n",$k,$v["BPT"],$v["BP1"],$v["LB1"],$v["LB2"],$v["LD1"],$v["PP4"]);
}

?>
