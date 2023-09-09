<?php
  function mydata($a,$b){
    $aa=substr($a,4,2).substr($a,2,2).substr($a,0,2);
    $bb=substr($b,4,2).substr($b,2,2).substr($b,0,2);
    return strcmp($aa,$bb);
  }

  $fp=fopen("r2.csv","r");
  for(;;){
    $aux=fgets($fp);
    if(feof($fp))break;
    $dd=explode(",",trim($aux));
    $rr=explode(":",$dd[3]);
    $oo=$rr[0]*60+$rr[1];
    @ $acc[$dd[1]][$dd[0]]+=$oo;
  }
  fclose($fp);

  $fp=fopen("r1.csv","r");
  for(;;){
    $aux=fgets($fp);
    if(feof($fp))break;
    $dd=explode(",",trim($aux));
    if($dd[2]>0)unset($acc[$dd[1]][$dd[0]]);
  }
  fclose($fp);

  ksort($acc);
  foreach($acc as $k => $v){
    printf("%s,%d\n",$k,count($v));
  }
?>
