<?php
// example of usage =IMAGE("https://energy.chaos.cc/g1.php?p=90*112*5*10*16*50*2.5*"&RAND()&"&q="&TEXTJOIN("*",FALSE,{A2:A,D2:D}),1)

$p=$_GET["p"];
$aux=explode("*",$p);
$yfrom=$aux[0];
$yto=$aux[1];
$ystep=$aux[2];
$xstep=$aux[3];
$zz=$aux[4];
$zzfont=$aux[5];
$zzsp=$aux[6];
$seq=$aux[7];
$q=$_GET["q"];
$i=0;
foreach(explode("*",$q) as $v){
  if($i==0){
    $k=$v;
    $i=1;
  }
  else {
    if(abs($v)>0.5){
      if($v<$yfrom)$v=$yfrom;
      if($v>$yto)$v=$yto;
      $kv[$k]=$v;
    }
    $i=0;
  }
}
ksort($kv);
$ok=array_key_first($kv);
foreach($kv as $k => $v){
  if($k-$ok>$xstep)for($i=$ok+1;$i<$ok+$xstep)$kv[$i]=0;
}
ksort($kv);
                       
$nv=count($kv);
header('Content-Type: image/png');
$ww=$zzfont*$zzsp+$nv*$zz;
$hh=$ww*9/16;
$image=imagecreatetruecolor($ww,$hh);
$backgroundColor=imagecolorallocate($image,255,255,255);
imagefill($image,0,0,$backgroundColor);

$aux=file_get_contents("festivi");
$festivi=explode("\n",$aux);
$i=0;
foreach($kv as $k => $v){
  $rr=0;
  $x=date("dmy",$k*86400);
  foreach($festivi as $fes){
    $aux=trim($fes);
    if(strlen($aux)==4 && $aux==substr($x,0,4))$rr=8;
    else if($aux==$x)$rr=8;
  }
  if($rr==0)$rr=date("w",$k*86400);
  switch($rr){
    case 1: case 2: case 3: case 4: case 5: $cc=imagecolorallocate($image,255,165,0); break;
    case 6: $cc=imagecolorallocate($image,255,0,0); break;
    case 0: $cc=imagecolorallocate($image,0,0,255); break;
    case 8: $cc=imagecolorallocate($image,0,255,0); break;
  }
  $vv=(int)($hh*($v-$yfrom)/($yto-$yfrom));
  imagefilledrectangle($image,$zzfont*$zzsp+$i*$zz,$hh,$zzfont*$zzsp+$i*$zz+$zz/2,$hh-$vv,$cc);
  $i++;
}
$black=imagecolorallocate($image,0,0,0);
$font="./xb-arial.ttf";
for($y=$yfrom;$y<=$yto;$y+=$ystep){
  $vv=(int)($hh*($y-$yfrom)/($yto-$yfrom));
  imagettftext($image,$zzfont,0,0,$hh-$vv,$black,$font,$y);
}
$kk=array_keys($kv);
for($i=0;$i<$nv;$i+=$xstep){
  $x=date("dmy",$kk[$i]*86400);
  imagettftext($image,$zzfont,90,$zzfont/2+$zzfont*$zzsp+$i*$zz,$hh,$black,$font,$x);
}

imagepng($image);
imagedestroy($image);
?>
