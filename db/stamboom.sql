CREATE TABLE users(
    id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
    user_name varchar(255) NOT NULL,
    password varchar(255) NOT NULL
);

CREATE TABLE persons(
    id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
    f_name varchar(255) NOT NULL,
    l_name varchar(255) NOT NULL,
    gender varchar(1) NOT NULL,
    birthday date NOT NULL,
    deathday date,
    user_id integer NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE relations_types(
    relation_type_id integer PRIMARY KEY AUTOINCREMENT,
    relation_type varchar (255)
);

CREATE TABLE relations(
    relation_id integer PRIMARY KEY AUTOINCREMENT,
    relation_type_id integer NOT NULL,
    person1 integer NOT NULL,
    person2 integer NOT NULL,
    FOREIGN KEY (relation_id) REFERENCES relations(relation_id),
    FOREIGN KEY (person1) REFERENCES persons(id),
    FOREIGN KEY (person2) REFERENCES persons(id),
    FOREIGN KEY (relation_type_id) REFERENCES relations_types(relation_type_id)
);

INSERT INTO users(user_name,password)
    values ('Jascha','LekkerWachtwoordje23!');

INSERT INTO persons (f_name,l_name,gender,birthday,user_id)
    values ('Jascha','Berkhout','f','16-02-1995',1);

INSERT INTO persons(f_name,l_name,gender,birthday,user_id)
    values ('Dunja','Berkhout','f','26-05-1997',1);

INSERT INTO persons(f_name,l_name,gender,birthday,user_id)
    values ('Marry','van de Ruit','f','14-12-1969',1);

INSERT INTO relations_types(relation_type)
    VALUES ('Married'),('Parent'),('Relationship');

INSERT INTO relations(relation_type_id, person1, person2)
     values (2,3,1);

-- aanpassen van V naar F (NL naar EN)
UPDATE persons
SET birthday = '14-12-1969'
WHERE id = 3;

-- verwijder persoon
delete from persons where id = 1;

-- verwijder tabel
drop table persons;

ALTER TABLE relations_types
RENAME TO relation_types;
