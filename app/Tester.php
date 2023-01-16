<?php
namespace App;

class Tester {
    
    private function laatTestNaamZien($test_naam) {
        echo "<br> ". $test_naam . " : ";
    }
    
    private function laatTestResultaatZien($resultaat, $verwachting) {
        echo $resultaat === $verwachting ? "Test is gelukt" : "Test is niet gelukt!";
    }

// wat gebeurt er als je een relatie toevoegt van een type die bestaat
    public function testInsertValidRelationship($db) {
        $this->laatTestNaamZien(__METHOD__);
        $resultaat = $db->insertRelationship(2, 43, 2);
        $verwachting = true;
        $this->laatTestResultaatZien($resultaat, $verwachting);
    }

// wat gebeurt er als je een relatie toevoegt van een type die NIET bestaat
    public function testInsertInvalidRelationship($db) {
        $this->laatTestNaamZien(__METHOD__);
        $resultaat = $db->insertRelationship(21298, 43, 2);
        $verwachting = false;
        $this->laatTestResultaatZien($resultaat, $verwachting);
    }

    // schrijf nog meer testjes!
    public function testAddPersonWithoutDeathday($db){
        $this->laatTestNaamZien(__METHOD__);
        $resultaat = $db->insertPerson([
            "f_name" => "Cornelis Jacobus Maria",
            "l_name" => "Berkhout",
            "gender" => "m",
            "birthday" => "20-12-1944",
            "user_id" => 70,
        ]);
        $verwachting = true;
        $this->laatTestResultaatZien($resultaat,$verwachting);
    }

    public function testAddPersonWithDeathday($db){
        this->laatTestNaamZien(__METHOD__);
        $resultaat = $db->insertPerson([
            "f_name" => "Cornelis Jacobus Maria",
            "l_name" => "Berkhout",
            "gender" => "m",
            "birthday" => "20-12-1944",
            "deathday" => "07-11-2020",
            "user_id" => 70,
        ]);
        $verwachting = true;
        $this->laatTestResultaatZien($resultaat,$verwachting);
    }

    
    // we willen ook nog testen:
    // wat gebeurt er als je een persoon toevoegt met een deathday
    // wat gebeurt er als je een persoon toevoegt ZONDER een deathday
    

};