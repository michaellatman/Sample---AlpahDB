<?php

/**
 * PeopleFetcher.php
 * Michael Ryan Latman
 * Copyright: 12/9/16
 */
class PeopleFetcher
{
    public static function fetchPeopleAssociations($db, $person){
        $associationQuery = "SELECT * FROM mlatman.involved_with JOIN a_person on ap_to = a_person.ap_id where ap_from = :q;";
        try{
            $sth = $db->prepare($associationQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $mappedValues = array();
            $mappedValues[":q"] = $person;
            $sth->execute($mappedValues);
            $personAssociations = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $personAssociations;
        }
        catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            return null;
        }
    }

    public static function fetchCompanyAssociations($db, $person){
        $associationQuery = "SELECT * FROM mlatman.p_works_with_c JOIN a_company on p_works_with_c.ac_id = a_company.ac_id where ap_id = :q;";
        try{
            $sth = $db->prepare($associationQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $mappedValues = array();
            $mappedValues[":q"] = $person;
            $sth->execute($mappedValues);
            $companyAssociations = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $companyAssociations;
        }
        catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            return null;
        }
    }

    public static function fetchSocialMedia($db, $person){
        $associationQuery = "SELECT * FROM mlatman.social_media where ap_id = :q;";
        try{
            $sth = $db->prepare($associationQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $mappedValues = array();
            $mappedValues[":q"] = $person;
            $sth->execute($mappedValues);
            $socialMedia = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $socialMedia;
        }
        catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            return null;
        }
    }

    public static function fetchProperty($db, $person){
        $associationQuery = "SELECT * FROM mlatman.a_property where ap_owner = :q;";
        try{
            $sth = $db->prepare($associationQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $mappedValues = array();
            $mappedValues[":q"] = $person;
            $sth->execute($mappedValues);
            $fetchedProperty = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $fetchedProperty;
        }
        catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            return null;
        }
    }

}