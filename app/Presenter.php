<?php

namespace App;

class Presenter
{
    public function displayPersons(array $persons): void
    {
        $this->displayData($persons, 'persons');
    }

    public function displayUsers(array $users): void
    {
        $this->displayData($users, 'users');
    }

    public function displayRelationTypes(array $relationTypes) {
        $this->displayData($relationTypes, 'relatie types');
    }

    private function displayData(array $data, string $name): void
    {
        echo "<br> <br>All $name: <hr>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }


}
