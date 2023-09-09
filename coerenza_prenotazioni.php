<?php
  $fp=fopen("r2.csv","r");
  for(;;){
    $aux=fgets($fp);
    if(feof($fp))break;
    $dd=explode(",",$aux);
    $acc[$dd[1]][$dd[0]]=1;
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

  $fp=fopen("r3.csv","r");
  for(;;){
    $aux=fgets($fp);
    if(feof($fp))break;
    $dd=explode(",",trim($aux));
    unset($acc[$dd[1]][$dd[0]]);
  }
  fclose($fp);

  $fp=fopen("r5.csv","r");
  for(;;){
    $aux=fgets($fp);
    if(feof($fp))break;
    $dd=explode(",",trim($aux));
    $id[$dd[1]]=$dd[0];
  }
  fclose($fp);

  $fp=fopen("r4.csv","r");
  for(;;){
    $aux=fgets($fp);
    if(feof($fp))break;
    $dd=explode(",",trim($aux));
    if(isset($id[$dd[11]]) && $dd[4]!="DYN")unset($acc[$id[$dd[11]]]);
  }
  fclose($fp);

  ksort($acc);
  foreach($acc as $k => $v){
    $ll=count($v);
    if($ll>10)printf("%s,%d\n",$k,$ll);
  }

?>
