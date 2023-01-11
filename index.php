<?php
require 'vendor/autoload.php';
use App\SQLiteConnection;

$db = new PersonsDatabase();

function visualizePersonsPerUser($persons, $user_id) {
    echo "<br>Personen lijst: <hr>";
    echo "<pre>";
    print_r($persons);
    echo "</pre>";
}

$db->insertUser('henkie', 'xxhorses123');

$person = [
    "f_name" => "Jascha",
    "l_name" => "Berkiewood",
    "gender"=> "F",
    "birthday" => "16-02-1995",
    "user_id"=>1,
];

$persons = $db->getPersonsPerUser(1);
// @todo: bedenk een tweede class om te gebruiken in deze file. > 

$first_person = $persons[0];

visualizePersonsPerUser($persons, 1);
$db->removePerson(25);

$db->insertPerson($person);

// objecten

// classes
class PersonsDatabase {
    private $pdo;

    public function __construct() {

        $this->pdo = (new SQLiteConnection())->connect();
        if ($this->pdo != null) {
            $data = ['message'=>"Connected to the SQLite database successfully!"];
        } else {
            $data = ["message"=>"Whoops, could not connect to the SQLite database!"];
        }
        echo json_encode($data);
    }

    //query user toevoegen
    public function insertUser($user_name, $password){
        $data = [
            'user_name' => $user_name,
            'password' => $password,
        ];
        $sql = "INSERT INTO users (user_name, password) VALUES (:user_name, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }
    
    //query persoon toevoegen
    public function insertPerson($person)
    {
        $data = [
            'f_name' => $person['f_name'],
            'l_name' => $person['l_name'],
            'gender' => $person['gender'],
            'birthday' => $person['birthday'],
            'user_id' => $person['user_id'], // later automatisch opvragen
        ];

        $sql = "INSERT INTO persons (f_name, l_name, gender,birthday, user_id) VALUES (:f_name, :l_name, :gender,:birthday, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    //query persoon verwijderen
    public function removePerson($id)
    {
        $data = [
            'id' => $id,
        ];
        $sql = "DELETE FROM persons WHERE id = (:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getPersonsPerUser($user_id){
        $stmt = $this->pdo->query("SELECT * FROM persons");
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
}


/** JS voorbeeldje: hoe we data opvragen uit deze server applicatie
 *
```js
 fetch("http://localhost:8000/").then(response=>response.json())
.then(data=>{ console.log(data); })
```
 */

// functies in objecten en class instantiatie

// constructor

// scope

// database


// Requests GET
// JSON
// requests POST



