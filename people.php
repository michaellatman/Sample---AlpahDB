<?php
/**
 * index.php
 * Michael Ryan Latman
 * Date: 12/7/16
 */

$file = basename($_SERVER['PHP_SELF']); // your file name
$last_modified_time = filemtime($file);
$etag = md5_file($file);

header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
header("Etag: $etag");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once("loader.php");
require_once("Facts.php");
require_once("PeopleFetcher.php");




$rows = array();


$foundPerson = array();



try{
    $sth = $db->prepare("SELECT * FROM mlatman.a_person WHERE ap_id = :q; ", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $mappedValues = array();
    $mappedValues[":q"] = $_GET['ap_id'];
    $sth->execute($mappedValues);
    $foundPerson = $sth->fetchAll(PDO::FETCH_ASSOC);
}
catch( PDOException $Exception ) {
    // Note The Typecast To An Integer!
    print("Something went wrong... Let Michael know so he can fix it");
    die(500);
}

if($foundPerson[0] != null) {

    $facts = Facts::getFactsAboutPerson($foundPerson[0]);

    activateMenuItem(0);

    // We should get this person's associations now
    $personAssociations = PeopleFetcher::fetchPeopleAssociations($db, $_GET["ap_id"]);
    $companyAssociations = PeopleFetcher::fetchCompanyAssociations($db, $_GET["ap_id"]);
    $socialMedia = PeopleFetcher::fetchSocialMedia($db, $_GET["ap_id"]);
    $property = PeopleFetcher::fetchProperty($db, $_GET["ap_id"]);
    echo $twig->render('profile.html', array(
        'menu' => $menuItems, 'profile_facts' => $facts->factArray,
        'title' => "AlphaDog Companies", 'pagetitle' => $facts->getFact("Full Name"),
        'associations'=>array("people"=>$personAssociations, "companies"=>$companyAssociations),
        'social_media'=>$socialMedia,
        'property' => $property,
        'profile_photo_url' => $foundPerson[0]["profile_photo_url"]
    ));

}
else{
    echo $twig->render('404.html', array('menu' => $menuItems, 'profile_facts' => $facts->factArray, 'title' => "AlphaDog Companies", 'pagetitle' => "404"));
}

$db = null;

// Close the MySQL connection