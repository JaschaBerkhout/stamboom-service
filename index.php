<?php
require 'vendor/autoload.php';

use App\PersonsDatabase;
use App\Presenter;
use App\Tester;
use App\App;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$db = new PersonsDatabase();
$presenter = new Presenter();
$app = new App($db,$presenter);

if (session_status() === PHP_SESSION_NONE) {
session_start();
}

$app->takeActionBasedOnType($db, $presenter);



