<?php
$fp=fopen("formazione","r");
for(;;){
  $aux=trim(fgets($fp));
  if(feof($fp))break;
  $act[$aux]=1;
}
fclose($fp);

$acc=array();
$fp=fopen("ore.csv","r");
for(;;){
  $aux=fgets($fp);
  if(feof($fp))break;
  if(str_contains($aux,"\""))continue;
  $dd=explode(",",trim($aux));
  if(!isset($act[$dd[2]]))continue;
  $rr=explode(":",$dd[3]);
  $oo=$rr[0]*60+$rr[1];
  @$acc[$dd[1]]+=$oo;
}
fclose($fp);
foreach($acc as $k => $v)printf("%s,%d\n",$k,$v);

?>
