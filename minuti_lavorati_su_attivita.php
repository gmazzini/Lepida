<?php
function mydata($a,$b){
  $aa=substr($a,2,2).substr($a,0,2);
  $bb=substr($b,2,2).substr($b,0,2);   
  return strcmp($aa,$bb);
}

$fp=fopen("attivita.csv","r");
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
  $rr=explode(":",$dd[4]);
  $vv=$rr[0]*60+$rr[1];
  $rr=explode(":",$dd[5]);
  $ss=$rr[0]*60+$rr[1];   
  $ww=substr($dd[0],2,4);
  @$acc[$ww]["A"]+=$oo;
  @$acc[$ww]["V"]+=$vv;
  @$acc[$ww]["S"]+=$ss;
}
fclose($fp);

uksort($acc,"mydata");
$n=0;
foreach($acc as $k => $v){
  printf("%s,%d,%d,%d,%5.3f%%,%5.3f%%\n",$k,$v["A"],$v["V"],$v["S"],$v["V"]/$v["A"]*100,$v["S"]/$v["A"]*100);
    $n++;
}
if($n==0)printf("xx,0,0,0,0.000,0.000\n");

?>
