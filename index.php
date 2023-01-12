<?php
require 'vendor/autoload.php';

use App\PersonsDatabase;
use App\Presenter;

$db = new PersonsDatabase();
$presenter = new Presenter();

$users = $db->getUsers();
$presenter->displayUsers($users);

function displayPersonsFromUser($db, $presenter, $user_id) {
    $persons = $db->getPersonsPerUser($user_id);
    echo "Displaying persons from $user_id";
    $presenter->displayPersons($persons);
}

displayPersonsFromUser($db, $presenter, 1);
displayPersonsFromUser($db, $presenter, 70);


