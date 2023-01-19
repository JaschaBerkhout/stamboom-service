async function fetchPersonsForUser(id){
 let response = await fetch('http://localhost:8000/?type=personen_json&user_id=' + id)
  if(response.ok){
    let json = await response.json();
    return json;
  } else {
    alert("HTTP-Error: " + response.status);
    return [];
  }
}

fetchPersonsForUser(70).then((persons) => {
  if(persons.length === 0){
    console.log("Geen personen gevonden");
    } 
    console.log(persons);
  }
);

