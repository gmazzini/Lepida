<?php

for($i=7;$i<=25;$i++)$ll[$i]=1<<(32-$i);

$fp=fopen("m4.txt","r");
for(;;){
  if(feof($fp))break;
  $buf=fgets($fp);
  $l1=strpos($buf,"/");
  $l2=strpos($buf,",");
  $b=substr($buf,$l1+1,$l2-$l1-1);
  $asn=substr($buf,$l2+1,-1);
  @$cc[$asn]+=$ll[$b];
}

asort($cc);
print_r($cc);

fclose($fp);

?>
