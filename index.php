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
        $presenter->displayPersonsFromUser($db, $presenter, 1);
    } elseif ($type === 'relation_types') {
        $relation_types = $db->getAllRelationTypes();
        $presenter->displayRelationTypes($relation_types);
    } else {
        exit("Je hebt geen geldig type ingevuld jochie!");
    }
}


echo "<HR> TEST ZONE <HR>";
$tester = new Tester();
$tester->testInsertValidRelationship($db);
$tester->testInsertInvalidRelationship($db);

// voer nog meer testjes uit!

$tester->testAddPersonWithoutDeathday($db);
$tester->testAddPersonWithDeathday($db);