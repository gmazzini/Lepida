<?php
include "googleset.php";

$googleOauthURL="https://accounts.google.com/o/oauth2/auth?"
."scope=".urlencode($scope)
."&access_type=offline"
."&response_type=code"
."&redirect_uri=".$redirect_uri
."&client_id=".$client_id;

header("Location: $googleOauthURL"); 
?>
