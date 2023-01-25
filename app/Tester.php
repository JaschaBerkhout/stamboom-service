<?php
namespace App;

class Tester {

    private PersonsDatabase $db;

    public function __construct(PersonsDatabase $db) {
        $this->db = $db;
    }

    
    private function laatTestNaamZien($test_naam) {
        echo "<br> ". $test_naam . " : ";
    }
    
    private function expectCertainResult($resultaat, $verwachting) {
        echo $resultaat === $verwachting ? "Test is gelukt" : "Test is niet gelukt!";
    }

    private function testPersoon($deathday = null, $user_id = 70){
       return [
            'f_name' => 'voornaam',
            'l_name' => 'l_name',
            'gender' => 'gender',
            'birthday' => 'birthday',
            'deathday' => $deathday,
            'user_id' => $user_id,
        ];
    }

    private function getLevendPersoon() {
        return $this->testPersoon();
    }
    private function getDooie() {
        return $this->testPersoon('01-01-2023');
    }


// wat gebeurt er als je een relatie toevoegt van een type die bestaat
    public function testInsertValidRelationship() {
        $this->laatTestNaamZien(__METHOD__);
        $resultaat = $this->db->insertRelationship(2, 43, 2);
        $verwachting = true;
        $this->expectCertainResult($resultaat, $verwachting);
    }

// wat gebeurt er als je een relatie toevoegt van een type die NIET bestaat
    public function testInsertInvalidRelationship() {
        $this->laatTestNaamZien(__METHOD__);
        $resultaat = $this->db->insertRelationship(21298, 43, 2);
        $verwachting = false;
        $this->expectCertainResult($resultaat, $verwachting);
    }


        // @todo: try catch

        // verwacht foutmelding
    

    // schrijf nog meer testjes!
    // wat gebeurt er als je een persoon toevoegt ZONDER een deathday
   
    public function testAddPersonWithoutDataGivesFalse() {
        
        // wat test je?
        
        // wat wil je hebbeN?
        $this->laatTestNaamZien(__METHOD__);
        $resultaat = $this->db->insertPerson(null);

        $this->expectCertainResult($resultaat,false);
    }


    public function testAddPersonWithoutDeathday(){
        $this->laatTestNaamZien(__METHOD__);
        $test_persoon = $this->getLevendPersoon();
        $resultaat = $this->db->insertPerson($test_persoon);
        $this->expectCertainResult($resultaat,true);
    }

    // wat gebeurt er als je een persoon toevoegt met een deathday
    public function testAddPersonWithDeathday(){
        $this->laatTestNaamZien(__METHOD__);
        $test_persoon = $this->getDooie();
        $resultaat = $this->db->insertPerson($test_persoon);
        $this->expectCertainResult($resultaat,true);
    }


    // zou dit beter werken dan losse array in de test? Die werkte niet. 

    // we willen ook nog testen:


    // gebruik in voorbereiding de toevoeg functie
    // wil testen: persoon verwijderen > die hiervoor zijn toegevoegd

    // resultaat true
    // eind restulaat check of alle personen uit zijn, is persons van user x leeg    

    public function testPersonenVerwijderenVanUser(){
        $this->laatTestNaamZien(__METHOD__);

        // arrangeren
        $this->db->insertPerson($this->getLevendPersoon());
        
        // acteren
        $this->db->removeAllPersonsFromUser();
        
        // assertief zijn
        $aantalPersonenPerUser = count($this->db->getPersonsPerUser(70));
        $this->expectCertainResult($aantalPersonenPerUser,0);
    }



    // testjes schrijven voor user toevoegen met meerdere mogelijkheden
};