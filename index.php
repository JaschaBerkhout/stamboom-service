<?php
require 'vendor/autoload.php';

use App\PersonsDatabase;
use App\Presenter;
use App\Tester;

$db = new PersonsDatabase();
$presenter = new Presenter();

session_start();

var_dump($_SESSION);


var_dump($_SESSION);
return;

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
        handleInsertPerson($db);
    } elseif($type === "insert_user") {
        handleInsertUser($db);
    } elseif($type === "user_login") {
        handleUserLogin($db);
    }
    else {
        exit("Je hebt geen geldig type ingevuld jochie!");
    }
}

function handleInsertPerson($db)
{
    if (empty($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
        displayResponseAndExit(false,null,"LEEG zoals je toekomst");

    }

    $id = $db->insertPerson($_POST);

    if ($id !== false) {
        $persoon = $db->getPersonById($id, $_POST['user_id']);

        if ($persoon !== FALSE) {
            echo convertToJson(['result'=>true, 'data'=>$persoon]);
            return;
        }
    }

    displayResponseAndExit(false,null, 'Kon persoon niet toevoegen');
}

function handleUserLogin($db)
{
    $id = $db->getUserIdBasedOnEmailAndPassword($_POST['email'], $_POST['password']);
    if($id === false) {
        displayResponseAndExit(false, null, 'Geen user gevonden met deze gegevens');
    }

    displayResponseAndExit(true, $id);
}

function handleInsertUser($db){
    if (empty($_POST['email']) || empty($_POST['password'])) {
        displayResponseAndExit(false, null, 'Geen email of password meegegeven');
    }

    if ($db->insertUser($_POST)){
        $id = $db->getUserIdBasedOnEmail($_POST['email']);
            if($id !== FALSE){
                displayResponseAndExit(true, $id);
            }
    }
    displayResponseAndExit(false,null, 'Kon user niet toevoegen');
}

function displayResponseAndExit($result = false, $user_id = null, $message = 'Fout bij verwerken request'){

    echo convertToJson([
        'result'=>$result,
        'user_id'=>$user_id,
        'message'=>$message
    ]);
    exit;
}

function convertToJson($data){
    return json_encode($data);
}

function displayPersonsFromUser($db,$presenter, $user_id) {
    $persons = $db->getPersonsPerUser($user_id);
    echo "<br>";
    echo "Displaying persons from user $user_id";
    $presenter->displayPersons($persons);
}

function displayPersonsFromUserJson($db,$presenter,$user_id){
    $persons = $db->getPersonsPerUser($user_id);
    echo convertToJson($persons);
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

