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
$tt=0;
foreach($acc as $k => $v){
  @ $t=$v["BPT"]+$v["BP1"]+$v["LB1"]+$v["LB2"]+$v["LD1"]+$v["PP4"];
  if($t>50){
    @ $vv["BPT"]+=$v["BPT"];
    @ $vv["BP1"]+=$v["BP1"];
    @ $vv["LB1"]+=$v["LB1"]; 
    @ $vv["LB2"]+=$v["LB2"];
    @ $vv["LD1"]+=$v["LD1"];
    @ $vv["PP4"]+=$v["PP4"];
    $tt++;
  }
  @ printf("%s,%d,%d,%d,%d,%d,%d\n",$k,$v["BPT"],$v["BP1"],$v["LB1"],$v["LB2"],$v["LD1"],$v["PP4"]);
}
printf("ave %4.1f,%4.1f,%4.1f,%4.1f,%4.1f,%4.1f\n",$vv["BPT"]/$tt,$vv["BP1"]/$tt,$vv["LB1"]/$tt,$vv["LB2"]/$tt,$vv["LD1"]/$tt,$vv["PP4"]/$tt);

?>
