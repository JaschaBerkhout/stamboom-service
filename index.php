<?php
require 'vendor/autoload.php';

use App\PersonsDatabase;
use App\Presenter;
use App\Tester;

$db = new PersonsDatabase();
$presenter = new Presenter();

if (session_status() === PHP_SESSION_NONE) {
session_start();
}

takeActionBasedOnType($db, $presenter);

function takeActionBasedOnType($db, $presenter)
{
    $type = $_GET['type'];
    if ($type === 'users') {
        handleDisplayUsers($db,$presenter);
    } elseif ($type === 'persons') {
        displayPersonsFromUser($db,$presenter, 1);
    } elseif ($type === 'relation_types') {
        handleDisplayRelationTypes($db,$presenter);
    } elseif($type === "testing") {
        voerTestjesUit($db);
    } elseif($type === "personen_json"){
        displayPersonsFromUserJson($db,$_GET['user_id']);
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

function handleDisplayUsers($db,$presenter){
    $users = $db->getUsers();
    $presenter->displayUsers($users);
}

function handleDisplayRelationTypes($db,$presenter){
    $relation_types = $db->getAllRelationTypes();
    $presenter->displayRelationTypes($relation_types);
}

function isLoggedIn():bool{
    return !empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function handleInsertPerson(PersonsDatabase $db){
    requireLogin();
    if (empty($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
        displayResponseAndExit(false,null,"LEEG zoals je toekomst");

    }

    $id = $db->insertPerson($_POST);

    if ($id !== false) {
        $person = $db->getPersonById($id, $_POST['user_id']);

        if ($person !== FALSE) {
            echo convertToJson(['result'=>true, 'data'=>$person]);
            return;
        }
    }

    displayResponseAndExit(false,null, 'Kon persoon niet toevoegen');
}

function handleUserLogin(PersonsDatabase $db){
    $id = $db->getUserIdBasedOnEmailAndPassword($_POST['email'], $_POST['password']);

    if($id === false) {

        displayResponseAndExit(false, null, 'Geen user gevonden met deze gegevens');
    }

    $_SESSION['user_id']=$id;
    $_SESSION['logged_in']=true;

    displayResponseAndExit(true, $id,'Log in gelukt');

}


function handleInsertUser(PersonsDatabase $db){
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

function convertToJson(mixed $data):false | string{
    return json_encode($data);
}

function displayPersonsFromUser(PersonsDatabase $db,$presenter, $user_id) {
    requireLogin();
    $persons = $db->getPersonsPerUser($user_id);
    echo "<br>";
    echo "Displaying persons from user $user_id";
    $presenter->displayPersons($persons);
}

function displayPersonsFromUserJson(PersonsDatabase $db,$user_id){
    requireLogin();
    $persons = $db->getPersonsPerUser($user_id);
    echo convertToJson($persons);
}

function requireLogin():void{
    if(!isLoggedIn()) {
        exit("Niet ingelogd");
    }
}
function voerTestjesUit(PersonsDatabase $db) {
    echo "<HR> TEST ZONE <HR>";
    $tester = new Tester($db);
    $tester->testInsertValidRelationship();
    $tester->testInsertInvalidRelationship();
    $tester->testAddPersonWithoutDeathday();
    $tester->testAddPersonWithDeathday();
    $tester->testAddPersonWithoutDataGivesFalse();
    $tester->testPersonenVerwijderenVanUser();
}

