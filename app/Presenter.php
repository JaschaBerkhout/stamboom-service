<?php

namespace App;

class Presenter
{
    public function displayPersons($persons)
    {
        $this->displayData($persons, 'persons');
    }

    public function displayUsers($users) {
        $this->displayData($users, 'users');
    }

    private function displayData($data, $name) {
        echo "<br> <br>All $name: <hr>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
