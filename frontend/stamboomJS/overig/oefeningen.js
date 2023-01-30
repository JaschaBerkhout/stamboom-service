bepaalLeeftijdvanPersoon(){
    const vandaag = new Date();
    const geboortedatum = new Date(this.birthday);

    if (this.deathday !== null){
        return bepaalLeeftijd(geboortedatum,vandaag);        
    }
    else { 
        const overlijdensdatum = new Date(this.deathday)
        return bepaalLeeftijd(geboortedatum,overlijdensdatum);
    }
}





// if deathday is not null gebruik verjaardag om leeftijd te bereken
// anders gebruik overlijdensdatum
    const overlijdensdatum = new Date(this.deathday)


function bepaalLeeftijd(datumStart, datumEind){
        let leeftijd = datumEind.getFullYear() - datumStart.getFullYear();
        const maand = datumEind.getMonth() - datumStart.getMonth();
        const dag = datumEind.getDate() - datumStart.getDate()
        if (maand < 0 || (maand === 0 && dag < 0)){
        return leeftijd - 1;
        } else {
        return leeftijd
        }
}