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

    public function takeActionBasedOnType($db, $presenter){
        $type = $_GET['type'];
        if ($type === 'users') {
            $this->handleDisplayUsers($db, $presenter);
        } elseif ($type === 'persons') {
            $this->displayPersonsFromUser($db, $presenter);
        } elseif ($type === 'relation_types') {
            $this->handleDisplayRelationTypes($db, $presenter);
        } elseif ($type === "testing") {
            $this->voerTestjesUit($db);
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

    public function getUserIdFromSession(): int
    {
        $this->requireLogin();
        return $_SESSION['user_id'];
    }


    private function handleDisplayUsers(PersonsDatabase $db, Presenter $presenter)
    {
        $users = $db->getUsers();
        $presenter->displayUsers($users);
    }

    private function handleDisplayRelationTypes(PersonsDatabase $db, $presenter)
    {
        $relation_types = $db->getAllRelationTypes();
        $presenter->displayRelationTypes($relation_types);
    }

    public function isLoggedIn(): bool
    {
        return !empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    private function handleInsertPerson(PersonsDatabase $db)
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

    private function handleUserLogin(PersonsDatabase $db)
    {
        $id = $db->getUserIdBasedOnEmailAndPassword($_POST['email'], $_POST['password']);

        if ($id === false) {

            $this->displayResponseAndExit(false, null, 'Geen user gevonden met deze gegevens');
        }

        $_SESSION['user_id'] = $id;
        $_SESSION['logged_in'] = true;

        $this->displayResponseAndExit(true, $id, 'Log in gelukt');

    }


    private function handleInsertUser(PersonsDatabase $db)
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

    public function displayResponseAndExit($result = false, $user_id = null, $message = 'Fout bij verwerken request')
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

    public function displayPersonsFromUser(PersonsDatabase $db, Presenter $presenter)
    {
        $this->requireLogin();
        $persons = $db->getPersonsPerUser($this->getUserIdFromSession());
        echo "<br>";
        echo "Displaying persons from user ". $this->getUserIdFromSession();
        $presenter->displayPersons($persons);
    }

    public function displayPersonsFromUserJson(PersonsDatabase $db)
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

    public function voerTestjesUit(PersonsDatabase $db)
    {
        echo "<HR> TEST ZONE <HR>";
        $tester = new Tester($db);
        $tester->testInsertValidRelationship();
        $tester->testInsertInvalidRelationship();
        $tester->testAddPersonWithoutDeathday();
        $tester->testAddPersonWithDeathday();
        $tester->testAddPersonWithoutDataGivesFalse();
        $tester->testPersonenVerwijderenVanUser();
    }

}