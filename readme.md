## Tips en tricks:
* Om docker te starten:
```docker-compose up```

* JS hoe we data opvragen uit deze server applicatie

```js
 fetch("http://localhost:8000/").then(response=>response.json())
.then(data=>{ console.log(data); })
```

* Hoe je een persoon toevoegt:
```php
    $db->insertPerson([
        'f_name' => 'Voornaam',
        'l_name' => 'Achternaam',
        'gender' => 'm/f',
        'birthday' => '01-01-1990',
        'deathday' => '01-01-2023',
        'user_id' => ?,
    ]);
```
* Opbouw test

```php
    function NAME($db)
    {
        $this->laatTestNaamZien(__METHOD__);
        test hier //
        $verwachting = true/false;
        is $resultaat gelijk aan $verwachting
        $this->laatTestResultaatZien($test_resultaat, $verwachting);
    }
```

