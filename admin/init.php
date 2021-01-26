<?php
//routes
$tpl = "includes/templates/"; // template Directory
$langPath = "includes/languages/"; // Languase Directory
$func = "includes/functions/"; // Function Directory
$js  = "layout/js/"; // js Directory
$css = "layout/css/"; // Css Directory

//include important Files
include 'connect.php';
include $func.'functions.php';
include $langPath."en.php";
include $tpl."header.php";
// include Navbar on All pages Excepct The One with $noNavbar variable
if(!isset($noNavbar)){
    include $tpl."navbar.php";
}

