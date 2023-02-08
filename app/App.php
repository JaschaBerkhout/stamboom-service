<?php
namespace App;

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
class App {
    private PersonsDatabase $db;
    private Presenter $presenter;

    public function __construct(PersonsDatabase $db, Presenter $presenter) {
        $this->db = $db;
        $this->presenter = $presenter;
    }

    public function takeActionBasedOnType(): void
    {
        $type = $_GET['type'];
        if ($type === 'users') {
            $this->handleDisplayUsers();
        } elseif ($type === 'persons') {
            $this->displayPersonsFromUser();
        } elseif ($type === 'relation_types') {
            $this->handleDisplayRelationTypes();
        } elseif ($type === "testing") {
            new Tester($this->db);
        } elseif ($type === "persons_json") {
            $this->displayPersonsFromUserJson();
        } elseif ($type === "insert_person") {
            $this->handleInsertPerson();
        } elseif ($type === "insert_user") {
            $this->handleInsertUser();
        } elseif ($type === "user_login") {
            $this->handleUserLogin();
        } elseif ($type === "user_logout") {
            $this->logOut();
        } else {
            exit("Je hebt geen geldig type ingevuld jochie!");
        }
    }

    public function logOut(): void
    {
        session_destroy();
    }

    public function getUserIdFromSession(): int
    {
        $this->requireLogin();
        return $_SESSION['user_id'];

    }


    private function handleDisplayUsers(): void
    {
        $users = $this->db->getUsers();
        $this->presenter->displayUsers($users);
    }

    private function handleDisplayRelationTypes(): void
    {
        $relation_types = $this->db->getAllRelationTypes();
        $this->presenter->displayRelationTypes($relation_types);
    }

    public function isLoggedIn(): bool
    {
        return !empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    private function handleInsertPerson(): void
    {
        $this->requireLogin();
        if (empty($this->getUserIdFromSession()) || !is_numeric($this->getUserIdFromSession())) {
            $this->displayResponseAndExit(false, 403, 'Niet ingelogd');

        }

        $id = $this->db->insertPerson($_POST);

        if ($id !== false) {
            $person = $this->db->getPersonById($id, $this->getUserIdFromSession());

            if ($person !== false) {
                echo $this->convertToJson(['result' => true, 'data' => $person]);
                return;
            }
        }

        $this->displayResponseAndExit(false, 403, 'Kon persoon niet toevoegen');
    }

    private function handleUserLogin(): void
    {
        $id = $this->db->getUserIdBasedOnEmailAndPassword($_POST['email'], $_POST['password']);

        if ($id === false) {

            $this->displayResponseAndExit(false, 401, 'Geen user gevonden met deze gegevens');
        }

        $_SESSION['user_id'] = $id;
        $_SESSION['logged_in'] = true;

        $this->displayResponseAndExit(true, 200, 'Ingelogd');

    }

    private function handleInsertUser(): void
    {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $this->displayResponseAndExit(false, 401, 'Geen email of password meegegeven');
        }

        if ($this->db->insertUser($_POST)) {
            $id = $this->db->getUserIdBasedOnEmail($_POST['email']);
            if ($id !== false) {
                $this->displayResponseAndExit(true, 200,'Ingelogd');
            }
        }
        $this->displayResponseAndExit(false, 403);
    }

    public function displayResponseAndExit(bool $result = false, int $http_code = null, string $message = 'Fout bij verwerken request'): void
    {
        $this->displayResponse($result,$http_code,$message);
        exit;
    }
    public function displayResponse(bool $result = false, int $http_code = null, string $message = 'Fout bij verwerken request'): void
    {
        if($http_code!==null) {
            http_response_code($http_code);
        }

        echo $this->convertToJson([
            'result' => $result,
            'user_id' => $_SESSION['user_id'] ?? null,
            'message' => $message,
        ]);

    }

    public function convertToJson(mixed $data): false|string
    {
        return json_encode($data);
    }

    public function displayPersonsFromUser(): void//twijfel?
    {
        $persons = $this->db->getPersonsPerUser($this->getUserIdFromSession());
        echo "<br>";
        echo "Displaying persons from user ". $_SESSION['user_id'];
        $this->presenter->displayPersons($persons);
    }

    public function displayPersonsFromUserJson(): void
    {

        $persons = $this->db->getPersonsPerUser($this->getUserIdFromSession());
        echo $this->convertToJson($persons);
    }

    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
                $this->displayResponseAndExit(false,403,'Niet ingelogd');
        }
        $this->displayResponse(true,200,'Ingelogd');

    }

}