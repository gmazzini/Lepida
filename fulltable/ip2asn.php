<?php

ini_set('memory_limit', '-1');
$in=file("m4.txt");
$i=0;
foreach($in as $buf){
  $l1=strpos($buf,"/");
  $l2=strpos($buf,",");
  $cidr=substr($buf,$l1+1,$l2-$l1-1);
  if($cidr>24)continue;
  $asn=substr($buf,$l2+1,-1);
  $aux=explode(".",$buf);
  $ip=$aux[2]|($aux[1]<<8)|($aux[0]<<16);
  $v[$i][0]=$ip;
  $v[$i][1]=24-$cidr;
  $v[$i][2]=$asn;
  $i++;
}

usort($v,"mycmp");
for($j=0;$j<$i;$j++){
  $ex=$v[$j][0]+(1<<$v[$j][1]);
  for($x=$v[$j][0];$x<$ex;$x++)$cc[$x]=$v[$j][2];
}

echo mys("137.204.20.30")."\n";
echo mys("188.210.239.1")."\n";
echo mys("17.33.44.55")."\n";
echo mys("8.8.8.8")."\n";


function mys($buf){
  global $cc;
  $aux=explode(".",$buf);
  $ip=$aux[2]|($aux[1]<<8)|($aux[0]<<16);
  return $cc[$ip];
}

function mycmp($a,$b){
  $va=$a[0]|($a[1]<<24);
  $vb=$b[0]|($b[1]<<24);
  return $vb-$va;
}

?>
