$person1 = [
    "name" => "Jascha",
    "birthdate" => "16-02-1995"
];

$person2 = [
    "name" => "Daan",
    "birthdate" => "11-09-1992"
];

$person_object = new stdclass();
$person_object->name = "Dunja"; 

$persons = [$person1, $person2];

$first = $persons[0];
$last = $persons[count($persons)-1];


$person = [
    "f_name" => "Zoey",
    "l_name" => "Berkhout",
    "gender"=> "f",
    "birthday" => "27-08-2002",
    "user_id"=>1,
];

$db->insertPerson($person);
$db->removePerson(47);


$relation_types = $db->getAllRelationTypes();

foreach($relation_types as $relation_type_array){
    if($relation_type_array['relation_type_id'] == "6"){
    print_r($relation_type_array['relation_type_id']);
    print_r('TRUE');
    break;
} print_r('FALSE');
}