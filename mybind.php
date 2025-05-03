<?php
include("dnslocal.php");

$ser=sprintf("%05d%04d",(int)(time()/86400),date("H")*60+date("i"));
$con=mysqli_connect($dns_dbip,$dns_user,$dns_passwd,$dns_db);
$query=mysqli_query($con,"select name,type,value from dns");
for(;;){
  $row=mysqli_fetch_assoc($query);
  if($row==null)break;
  $d=explode("@",$row["name"]);
  if(count($d)<2)continue;
  if($d[0]=="")$d[0]="@";
  if(!isset($n[$d[1]]))$n[$d[1]]=0;
  $x=explode(" ",$row["type"]);
  switch($x[0]){
    case "A": $v[$d[1]][$n[$d[1]]++]=$d[0]." IN A ".$row["value"]; break;
    case "AAAA": $v[$d[1]][$n[$d[1]]++]=$d[0]." IN AAAA ".$row["value"]; break;
    case "CNAME": $v[$d[1]][$n[$d[1]]++]=$d[0]." IN CNAME ".$row["value"]."."; break;
    case "TXT": $v[$d[1]][$n[$d[1]]++]=$d[0]." IN TXT \"".$row["value"]."\""; break;
    case "MX": $v[$d[1]][$n[$d[1]]++]=$d[0]." IN MX ".$x[1]." ".$row["value"]."."; break;
  }
}
mysqli_free_result($query);
$fp2=fopen("/etc/bind/named.conf.local","wt");
fprintf($fp2,"zone \".\" {type hint; file \"/dev/null\"; };\n");
foreach($n as $k => $a){
  fprintf($fp2,"zone \"%s\" {type master; file \"/etc/bind/gmdns/%s\"; };\n",$k,$k);
  $fp=fopen("/etc/bind/gmdns/".$k,"wt");
  fprintf($fp,"\$TTL $dns_ttl\n");
  fprintf($fp,"@ IN SOA dns1.mazzini.org. gianluca.mazzini.org. ($ser 3600 1800 86400 200)\n");
  fprintf($fp,"@ IN NS dns1.mazzini.org.\n");
  fprintf($fp,"@ IN NS dns2.mazzini.org.\n");
  for($i=0;$i<$a;$i++)fprintf($fp,"%s\n",$v[$k][$i]);
  fclose($fp);
}
fclose($fp2);
mysqli_close($con);
?>
