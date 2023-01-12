<?php
namespace App;

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

    public function insertUser($user_name, $password){
        $data = [
            'user_name' => $user_name,
            'password' => $password,
        ];
        $sql = "INSERT INTO users (user_name, password) VALUES (:user_name, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function removeUser(int $id){
        $data = [
            'id' => $id,
        ];
        $sql = "DELETE FROM users WHERE id = (:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getUsers() {
        $stmt = $this->pdo->query("SELECT id, user_name FROM users");
        $user = [];
        while ($row = $stmt->fetch()) {
            $person = [
                'id' => $row['id'],
                'user_name' => $row['user_name'],
            ];
            $user[] = $person;
        }
        return $user;
    }

    public function removeAllPersonsFromUser(int $user_id){
        $data = [
            'user_id' => $user_id,
        ];
        $sql = "DELETE FROM persons WHERE user_id = (:user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function insertPerson($person)
    {
        $data = [
            'f_name' => $person['f_name'],
            'l_name' => $person['l_name'],
            'gender' => $person['gender'],
            'birthday' => $person['birthday'],
            'deathday' => $person['deathday'] ?? '',
            'user_id' => $person['user_id'], // later automatisch opvragen
        ];

        $sql = "INSERT INTO persons (f_name, l_name, gender,birthday, user_id) VALUES (:f_name, :l_name, :gender,:birthday, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function removePerson(int $id){
        $data = [
            'id' => $id,
        ];
        $sql = "DELETE FROM persons WHERE id = (:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getPersonsPerUser(int $user_id){
        $stmt = $this->pdo->query("SELECT * FROM persons WHERE user_id = $user_id");
        $persons = [];
        while ($row = $stmt->fetch()) {
            $person = [
                'id' => $row['id'],
                'f_name' => $row['f_name'],
                'l_name' => $row['l_name'],
                'gender' => $row['gender'],
                'birthday' => $row['birthday'],
                'deathday' => $row['deathday'],
                'user_id' => $row['user_id'], // later automatisch opvragen
            ];
            $persons[] = $person;
        }
        return $persons;
    }

    public function insertRelationship(int $relation_type_id, int $person1, int $person2){

        if(!$this->isValidRelationshipId($relation_type_id)){
            echo "\n Relationship type not found.\n";
            return false;
        }

        $data = [
            'relation_type_id' => $relation_type_id,
            'person1' => $person1,
            'person2' => $person2,
        ];
        $sql = "INSERT INTO relations (relation_type_id, person1, person2) VALUES (:relation_type_id, :person1, :person2)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return true;

    }

    private function isValidRelationshipId($id){
        $relation_types = $this->getAllRelationTypes();
        $relation_type_ids = array_column($relation_types, 'relation_type_id');

        return in_array($id, $relation_type_ids);
    }


    // ja ja... we moeten nog steeds hier een variant bouwen met een loop,
    // Hint: die functie zoekt dus door alle relation types heen en indien de gegeven type id bestaat,
    // true teruggeeft (return). En anders, na de loop, false teruggeeft.


    public function insertDeathday($id,$deathday){
        $data = [
            'id' => $id,
            'deathday' => $deathday,
        ];

        $sql = "UPDATE persons SET deathday = (:deathday) WHERE id = (:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getAllRelationTypes(){
        $stmt = $this->pdo->query("SELECT * FROM relation_types");
        $relation_types = [];
        while ($row = $stmt->fetch()) {
            $relation_type = [
                'relation_type_id' => $row['relation_type_id'],
                'relation_type' => $row['relation_type'],
            ];
            $relation_types[] = $relation_type;
        }
        return $relation_types;
    }
};
