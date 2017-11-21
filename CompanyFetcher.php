<?php

/**
 * PeopleFetcher.php
 * Michael Ryan Latman
 * Copyright: 12/9/16
 */
class CompanyFetcher
{
    public static function fetchPeopleAssociations($db, $company){
        $associationQuery = "SELECT * FROM mlatman.p_works_with_c JOIN a_person on p_works_with_c.ap_id = a_person.ap_id where ac_id = :q;";
        try{
            $sth = $db->prepare($associationQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $mappedValues = array();
            $mappedValues[":q"] = $company;
            $sth->execute($mappedValues);
            $companyAssociations = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $companyAssociations;
        }
        catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            return null;
        }
    }

    public static function fetchRelatedCompanies($db, $company){
        $associationQuery = "SELECT *, count(*) as rel FROM mlatman.p_works_with_c JOIN mlatman.a_company on p_works_with_c.ac_id = a_company.ac_id WHERE ap_id IN (SELECT distinct(a_person.ap_id) FROM mlatman.p_works_with_c JOIN a_person on p_works_with_c.ap_id = a_person.ap_id where  ac_id = :q) AND a_company.ac_id != :q GROUP BY a_company.ac_id ORDER BY rel DESC;";
        try{
            $sth = $db->prepare($associationQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $mappedValues = array();
            $mappedValues[":q"] = $company;
            $sth->execute($mappedValues);
            $personAssociations = $sth->fetchAll(PDO::FETCH_ASSOC);
            foreach ($personAssociations as $key => $value)
                $personAssociations[$key]["description"] = $personAssociations[$key]["rel"].' Related AlphaDog(s) also worked here';

            return $personAssociations;
        }
        catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            return null;
        }
    }



    public static function fetchSocialMedia($db, $company){
        $associationQuery = "SELECT * FROM mlatman.social_media where ac_id = :q;";
        try{
            $sth = $db->prepare($associationQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $mappedValues = array();
            $mappedValues[":q"] = $company;
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
        $associationQuery = "SELECT * FROM mlatman.a_property where ac_owner = :q;";
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