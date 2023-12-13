<?php

unlink("/dev/log");
$sock=socket_create(AF_UNIX,SOCK_DGRAM,0);
socket_bind($sock,"/dev/log");
for(;;){
  socket_recvfrom($sock,$buf,1000,0,$remote_ip,$remote_port);
  $xx=preg_split("/ +/",$buf);
  @$dd=$xx[9];
  @$vv=$xx[3];
  if(@substr($vv,0,5)=="named" && substr($xx[0],0,5)=="<134>" && @$dd[0]=="("){
    $ff=explode("#",$xx[8]);
    $ip=$ff[0];
    $rr=substr($dd,1,strlen($dd)-3);
    if($rr=="mysave" && isset($oo)){
      arsort($oo);
      $tt=(int)(time()/86400);
      $aa=bin2hex(random_bytes(5));
      $fp=fopen("/mybind/count/$tt.$aa","wt");
      foreach($oo as $k => $v)if(count($poo[$k])>=3)fprintf($fp,"%s,%d\n",$k,$v);
      fclose($fp);
      unset($oo);
      unset($poo);
    }
    else {
      @$oo[$rr]++;
      @$poo[$rr][ip2long($ip)]++;
    }
  }
}

?>
