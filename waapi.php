<?php

include "setup.php";

$json=file_get_contents('php://input');
$action=json_decode($json,true);
$zz=$action["data"]["message"];
$aux=explode("@",$zz["from"]);
$from=$aux[0];

if(in_array($from,$friends) && $zz["type"]=="chat"){
  $aux=$zz["body"];
  if(isset($alias[$aux]))$cc=explode("\n",$alias[$aux]);
  else $cc=explode("\n",$aux);
  
  foreach($cc as $msg){
    $l=strpos($msg," ");
    if($l===false)$l=strlen($msg);
    $out="```".date("--- Y-m-d H:i:s")." $msg\n";
    
    if($l<4 && substr($msg,0,$l)=="/cc"){
      $in=substr($msg,$l+1);
      $server_ip="master.corteconnessa.it";
      $server_port=55556;
      $socket=socket_create(AF_INET,SOCK_DGRAM,SOL_UDP);
      socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>10,"usec"=>0));
      socket_sendto($socket,$in,strlen($in),0,$server_ip,$server_port);
      for(;;){
        $ret=socket_recvfrom($socket,$buf,2000,0,$remote_ip,$remote_port);
        if($ret===false)break;
        $a=strpos($buf,"<next>");
        if($a!==false)echo substr($buf,0,$a).substr($buf,$a+6);
        $a=strpos($buf,"<end>");
        if($a!==false){
          echo substr($buf,0,$a);
          break;
        }
      }
      socket_close($socket);
    }
    
    if($l<4 && substr($msg,0,$l)=="/so"){
      $in=substr($msg,$l+1);
      $out.=strip_tags(file_get_contents("http://home.mazzini.org:3333/$so_pwd/$in"));
    }
    
    if($l<6 && substr($msg,0,$l)=="/peso"){
      $in=substr($msg,$l+1);
      file_get_contents("https://restdati.lepida.it/pesoGM.php?peso=$in&access=$peso_access");
      $out.="Peso set to $in\n";
    }
    
    if($l<9 && substr($msg,0,$l)=="/weather"){
      $in=substr($msg,$l+1);
      if($in==NULL)$in="bologna,it";
      $where=urlencode($in);
      $x=json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=$where&appid=$openweather_api&units=metric"),true);
      $out.=sprintf("%s,%s\n",$x["name"],$x["sys"]["country"]);
      $out.=$x["weather"][0]["description"]."\n";
      $out.="Temp:       ".sprintf("%7.1f\n",$x["main"]["temp"]);
      $out.="Feel:       ".sprintf("%7.1f\n",$x["main"]["feels_like"]);
      $out.="Pressure:   ".sprintf("%5d\n",$x["main"]["pressure"]);
      $out.="Humidity:   ".sprintf("%5d\n",$x["main"]["humidity"]);
      $out.="Visibility: ".sprintf("%5d\n",$x["visibility"]);
      $out.="Wind:       ".sprintf("%7.1f\n",$x["wind"]["speed"]);
    }
    
    if($l<10 && substr($msg,0,$l)=="/forecast"){
      $in=substr($msg,$l+1);
      if($in==NULL)$in="bologna,it";
      $where=urlencode($in);
      $x=json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/forecast?q=$where&appid=$openweather_api&units=metric"),true);
      $out.=sprintf("%s,%s\n",$x["city"]["name"],$x["city"]["country"]);
      foreach($x["list"] as $v){
        $out.=substr($v["dt_txt"],0,16);
        $out.=" / ".sprintf("%4.1f",$v["main"]["temp"]);
        $out.=" / ".$v["weather"][0]["main"];
        $out.="\n";
      }
    }
    
    if($l<14 && substr($msg,0,$l)=="/airpollution"){
      $in=substr($msg,$l+1);
      if($in==NULL)$in="bologna,it";
      $where=urlencode($in);
      $x=json_decode(file_get_contents("http://api.openweathermap.org/geo/1.0/direct?q=$where&limit=1&appid=$openweather_api"),true);
      $xx=$x[0];
      $lat=$xx["lat"];
      $lon=$xx["lon"];
      $out.=sprintf("%s,%s\n",$xx["name"],$xx["country"]);
      $x=json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/air_pollution?lat=$lat&lon=$lon&appid=$openweather_api"),true);
      $xx=$x["list"][0]["components"];
      $ei=1;
      $out.=sprintf("o3:    %6.1f",$xx["o3"]);
      $o3=myse(array(50,100,130,240,380),$xx["o3"]); $ei=max($ei,$o3);
      $out.=sprintf(" AIQ=%d\n",$o3);
      $out.=sprintf("no2:   %6.1f",$xx["no2"]);
      $no2=myse(array(40,90,120,230,340),$xx["no2"]); $ei=max($ei,$no2);
      $out.=sprintf(" AIQ=%d\n",$no2);
      $out.=sprintf("so2:   %6.1f",$xx["so2"]);
      $so2=myse(array(100,200,350,500,750),$xx["so2"]); $ei=max($ei,$so2);
      $out.=sprintf(" AIQ=%d\n",$so2);
      $out.=sprintf("pm10:  %6.1f",$xx["pm10"]);
      $pm10=myse(array(20,40,50,100,150),$xx["pm10"]); $ei=max($ei,$pm10);
      $out.=sprintf(" AIQ=%d\n",$pm10);
      $out.=sprintf("pm2_5: %6.1f",$xx["pm2_5"]);
      $pm2_5=myse(array(10,20,25,50,75),$xx["pm2_5"]); $ei=max($ei,$pm2_5);
      $out.=sprintf(" AIQ=%d\n",$pm2_5);
      $out.=sprintf("AIQ:      %d\n",$ei);
      $out.=sprintf("co:    %6.1f\n",$xx["co"]);
      $out.=sprintf("no:    %6.1f\n",$xx["no"]);
      $out.=sprintf("nh3:   %6.1f\n",$xx["nh3"]);
    }
    
    $out.="```";
    mysend($from,$out);
  }
}

// file_put_contents("/home/www/waapi/out.txt", print_r($action,true));

function mysend($num,$msg){
  global $waapi_apiID,$waapi_channelID;
  $headers[]="accept: application/json";
  $headers[]="authorization: Bearer $waapi_apiID";
  $headers[]="content-type: application/json";
  $data["chatId"]=$num;
  $data["message"]=$msg;
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_URL,"https://waapi.app/api/v1/instances/$waapi_channelID/client/action/send-message");
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,0);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
  curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
  curl_setopt($ch,CURLOPT_POST,1);
  curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
  echo curl_exec($ch);
  curl_close($ch);
}

function myse($arr,$val){
  for($i=0;$i<5;$i++)if($val<$arr[$i])break;
  return $i+1;
}

?>
