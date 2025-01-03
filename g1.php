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
$nv=0; $i=0;
foreach(explode("*",$q) as $v){
  if($i==0){
    $dd[$nv]=$v;
    $i=1;
  }
  else {
    if($v<$yfrom)$v=$yfrom;
    if($v>$yto)$v=$yto;
    $pp[$nv++]=$v;
    $i=0;
  }
}
array_multisort($dd,$pp);

header('Content-Type: image/png');
$ww=$zzfont*$zzsp+$nv*$zz;
$hh=$ww*9/16;
$image=imagecreatetruecolor($ww,$hh);
$backgroundColor=imagecolorallocate($image,255,255,255);
imagefill($image,0,0,$backgroundColor);

$aux=file_get_contents("festivi");
$festivi=explode("\n",$aux);
for($i=0;$i<$nv;$i++){
  $rr=0;
  $x=date("dmy",$dd[$i]*86400);
  foreach($festivi as $fes){
    $aux=trim($fes);
    if(strlen($aux)==4 && $aux==substr($x,0,4))$rr=8;
    else if($aux==$x)$rr=8;
  }
  if($rr==0)$rr=1+date("w",$dd[$i]*86400);
  switch($rr){
    case 1: case 2: case 3: case 4: case 5: $cc=imagecolorallocate($image,0,0,255); break;
    case 6: $cc=imagecolorallocate($image,255,165,0); break;
    case 7: $cc=imagecolorallocate($image,255,0,0); break;
    case 8: $cc=imagecolorallocate($image,255,0,255); break;
  }
  $vv=(int)($hh*($pp[$i]-$yfrom)/($yto-$yfrom));
  imagefilledrectangle($image,$zzfont*$zzsp+$i*$zz,$hh,$zzfont*$zzsp+$i*$zz+$zz/2,$hh-$vv,$cc);
}
$black=imagecolorallocate($image,0,0,0);
$font="./xb-arial.ttf";
for($y=$yfrom;$y<=$yto;$y+=$ystep){
  $vv=(int)($hh*($y-$yfrom)/($yto-$yfrom));
  imagettftext($image,$zzfont,0,0,$hh-$vv,$black,$font,$y);
}
for($i=0;$i<$nv;$i+=$xstep){
  $x=date("dmy",$dd[$i]*86400);
  imagettftext($image,$zzfont,90,$zzfont/2+$zzfont*$zzsp+$i*$zz,$hh,$black,$font,$x);
}

imagepng($image);
imagedestroy($image);
?>
