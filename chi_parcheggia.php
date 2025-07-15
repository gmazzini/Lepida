<?php

$fp=fopen("park.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  @ $acc[$dd[1]]++;
}
fclose($fp);

ksort($acc);
foreach($acc as $k => $v){
  @ printf("%s,%d\n",$k,$v);
}

?>
