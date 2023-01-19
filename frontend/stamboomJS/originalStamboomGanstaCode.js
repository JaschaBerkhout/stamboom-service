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
    updateSummary(this.numberOfPersons())
    updateFamilyTreeOnWebpage()
  }

  numberOfPersons(){
    return this.personen.length
  }

  sortOnBirthday(){
    return this.personen.sort((jong, oud) => jong.birthday - oud.birthday)
  }
};

class Persoon {
  constructor(fName, lName, gender, birthday, deathday){
    this.fName = fName
    this.lName = lName
    this.gender = gender
    this.birthday = birthday
    this.deathday = deathday
  }

  name(){
    return this.fName + ' ' + this.lName
  }

  getAge(datumStart, datumEind){
    let leeftijd = datumEind.getFullYear() - datumStart.getFullYear();
    const maand = datumEind.getMonth() - datumStart.getMonth();
    const dag = datumEind.getDate() - datumStart.getDate()
    if (maand < 0 || (maand === 0 && dag < 0)){
    return leeftijd - 1;
    }
    return leeftijd
  }

  getAgeOfPerson(){
     const geboortedatum = new Date(this.birthday);

    if (!this.isPassedAway()){
      const vandaag = new Date();
        return this.getAge(geboortedatum,vandaag);       
    }
    const overlijdensdatum = new Date(this.deathday);
    return this.getAge(geboortedatum,overlijdensdatum);
  }

  personCard() {
    return "<div class='"+ (this.gender === 'm' ? 'man' : 'vrouw')+ " persoon'>"+this.name() +
     ' <br> '+ this.getAgeOfPerson()+
     ' jaar' +
     ' <br>* ' +
     this.niceDateFormat(this.birthday) +
     ' <br>' +
     (this.isPassedAway() ? '✝ ' + this.niceDateFormat(this.deathday) : '') +
     '</div>';
  }

  niceDateFormat(datum) {
    return new Date(datum).toLocaleDateString('nl-nl');
  }

  isPassedAway(){
    return this.deathday !== ''
  }  
};

class Database {
  constructor(){}

  storeAllPersons(){
    //DeFamilie.personen.forEach(persoon => window.localStorage.setItem('persoon['+persoon.id+']', JSON.stringify(persoon)))
    window.localStorage.setItem('personen', JSON.stringify(DeFamilie.personen))
  }
  
  getAllPersons(){
    return JSON.parse(window.localStorage.getItem('personen'))
  }

  //verwijderd nu key:value helemaal.. moet alleen value worden.
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

function updateSummary(numberOfPersons) {
  const samenvatting = document.getElementById('samenvatting')

  let summaryText = () => {
    if (numberOfPersons === 1 ){
      return `De familie bevat nu ${numberOfPersons} persoon.`
    } 
    else {
      return `De familie bevat nu ${numberOfPersons} personen.`
    }
  }
  samenvatting.innerHTML = summaryText()
};

function generalMessage(tekst){
  const meldingElement = document.getElementById('melding')
  meldingElement.innerHTML = tekst
  removeMessage()
};

function removeMessage(){  
  setTimeout(() => document.getElementById('melding').innerHTML = '', 5000);
};

function messageNewPersonCreated(persoon) {
 generalMessage(`${persoon.fName} is toegevoegd aan de familie ${persoon.lName}.`);
};

function allOfTheFamily() {
  let result = '';
  DeFamilie.personen.forEach(persoon => result += persoon.personCard())
  return result;
};

function updateFamilyTreeOnWebpage(){
  const personenElement = document.getElementById('personen');
  personenElement.innerHTML = allOfTheFamily();
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



  