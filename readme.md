om docker te starten:
```docker-compose up```



## mogelijke todo's


// @todo: maak een functie die checkt of een user naam niet al bestaat, 
    check op wachtwoord
// @todo: add person validation


/** JS voorbeeldje: hoe we data opvragen uit deze server applicatie

```js
 fetch("http://localhost:8000/").then(response=>response.json())
.then(data=>{ console.log(data); })
```

Hoe je een persoon toevoegt:
```php
    $db->insertPerson([
        'f_name' => 'Cornelis Jacobus Maria',
        'l_name' => 'Berkhout',
        'gender' => 'm',
        'birthday' => '20-12-1944',
        'deathday' => '07-11-2020',
        'user_id' => 70,
    ]);
```
// testen
opbouw test
```     function NAME($db){
        $this->laatTestNaamZien(__METHOD__);
        test hier //
        $verwachting;
        is $resultaat gelijk aan $verwachting
        $this->laatTestResultaatZien($test_resultaat, $verwachting);
```
//GET parameters in URL gebruiken
// personen_json zorgt voor json versie van de personen lijst
// user_id zorgt dat je alleen de personen van die user ziet.
```http://localhost:8000/?type=personen_json&user_id=1```
