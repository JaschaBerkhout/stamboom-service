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
        displayPersonsFromUser($db, $presenter, 1);
    } elseif ($type === 'relation_types') {
        $relation_types = $db->getAllRelationTypes();
        $presenter->displayRelationTypes($relation_types);
    } else {
        exit("Je hebt geen geldig type ingevuld jochie!");
    }
}

function displayPersonsFromUser($db, $presenter, $user_id) {
    $persons = $db->getPersonsPerUser($user_id);
    echo "Displaying persons from $user_id";
    $presenter->displayPersons($persons);
}

echo "<HR> TEST ZONE<HR>";
$tester = new Tester();
$tester->testInsertValidRelationship($db);
$tester->testInsertInvalidRelationship($db);
// voer nog meer testjes uit!
// we willen ook nog testen:
// wat gebeurt er als je een persoon toevoegt met een deathday
// wat gebeurt er als je een persoon toevoegt ZONDER een deathday
