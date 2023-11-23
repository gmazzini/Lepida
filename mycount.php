<?php

$sock=socket_create(AF_INET,SOCK_DGRAM,0);
socket_bind($sock,"0.0.0.0",6666);
for(;;){
  socket_recvfrom($sock,$buf,1000,0,$remote_ip,$remote_port);
  $xx=explode(" ",$buf);
  $dd=$xx[10];
  if($dd[0]=="("){
    $rr=substr($dd,1,strlen($dd)-3);
    if($rr=="mysave" && isset($oo)){
      arsort($oo);
      $tt=(int)(time()/86400);
      $aa=bin2hex(random_bytes(5));
      $fp=fopen("/mybind/count/$tt.$aa","wt");
      foreach($oo as $k => $v)fprintf($fp,"%s,%d\n",$k,$v);
      fclose($fp);
      unset($oo);
    }
    else @$oo[$rr]++;
  }
}

?>
