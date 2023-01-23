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
        displayPersonsFromUser($db,$presenter, 1);
    } elseif ($type === 'relation_types') {
        $relation_types = $db->getAllRelationTypes();
        $presenter->displayRelationTypes($relation_types);
    } elseif($type === "testing") {
        voerTestjesUit($db);
    } elseif($type === "personen_json"){
        displayPersonsFromUserJson($db,$presenter,$_GET['user_id']);
    } elseif($type === "insert_person") {
        if(!empty($_POST['user_id']) && is_numeric($_POST['user_id'])){
        var_dump($db->insertPerson($_POST));
        } else {
            exit("LEEG zoals je toekomst");
        }
    } elseif($type === "insert_user") {
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            var_dump($db->insertUser($_POST));
        } else {
            exit("LEEG zoals je toekomst");
        }
    } else {
        exit("Je hebt geen geldig type ingevuld jochie!");
    }
}

function displayPersonsFromUser($db,$presenter, $user_id) {
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