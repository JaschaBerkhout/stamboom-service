<?php
require 'vendor/autoload.php';

use App\PersonsDatabase;
use App\Presenter;

$db = new PersonsDatabase();
$presenter = new Presenter();



print_r($_GET);
$type = $_GET['type'];
echo $type;
echo "<HR>";

if ($type === 'users') {
    $users = $db->getUsers();
    $presenter->displayUsers($users);
} elseif ($type === 'persons') {
    displayPersonsFromUser($db, $presenter, 1);
} else {
    exit("Je hebt geen geldig type ingevuld jochie!");
}


function displayPersonsFromUser($db, $presenter, $user_id) {
    $persons = $db->getPersonsPerUser($user_id);
    echo "Displaying persons from $user_id";
    $presenter->displayPersons($persons);
}


