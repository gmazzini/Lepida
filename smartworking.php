<?php
  function mydata($a,$b){
    $aa=substr($a,2,2).substr($a,0,2);
    $bb=substr($b,2,2).substr($b,0,2);
    return strcmp($aa,$bb);
  }

$fp=fopen("cf.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  $id[$dd[1]]=$dd[0];
  $cf[$dd[0]]=$dd[1];
}
fclose($fp);

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
  if($mm==0&&$nn==0)$acc[$dd[1]][$dd[0]]=$oo;
}
fclose($fp);

$fp=fopen("allocazioni.csv","r");
for(;;){
  $aux=fgets($fp);   
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  if(isset($id[$dd[11]]) && $dd[4]!="DYN")unset($acc[$id[$dd[11]]]);
}
fclose($fp);

foreach($acc as $k1 => $v){
  foreach($v as $k2 => $v2){ 
    $ww=substr($k2,2,4); 
    @ $tt[$ww]+=$v2;
  }
}

$fp=fopen("swo.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  if($dd[2]>0)unset($acc[$dd[1]][$dd[0]]);
}
fclose($fp);

foreach($acc as $k1 => $v){
  foreach($v as $k2 => $v2){
    $ww=substr($k2,2,4);
    @ $qq[$ww]+=$v2;
  }
}

uksort($tt,"mydata");
foreach($tt as $k => $v){
  printf("%s,%4.1f%%\n",$k,(1-$qq[$k]/$tt[$k])*100);
}

?>
