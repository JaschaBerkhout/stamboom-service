<?php
require 'vendor/autoload.php';

use App\PersonsDatabase;

$db = new PersonsDatabase();

function visualizePersonsPerUser($persons, $user_id) {
    echo "<br> <br>All persons: <hr>";
    echo "<pre>";
    print_r($persons);
    echo "</pre>";
}

$persons = $db->getPersonsPerUser(1);

visualizePersonsPerUser($persons, 1);

$first_person = $persons[0];


