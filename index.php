<?php
require 'vendor/autoload.php';
use App\SQLiteConnection;

function laatAllePersoontjesZienVoorUser($persons, $userId) {
    echo "<br>Personen lijst: <hr>";
    echo "<pre>";
    print_r($persons);
    echo "</pre>";
}

function getPersonsPerUser($pdo, $userId){
    $stmt = $pdo->query("SELECT * FROM persons");
    $persons = [];
    while ($row = $stmt->fetch()) {
        $person = [
            'f_name' => $row['f_name'],
            'l_name' => $row['l_name'],
            'gender' => $row['gender'],
            'birthday' => $row['birthday'],
            'user_id' => $row['user_id'], // later automatisch opvragen
        ];
        $persons[] = $person;
    }
    return $persons;
}

// meer functies

//query persoon toevoegen
function insertPerson($pdo, $person)
{
    $data = [
        'f_name' => $person['f_name'],
        'l_name' => $person['l_name'],
        'gender' => $person['gender'],
        'birthday' => $person['birthday'],
        'user_id' => $person['user_id'], // later automatisch opvragen
    ];

    $sql = "INSERT INTO persons (f_name, l_name, gender,birthday, user_id) VALUES (:f_name, :l_name, :gender,:birthday, :user_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

//query persoon verwijderen
function removePerson($pdo, $id)
{
    $data = [
        'id' => $id,
    ];
    $sql = "DELETE FROM persons (id) VALUES (:id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}



$db = new PersonenDatabase();
$db->insertUser('henkie', 'xxhorses123');

$person = [
    "f_name" => "Jascha",
    "l_name" => "Berkiewood",
    "gender"=> "F",
    "birthday" => "16-02-1995",
    "user_id"=>1,
];

// @todo: deze functies werken nu niet, die moeten nog verplaatst worden!!
// @todo: bedenk een tweede class om te gebruiken in deze file.


$persons = getPersonsPerUser($pdo, 1);
insertPerson($pdo, $person);

//removePerson($pdo, $person['id']);
//laatAllePersoontjesZienVoorUser($pdo, 1);



$first_person = $get_persons_per_user[0];



laatAllePersoontjesZienVoorUser($persons, 1);
// objecten

// classes
class PersonenDatabase {
    private $pdo;

    public function __construct() {

        $this->pdo = (new SQLiteConnection())->connect();
        if ($this->pdo != null) {
            echo 'Connected to the SQLite database successfully!';
        } else {
            echo 'Whoops, could not connect to the SQLite database!';
        }
    }

    //query user toevoegen
    public function insertUser($user_name, $password)
    {
        $data = [
            'user_name' => $user_name,
            'password' => $password,
        ];
        $sql = "INSERT INTO users (user_name, password) VALUES (:user_name, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }
}


// functies in objecten en class instantiatie

// constructor

// scope

// database


// Requests GET
// JSON
// requests POST



