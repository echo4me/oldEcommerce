<?php

$sessionUser = '';
if(isset($_SESSION['user'])){
    $sessionUser = $_SESSION['user'];
}

//routes
$tpl = "includes/templates/"; // template Directory
$langPath = "includes/languages/"; // Languase Directory
$func = "includes/functions/"; // Function Directory
$js  = "layout/js/"; // js Directory
$css = "layout/css/"; // Css Directory

//include important Files
include 'admin/connect.php';
include $func.'functions.php';
include $langPath."en.php";
include $tpl."header.php";


