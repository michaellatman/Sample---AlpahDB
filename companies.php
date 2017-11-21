<?php
/**
 * index.php
 * Michael Ryan Latman
 * Date: 12/7/16
 */

require_once("loader.php");
$file = basename($_SERVER['PHP_SELF']); // your file name
$last_modified_time = filemtime($file);
$etag = md5_file($file);

header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
header("Etag: $etag");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$results = array();



try{
    $sth = $db->prepare("SELECT * FROM mlatman.a_company WHERE name LIKE :q OR incorporated_in LIKE :q; ", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $mappedValues = array();
    $mappedValues[":q"] = '%'.$_GET['query'].'%';
    if($_GET['query'] == null){
        $mappedValues[":q"] = '%%';
    }
    $sth->execute($mappedValues);
    $results = $sth->fetchAll(PDO::FETCH_ASSOC);
}
catch( PDOException $Exception ) {
    // Note The Typecast To An Integer!
    print("Something went wrong... Let Michael know so he can fix it");
    die(500);
}




activateMenuItem(1);
echo $twig->render('company_search.html', array('menu' => $menuItems, 'title'=>"AlphaDog Companies", 'pagetitle'=>'Companies', 'subtitle'=>"The Corporations Pulling the Strings",'query'=>$_GET['query'], 'results'=>$results));


$db = null;

// Close the MySQL connection