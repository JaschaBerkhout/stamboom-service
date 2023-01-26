<?php
namespace App;

if (session_status() === PHP_SESSION_NONE)
{
    session_start();  // hier of daar?
}
class App {
    private PersonsDatabase $db;
    private Presenter $presenter;

    public function __construct(PersonsDatabase $db, Presenter $presenter) {
        $this->db = $db;
        $this->presenter = $presenter;
    }

    public function takeActionBasedOnType($db, $presenter): void
    {
        $type = $_GET['type'];
        if ($type === 'users') {
            $this->handleDisplayUsers($db, $presenter);
        } elseif ($type === 'persons') {
            $this->displayPersonsFromUser($db, $presenter);
        } elseif ($type === 'relation_types') {
            $this->handleDisplayRelationTypes($db, $presenter);
        } elseif ($type === "testing") {
            // voerTestjesUit($db);
        } elseif ($type === "persons_json") {
            $this->displayPersonsFromUserJson($db);
        } elseif ($type === "insert_person") {
            $this->handleInsertPerson($db);
        } elseif ($type === "insert_user") {
            $this->handleInsertUser($db);
        } elseif ($type === "user_login") {
            $this->handleUserLogin($db);
        } else {
            exit("Je hebt geen geldig type ingevuld jochie!");
        }
    }

    public function logOut(): void{
        unset($_SESSION);
    }

    public function getUserIdFromSession(): int
    {
        $this->requireLogin();
        return $_SESSION['user_id'];
    }


    private function handleDisplayUsers(PersonsDatabase $db, Presenter $presenter): void
    {
        $users = $db->getUsers();
        $presenter->displayUsers($users);
    }

    private function handleDisplayRelationTypes(PersonsDatabase $db, $presenter): void
    {
        $relation_types = $db->getAllRelationTypes();
        $presenter->displayRelationTypes($relation_types);
    }

    public function isLoggedIn(): bool
    {
        return !empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    private function handleInsertPerson(PersonsDatabase $db): void
    {
        $this->requireLogin();
        if (empty($this->getUserIdFromSession()) || !is_numeric($this->getUserIdFromSession())) {
            $this->displayResponseAndExit(false, null, "LEEG zoals je toekomst");

        }

        $id = $db->insertPerson($_POST);

        if ($id !== false) {
            $person = $db->getPersonById($id, $this->getUserIdFromSession());

            if ($person !== FALSE) {
                echo $this->convertToJson(['result' => true, 'data' => $person]);
                return;
            }
        }

        $this->displayResponseAndExit(false, null, 'Kon persoon niet toevoegen');
    }

    private function handleUserLogin(PersonsDatabase $db): void
    {
        $id = $db->getUserIdBasedOnEmailAndPassword($_POST['email'], $_POST['password']);

        if ($id === false) {

            $this->displayResponseAndExit(false, null, 'Geen user gevonden met deze gegevens');
        }

        $_SESSION['user_id'] = $id;
        $_SESSION['logged_in'] = true;

        $this->displayResponseAndExit(true, $id, 'Log in gelukt');

    }


    private function handleInsertUser(PersonsDatabase $db): void //?
    {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $this->displayResponseAndExit(false, null, 'Geen email of password meegegeven');
        }

        if ($db->insertUser($_POST)) {
            $id = $db->getUserIdBasedOnEmail($_POST['email']);
            if ($id !== FALSE) {
                $this->displayResponseAndExit(true, $id);
            }
        }
        $this->displayResponseAndExit(false, null, 'Kon user niet toevoegen');
    }

    public function displayResponseAndExit(bool $result = false, int $user_id = null, string $message = 'Fout bij verwerken request'): array
    {

        echo $this->convertToJson([
            'result' => $result,
            'user_id' => $user_id,
            'message' => $message
        ]);

        exit;
    }

    public function convertToJson(mixed $data): false|string
    {
        return json_encode($data);
    }

    public function displayPersonsFromUser(PersonsDatabase $db, Presenter $presenter): void//twijfel?
    {
        $this->requireLogin();
        $persons = $db->getPersonsPerUser($this->getUserIdFromSession());
        echo "<br>";
        echo "Displaying persons from user ". $this->getUserIdFromSession();
        $presenter->displayPersons($persons);
    }

    public function displayPersonsFromUserJson(PersonsDatabase $db): void
    {
        $this->requireLogin();
        $persons = $db->getPersonsPerUser($this->getUserIdFromSession());
        echo $this->convertToJson($persons);
    }

    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            exit("Niet ingelogd");
        }
    }

}