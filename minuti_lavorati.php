<?php
  function mydata($a,$b){
    $aa=substr($a,2,2).substr($a,0,2);
    $bb=substr($b,2,2).substr($b,0,2);
    return strcmp($aa,$bb);
  }

  $fp=fopen("r1.csv","r");
  for(;;){
    $aux=fgets($fp);
    if(feof($fp))break;
    $dd=explode(",",trim($aux));
    if($dd[2]=="1")$swo[$dd[1]][$dd[0]]=1;
  }
  fclose($fp);

  $fp=fopen("r2.csv","r");
  for(;;){
    $aux=fgets($fp);
    if(feof($fp))break;
    $dd=explode(",",trim($aux));
    $rr=explode(":",$dd[3]);
    $oo=$rr[0]*60+$rr[1];
    $ww=substr($dd[0],2,4);
    $aa=substr($dd[2],0,2);
    if(isset($swo[$dd[1]][$dd[0]]))@$acc[$ww]["S"]+=$oo;
    if(($aa=="91"||$aa=="23"||$aa=="45")&&!isset($swo[$dd[1]][$dd[0]]))@$acc[$ww]["E"]+=$oo;
    @$acc[$ww]["A"]+=$oo;
  }
  fclose($fp);

  uksort($acc,"mydata");
  foreach($acc as $k => $v){
    printf("%s,%d,%d,%d,%2.0f%%\n",$k,$v["A"],$v["E"],$v["S"],$v["S"]/($v["A"]-$v["E"])*100);
  }
?>
