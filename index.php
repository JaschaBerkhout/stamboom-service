<?php


$person1 = [
    "name" => "Jascha",
    "birthdate" => "16-02-1995"

];
$person2 = [
    "name" => "Daan",
    "birthdate" => "11-09-1992"
];

$persons = [$person1, $person2];

$first = $persons[0];
$last = $persons[count($persons)-1];


function getPersonsPerUser ($userId){
    global $persons;
    return $persons;
}

print_r(getPersonsPerUser(1));
echo "<hr>";
var_dump(getPersonsPerUser(1));


$get_persons_per_user = getPersonsPerUser(1);

$first_person = $get_persons_per_user[0];

echo "\n";
echo $first_person['birthdate'];
