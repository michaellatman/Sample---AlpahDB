<?php
/**
 * loader.php
 * Michael Ryan Latman
 * Copyright: 12/7/16
 */


include("vendor/autoload.php");


$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    //   'cache' => 'cached_views',
));

$dsn = "mysql:host=....";
$username = 'USERNAME';
$password = 'PASSWORD';
$db;
try {
    // Create connection to MySQL
    $db = new PDO($dsn, $username, $password);
}
catch( PDOException $Exception ) {
    // Note The Typecast To An Integer!
    print("Something went wrong... Let Michael know so he can fix it");
    die(500);
}

$menuItems = array("items"=>array(
    array("name"=>"People", "active"=>false, "url"=>"index.php"),
    array("name"=>"Companies", "active"=>false, "url"=>"companies.php")));

function activateMenuItem($index){
    global $menuItems;

    $menuItems["items"][$index]["active"] = true;
    $menuItems["active"] = $menuItems["items"][$index];
}