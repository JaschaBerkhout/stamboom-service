// originalStamboomGanstaCode.js

class Familie {
  constructor(personsFromStorage){
    this.personen = []
    if(personsFromStorage === null) {
      return;
    }
      personsFromStorage.forEach(persoon => {
        if(persoon === null) {
          return;
    } 
      this.addPersoon(
      new Persoon(persoon.fName, persoon.lName, persoon.gender,persoon.birthday,persoon.deathday))
    })
  }

  addPersoon(persoon){
    persoon.id = this.numberOfPersons()
    this.personen[persoon.id] = persoon;
    updateFamilyTreeOnWebpage()
  }


class Database {
  constructor(){}

  storeAllPersons(){
    //DeFamilie.personen.forEach(persoon => window.localStorage.setItem('persoon['+persoon.id+']', JSON.stringify(persoon)))
    window.localStorage.setItem('personen', JSON.stringify(DeFamilie.personen))
  }
  
  getAllPersons(){
    return JSON.parse(window.localStorage.getItem('personen'))
  }

  removePersonFromLocalStorage(id){
    window.localStorage.removeItem('personen',id);
  }
  
  removeLocalStorage(){
    window.localStorage.clear('personen');
  }
 };

function createNewPerson(){
  
  const fNameElement = document.getElementById('fname');
  const lNameElement = document.getElementById('lname');
  const genderElement = document.querySelector('input[name="gender"]:checked');
  const bdayElement = document.getElementById('bday');
  const ddayElement = document.getElementById('dday');
  
  const fName = fNameElement.value;
  const lName = lNameElement.value;
  const birthday = bdayElement.value;
  const deathday = ddayElement.value;
  
  if(genderElement === null || fName === '' || lName === '' || birthday === ''){
    generalMessage('Leeg invulveld.')
    return;
  }
  
  const gender = genderElement.value;
  const persoon = new Persoon(fName,lName,gender,birthday,deathday)
  DeFamilie.addPersoon(persoon);
  
  fNameElement.value = '';
  lNameElement.value = '';
  bdayElement.value = '';
  ddayElement.value = '';
  genderElement.checked = false;

  messageNewPersonCreated(persoon);

};


// document.addEventListener('DOMContentLoaded', () => {

  console.log("HET KINDEKE IS GEBOREN")

  // })
  
  
  // begin van de stamboom website
  // let DeDatabase = new Database();
  // let personsFromStorage = DeDatabase.getAllPersons()
  // let DeFamilie = new Familie(personsFromStorage);
  // updateFamilyTreeOnWebpage();
  
  // DeDatabase.storeAllPersons();



  