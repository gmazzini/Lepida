<?php

$o1=file_get_contents("/home/www/fulltable/ip6.txt");
eval('$ip6='.$o1.';');

uksort($ip6,"mycmp");
$fp=fopen("/home/www/fulltable/m6.txt","w");
foreach($ip6 as $k => $v)fprintf($fp,"%s,%d\n",$k,$v);
fclose($fp);

function mycmp($a,$b){
  $ma=explode(":",$a);
  $mb=explode(":",$b);
  for($i=0;$i<6;$i++){
    if(isset($ma[$i]))$va=hexdec($ma[$i]); else $va=0;
    if(isset($mb[$i]))$vb=hexdec($mb[$i]); else $vb=0;
    if($va==$vb)continue;
    if($va>$vb)return 1;
    else return -1;
  }
  return 0;
}

?>
