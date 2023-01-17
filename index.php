<?php
require 'vendor/autoload.php';

use App\PersonsDatabase;
use App\Presenter;
use App\Tester;

$db = new PersonsDatabase();
$presenter = new Presenter();


takeActionBasedOnType($db, $presenter);


function takeActionBasedOnType($db, $presenter)
{
    $type = $_GET['type'];
    if ($type === 'users') {
        $users = $db->getUsers();
        $presenter->displayUsers($users);
    } elseif ($type === 'persons') {
        displayPersonsFromUser($db, 1);
    } elseif ($type === 'relation_types') {
        $relation_types = $db->getAllRelationTypes();
        $presenter->displayRelationTypes($relation_types);
    } elseif($type === "testing") {
        voerTestjesUit($db);
    } elseif($type === "personen_json"){
        displayPersonsFromUserJson($db,$presenter,$_GET['user_id']);
    } else {
        exit("Je hebt geen geldig type ingevuld jochie!");
    }
}

function displayPersonsFromUser($db, $user_id) {
    $persons = $db->getPersonsPerUser($user_id);
    echo "<br>";
    echo "Displaying persons from user $user_id";
    $presenter->displayPersons($persons);
}

function displayPersonsFromUserJson($db,$presenter,$user_id){
    $persons = $db->getPersonsPerUser($user_id);
    $presenter->displayDataJson($persons);
}

function voerTestjesUit($db) {
    echo "<HR> TEST ZONE <HR>";
    $tester = new Tester($db);
    $tester->testInsertValidRelationship();
    $tester->testInsertInvalidRelationship();
    $tester->testAddPersonWithoutDeathday();
    $tester->testAddPersonWithDeathday();
    $tester->testAddPersonWithoutDataGivesFalse();
    $tester->testPersonenVerwijderenVanUser();
}