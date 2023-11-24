<?php

$tt=(int)(time()/86400);
exec("scp -P 3003 root@192.0.2.14:/mybind/count/$tt.* /mybind/count");
$dd="/mybind/count/";
$ff=glob($dd."$tt.*");
foreach($ff as $k => $v){
  $rr=explode("\n",file_get_contents($v));
  foreach($rr as $k2 => $v2){
    $aa=explode(",",trim($v2));
    @$oo[$aa[0]]+=$aa[1];
  }
}
arsort($oo);
$fp=fopen("/mybind/counted/$tt","wt");
  foreach($oo as $k => $v)if($v>=10)fprintf($fp,"%s,%d\n",$k,$v);
fclose($fp);

?>
