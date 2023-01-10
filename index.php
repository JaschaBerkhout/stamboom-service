<?php
require 'vendor/autoload.php';
use App\SQLiteConnection;

$pdo = (new SQLiteConnection())->connect();
if ($pdo != null)
    echo 'Connected to the SQLite database successfully!';
else
    echo 'Whoops, could not connect to the SQLite database!';

//     $stmt = $pdo->query("SELECT * FROM persons");
// while ($row = $stmt->fetch()) {
//     print_r($row);
// }


$persons = [$person1, $person2];


function getPersonsPerUser($userId){
    global $persons;
    return $persons;
}
$get_persons_per_user = getPersonsPerUser(1);

$first_person = $get_persons_per_user[0];


// meer functies

//query user toevoegen
$data = [
    'user_name' => $user_name,
    'password' => $password,
];
$sql = "INSERT INTO persons (user_name, password) VALUES (:user_name, :password)";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);

//query persoon toevoegen
$data = [
    'f_name' => $f_name,
    'l_name' => $l_name,    
    'gender' => $gender,
    'birthday' => $birthday,
    'user_id' => $user_id,
];
$sql = "INSERT INTO persons (f_name, l_name, gender,birthday, user_id) VALUES (:f_name, :l_name, :gender,:birthday, :user_id)";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);

//query persoon verwijderen
$data = [
    'id' => $id,
];
$sql = "DELETE FROM persons (id) VALUES (:id)";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);

// objecten

// classes

// functies in objecten en class instantiatie

// constructor

// scope

// database


// Requests GET
// JSON
// requests POST

