function ageAverage(){
    return this.ageTotal() / this.aantalPersonen(); 
}


function ageTotal(){
    let ageTotal = 0
    
    this.personen.forEach(persoon => ageTotal += persoon.bepaalLeeftijdVanPersoon())
        
    return ageTotal;  
  }

  function partOfFam(start, end){
    let partOfFam = []
    
    if(end > this.aantalPersonen() ){
        end = this.aantalPersonen()
    }
    
    for (let i=start; i < end; i++){
        partOfFam.push(this.personen[i])
    }
    
    return partOfFam
  }

  function oudste(){
    return this.sortAge()[0]
  }
  
  function jongste(){
    return this.sortAge()[this.aantalPersonen() - 1]
  }

// slice function
  const animals = ['ant', 'bison', 'camel', 'duck', 'elephant'];

function partOfSomething(start, end){
    let partOfSomething = []
    if(end > animals.length ){
        end = animals.length
    }
    for (let i=start; i < end; i++){
        partOfSomething.push(animals[i])
    }
    return partOfSomething
}
console.log(partOfSomething(2,4));