<?php
$do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://google.com/search?q=koko");
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$re = curl_exec($ch);
curl_close($ch);
// Redirect with Get Request

if($do == 'manage')
{
    //echo "Welcome u are in MANAGEMENT Page";
}elseif($do == 'add')
{
    echo "u are in Add Page";
}elseif($do == 'insert')
{
    echo "u are in Insert Page";
}else
{
    echo "error 404";
}

