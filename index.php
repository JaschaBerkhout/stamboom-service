<?php
require 'vendor/autoload.php';
use App\SQLiteConnection;

$pdo = (new SQLiteConnection())->connect();
if ($pdo != null)
    echo 'Connected to the SQLite database successfully!';
else
    echo 'Whoops, could not connect to the SQLite database!';

    $stmt = $pdo->query("SELECT * FROM persons");
while ($row = $stmt->fetch()) {
    print_r($row);
}

$person1 = [
    "name" => "Jascha",
    "birthdate" => "16-02-1995"
];

$person2 = [
    "name" => "Daan",
    "birthdate" => "11-09-1992"
];

$person_object = new stdclass();
$person_object->name = "Dunja"; 

print_r($person_object);

$persons = [$person1, $person2];

$first = $persons[0];
$last = $persons[count($persons)-1];


function getPersonsPerUser($userId){
    global $persons;
    return $persons;
}
$get_persons_per_user = getPersonsPerUser(1);

$first_person = $get_persons_per_user[0];

// print_r(getPersonsPerUser(1));
// echo "<hr>";
// var_dump(getPersonsPerUser(1));

// echo $first_person['birthdate'];


// meer functies

// objecten

// classes

// functies in objecten en class instantiatie

// constructor

// scope

// database


// Requests GET
// JSON
// requests POST
