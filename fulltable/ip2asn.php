<?php

$in=file("m4.txt");

print_r($in);
exit(1);


$fp=fopen("m4.txt","r");
for(;;){
  if(feof($fp))break;
  $buf=fgets($fp);
  $l1=strpos($buf,"/");
  $l2=strpos($buf,",");
  $cidr=substr($buf,$l1+1,$l2-$l1-1);
  $asn=substr($buf,$l2+1,-1);
  $aux=explode(".",$buf);
  $ip=$buf[2] | ($buf[1]<<8) | ($buf[0]<<16);
  
  
  @$cc[$asn]+=$ll[$b];
}

asort($cc);
print_r($cc);

fclose($fp);

?>
