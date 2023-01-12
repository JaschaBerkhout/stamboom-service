<?php
namespace App;

class Tester {

// wat gebeurt er als je een relatie toevoegt van een type die bestaat
    public function testInsertValidRelationship($db) {


        echo "<BR> ". __METHOD__ . " : ";
        $test_resultaat = $db->insertRelationship(2, 43, 2);
        $verwachting = true;
        echo $test_resultaat === $verwachting
            ? "Test is gelukt"
            : "Test is niet gelukt!";
        // gebruik de private functies voor het laten zien van de naam en het resultaat!
    }

// wat gebeurt er als je een relatie toevoegt van een type die NIET bestaat
    public function testInsertInvalidRelationship($db) {
        $this->laatTestNaamZien(__METHOD__);
        $test_resultaat = $db->insertRelationship(21298, 43, 2);
        $verwachting = false;
        $this->laatTestResultaatZien($test_resultaat, $verwachting);
    }

    // schrijf nog meer testjes!



    private function laatTestNaamZien($testNaam) {
        echo "<BR> ". $testNaam . " : ";
    }

    private function laatTestResultaatZien($resultaat, $verwachting) {
        echo $resultaat === $verwachting
            ? "Test is gelukt"
            : "Test is niet gelukt!";
    }

}
