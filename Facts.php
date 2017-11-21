<?php
/**
 * Facts.php
 * Michael Ryan Latman
 * Copyright: 12/8/16
 */

class Facts {
    public $factArray = array();
    function addFact($name, $value) {
        $this->factArray[] = array("name"=>$name, "value"=>$value);
    }

    function getFact($name){
        foreach($this->factArray as $fact){
            if($fact["name"] == $name){
                return $fact["value"];
            }
        }
        return null;
    }

    static function getFactsAboutPerson($person) {
        $facts = new Facts();
        $facts->addFact("Full Name", $person["first_name"].' '.$person["m_initial"].' '.$person["last_name"]);
        $facts->addFact("National Rank", $person["national_rank"]);
        $facts->addFact("Local Rank", $person["local_rank"]);
        return $facts;
    }

    static function getFactsAboutCompany($company) {
        $facts = new Facts();
        $facts->addFact("Name", $company["name"]);
        $facts->addFact("Incorporated In", $company["incorporated_in"]);
        $facts->addFact("National Rank", $company["national_rank"]);
        $facts->addFact("Local Rank", $company["local_rank"]);
        return $facts;
    }


}
