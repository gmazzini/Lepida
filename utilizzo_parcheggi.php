<?php
function mydata($a,$b){
  $aa=substr($a,4,2).substr($a,2,2).substr($a,0,2);
  $bb=substr($b,4,2).substr($b,2,2).substr($b,0,2);
  return strcmp($aa,$bb);
}

$fp=fopen("park.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  @ $acc[$dd[0]][substr($dd[2],0,1)]++;
}
fclose($fp);

uksort($acc,"mydata");
foreach($acc as $k => $v){
  @ printf("%s,%d,%d\n",$k,$v["B"],$v["L"]);
}

?>
