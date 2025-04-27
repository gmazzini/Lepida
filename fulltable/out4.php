<?php

$o1=file_get_contents("/home/www/fulltable/ip4.txt");
eval('$ip4='.$o1.';');

uksort($ip4,"mycmp");
$fp=fopen("/home/www/fulltable/m4.txt","w");
foreach($ip4 as $k => $v)fprintf($fp,"%s,%d\n",$k,$v);
fclose($fp);

function mycmp($a,$b){
  $ma=explode(".",$a); $va=($ma[2])|($ma[1]<<8)|($ma[0]<<16);
  $mb=explode(".",$b); $vb=($mb[2])|($mb[1]<<8)|($mb[0]<<16);
  return $va-$vb;
}

?>
