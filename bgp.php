<?php
declare(ticks=1);
$ip=array();

$contextOptions=array(
  'ssl' => array(
    "verify_peer"=>false,
    "verify_peer_name"=>false
  )
);
$context = stream_context_create($contextOptions);

$ss="rrc00";
$data = '{"type": "ris_subscribe", "data": {"host": "'.$ss.'", "moreSpecific": "true" }}';
$host = "$ss.ripe.net";
$head="GET /v1/ws/?client=gm1 HTTP/1.1\r\n".
  "Host: rrc14.ripe.net\r\n".
  "Accept: */*\r\n".
  "Connection: Upgrade\r\n".
  "Upgrade: websocket\r\n".
  "Sec-WebSocket-Version: 13\r\n".
  "Sec-WebSocket-Key: dGhlIHNhbXBsZSBub25jZQ==\r\n".
  "\r\n";

pcntl_signal(SIGUSR1,"myout");
$fp=fsockopen("ssl://ris-live.ripe.net",443);
fwrite($fp,$head);
$buf=fread($fp,4096);
echo $buf;
mywrite($fp,$data,true);

for($i=0;;){
  $m1=json_decode(myread($fp));

  @$aux=$m1->{"data"}->{"path"};
  @$asn=end($aux);
  @$aux=$m1->{"data"}->{"announcements"};
  @$pre=$aux[0]->{"prefixes"};

  if(isset($pre)){
    foreach($pre as $v)if(strpos($v,":")===false){
      $ip[$v]=$asn;
      $i++;
    }
  }
}

function myread($fp){
  $data="";
  do {
    $header=fread($fp,2);
    $opcode=ord($header[0]) & 0x0F;
    $final=ord($header[0]) & 0x80;
    $masked=ord($header[1]) & 0x80;
    $payload_len=ord($header[1]) & 0x7F;
    $ext_len=0;
    if($payload_len >= 0x7E){
      $ext_len=2;
      if($payload_len==0x7F)$ext_len=8;
      $header=fread($fp,$ext_len);
      $payload_len=0;
      for($i=0;$i<$ext_len;$i++)$payload_len+=ord($header[$i]) << ($ext_len - $i - 1) * 8;
    }
    if($masked)$mask=fread($fp,4);
    $frame_data='';
    while($payload_len>0){
      $frame=fread($fp,$payload_len);
      $payload_len-=strlen($frame);
      $frame_data.=$frame;
    }
    if($opcode==9){
      fwrite($fp,chr(0x8A).chr(0x80).pack("N",rand(1,0x7FFFFFFF)));
      continue;
    } elseif($opcode==8){
      fclose($fp);
    } elseif($opcode<3){
      $data_len=strlen($frame_data);
      if($masked)for($i=0;$i<$data_len;$i++)$data.=$frame_data[$i] ^ $mask[$i % 4];
      else $data.=$frame_data;
    } else continue;
  }while(!$final);
  return $data;
}

function mywrite($fp,$data,$final){
  $header=chr(($final ? 0x80 : 0) | 0x01);
  if(strlen($data)<126)$header.=chr(0x80 | strlen($data));
  elseif(strlen($data)<0xFFFF)$header.=chr(0x80 | 126).pack("n",strlen($data));
  else $header.=chr(0x80 | 127).pack("N",0).pack("N",strlen($data));
  $mask=pack("N",rand(1,0x7FFFFFFF));
  $header.=$mask;
  for($i=0;$i<strlen($data);$i++)$data[$i]=chr(ord($data[$i]) ^ ord($mask[$i % 4]));
  fwrite($fp,$header.$data);
}

function myout($sig){
  global $ip;
  $vv=$ip;
  uksort($vv,"mycmp");
  $fp=fopen("/home/www/fulltable.mazzini.org/m1.txt","w");
  foreach($vv as $k => $v)fprintf($fp,"%s,%d\n",$k,$v);
  fclose($fp);
}

function mycmp($a,$b){
  $ma=explode(".",$a); $va=($ma[2])|($ma[1]<<8)|($ma[0]<<16);
  $mb=explode(".",$b); $vb=($mb[2])|($mb[1]<<8)|($mb[0]<<16);
  return $va-$vb;
}

?>
