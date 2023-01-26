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
        // echo json_encode($data);
    }

    public function insertUser(mixed $new_user): bool //twijfel over mixed
    {
        if($this->getUserIdBasedOnEmail($new_user['email']) !== FALSE){
            return false;
        }

        $data = [
            'email' => $new_user['email'],
            'password' => $new_user['password'],
        ];


        $sql = "INSERT INTO users (email_address, password) VALUES (:email,:password)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);

    }

    public function removeUser(int $id): void
    {
        $data = [
            'id' => $id,
        ];
        $sql = "DELETE FROM users WHERE id = (:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getUsers(): array
    {
        $stmt = $this->pdo->query("SELECT id,email_address FROM users");
        $user = [];
        while ($row = $stmt->fetch()) {
            $person = [
                'id' => $row['id'],
                'email_address' => $row['email_address'],
            ];
            $user[] = $person;
        }

        return $user;
    }

    public function getUserIdBasedOnEmail(string $email): false|string // hij gaf dit als optie, waarom is hij rood?
    {
        $stmt = $this->pdo->query("SELECT id FROM users WHERE email_address = '$email' LIMIT 1");
        $result = $stmt->fetch();
        if($result === FALSE){
            return FALSE;
        }

        return $result['id'];

    }

    public function getPersonById(int $id, int $user_id): false|array
    {
        $stmt = $this->pdo->query("SELECT * FROM persons WHERE id = '$id' and user_id = '$user_id' LIMIT 1");

        $result = $stmt->fetch();
        if($result === FALSE){
            return FALSE;
        }

        return $result;

    }

    public function getUserIdBasedOnEmailAndPassword(string $email, string $password): false|string
    {
        $stmt = $this->pdo->query("SELECT id FROM users WHERE password= '$password' AND email_address = '$email' LIMIT 1");
        $result = $stmt->fetch();
        if($result === FALSE){
            return FALSE;
        }

        return $result['id'];
    }


    public function removeAllPersonsFromUser(int $user_id): void
    {
        $data = [
            'user_id' => $user_id,
        ];
        $sql = "DELETE FROM persons WHERE user_id = (:user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function insertPerson(mixed $person, int $user_id): false|string
    {
        // @todo: add person validation
        if($person === null) {
            return false;
        }

        $data = [
            'f_name' => $person['f_name'],
            'l_name' => $person['l_name'],
            'gender' => $person['gender'],
            'birthday' => $person['birthday'],
            'deathday' => $person['deathday'] ?? null,
            'user_id' => $user_id,
        ];

        $sql = "INSERT INTO persons (f_name, l_name, gender,birthday,deathday,user_id) VALUES (:f_name, :l_name, :gender,:birthday,:deathday, :user_id)";
        
        try {

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
        } catch(\Exception $e) {
            return false;
        }
    
        return $this->pdo->lastInsertId();
    }

    public function removePerson(int $id): void
    {
        $data = [
            'id' => $id,
        ];
        $sql = "DELETE FROM persons WHERE id = (:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getPersonsPerUser(int $user_id): array
    {
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
                'user_id' => $user_id,
            ];
            $persons[] = $person;
        }
        return $persons;
    }

    public function insertRelationship(int $relation_type_id, int $person1, int $person2): bool
    {

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
        return $stmt->execute($data);

    }

    private function isValidRelationshipId(int $id): bool
    {
        $relation_types = $this->getAllRelationTypes();
        $relation_type_ids = array_column($relation_types, 'relation_type_id');

        return in_array($id, $relation_type_ids);
    }

    private function isValidRelationshipIdLoop(int $id)
    {
        $relation_types = $this->getAllRelationTypes();
        foreach($relation_types as $relation_type_array){
            if($relation_type_array['relation_type_id'] == $id){
                print_r($relation_type_array['relation_type_id']);
                print_r('TRUE');
                break;
            } print_r('FALSE');
        }
    }

    public function insertDeathday(int $id,mixed $deathday): void
    {
        $data = [
            'id' => $id,
            'deathday' => $deathday,
        ];

        $sql = "UPDATE persons SET deathday = (:deathday) WHERE id = (:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getAllRelationTypes(): array
    {
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

