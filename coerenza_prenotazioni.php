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
  if($mm==0&&$nn==0)$acc[$dd[1]][$dd[0]]=$oo;
}
fclose($fp);

$fp=fopen("swo.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  if($dd[2]>0)unset($acc[$dd[1]][$dd[0]]);
}
fclose($fp);

$fp=fopen("prenotazioni.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  unset($acc[$dd[1]][$dd[0]]);
}
fclose($fp);

$fp=fopen("cf.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  $id[$dd[1]]=$dd[0];
  $cf[$dd[0]]=$dd[1];
}
fclose($fp);

$fp=fopen("allocazioni.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  $dd=explode(",",trim($aux));
  if(isset($id[$dd[11]])){
    if($dd[4]!="DYN")unset($acc[$id[$dd[11]]]);
  }
  $a1[$dd[11]]=$dd[6];
  $a2[$dd[11]]=$dd[7];
}
fclose($fp);

foreach($acc as $k => $v){
  $ll=count($v);
  $qq[$k]=$ll;
}

arsort($qq);
foreach($qq as $k => $v){
  @$who=$cf[$k];
  if($who!="")printf("%s,%d,%s,%s,%s\n",$k,$v,$who,@$a1[$who],@$a2[$who]);
}

?>
