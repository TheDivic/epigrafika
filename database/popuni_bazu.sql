INSERT INTO `mydb`.`modernadrzava` (`id`, `naziv`) VALUES (-1, 'Nepoznata');
INSERT INTO `mydb`.`modernadrzava` (`id`, `naziv`) VALUES ('1', 'Srbija'),
('2', 'Makedonija'), ('3', 'Hrvatska');
/* moderna mesta */
INSERT INTO  `mydb`.`ModernoMesto`(`id`,`naziv`,`modernaDrzava`) VALUES(-1,'Nepoznato',-1);
INSERT INTO  `mydb`.`ModernoMesto`(`id`,`naziv`,`modernaDrzava`) VALUES(1,'Beograd',1);
INSERT INTO  `mydb`.`ModernoMesto`(`id`,`naziv`,`modernaDrzava`) VALUES(2,'Aleksandrovac',1);
INSERT INTO  `mydb`.`ModernoMesto`(`id`,`naziv`,`modernaDrzava`) VALUES(3,'Kraljevo',1);
INSERT INTO  `mydb`.`ModernoMesto`(`id`,`naziv`,`modernaDrzava`) VALUES(4,'Cacak',1);
INSERT INTO  `mydb`.`ModernoMesto`(`id`,`naziv`,`modernaDrzava`) VALUES(5,'Valjevo',1);

INSERT INTO `mydb`.`grad` (`id`, `naziv`) VALUES ('-1', 'Nepoznat'), ('1', 'Aleksandrovac'), ('2', 'Kraljevo'),
('3', 'Beograd'), ('4', 'Cacak'), ('5', 'Valjevo');

INSERT INTO `mydb`.`provincija` (`id`, `naziv`, `pocetak`, `kraj`) VALUES ('-1', 'Nepoznata', 'nepoznato', 'nepoznato'), ('1', 'Thracia', '1. vek n.e.', '3. vek n.e'),
('2', 'Macedonia', '2. vek n.e.', '3. vek n.e'), ('3', 'Dalmatia', '2. vek p.n.e.', '5. vek n.e');


INSERT INTO `mydb`.`vrstanatpisa` (`id`, `naziv`) VALUES ('1', 'Natpis1'), ('2', 'Natpis2'), ('3', 'Natpis3');

INSERT INTO `mydb`.`mesto`(`id`, `naziv`)  VALUES ('-1', 'Nepoznato'), ('1', 'Aleksandrovac'), ('2', 'Kraljevo'),
('3', 'Beograd'), ('4', 'Cacak'), ('5', 'Valjevo'),('21', 'Vojvodina'), ('31', 'Kosovo');


INSERT INTO `mydb`.`Pleme`(`id`,`naziv`) VALUES(1,'Zupani'), (2,'Varvari'), (3,'Autarijati'), (4,'Singi'), (5,'Varvari'),(7,'Iliri'), (8,'Tracani'), (9,'Grci'),('11', 'Apace'), ('12', 'Sijukas');

INSERT INTO `mydb`.`VrstaNatpisa`(`id`, `naziv`) VALUES(4,'Natpis na kamenu'), (5,'Rimski natpis'), (6, 'Natpis u pecini'), (7, 'Natpis na papiru'), (8,'Turski natpis');

INSERT INTO `mydb`.`Jezik`(`id`,`naziv`,`kod`) VALUES(1,'Srpski','s'), (2,'Staroslovenski','ss'),(3,'Makedonski','m'),(4,'Grcki','g'),(5, 'latinski','l2');

INSERT INTO `mydb`.`Ustanova`( `id`,`naziv`,`modernoMesto`) VALUES(1,'Arheoloski Muzej', 1), (2,'Narodni Muzej',1), (3,'Prirodnjacki Muzej Kalemegdan',1),(4,'Narodni Muzej',3);

INSERT INTO `mydb`.`korisnik` (`korisnickoIme`, `sifra`, `ime`,`prezime`,`email`,`institucija`,`dodatneInformacije`,`privilegije`,`datumRegistrovanja`,`status`) VALUES 
('Mirko','pr10','Mirko','Ivic','mivic@hotmail.com','ibm','prazno','l3', STR_TO_DATE('12-12-2014','%d-%m-%Y'),'0');

/*poligon 1*/
INSERT INTO `mydb`.`POLIGON`(`id`) VALUES(1);

INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(1,44.757187,20.362832);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(2,44.738015, 20.353249);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(3,44.723380, 20.395134);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(4,44.747769, 20.400970);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(5, 44.749476, 20.380714);

INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(1,1,1);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(1,2,2);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(1,3,3);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(1,4,4);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(1,5,5);

/*poligon 2*/
INSERT INTO `mydb`.`POLIGON`(`id`) VALUES(2);

INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(6,44.829151, 20.453155);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(7,44.823247, 20.446890);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(8,44.820446, 20.451782);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(9,44.826108, 20.4547860);

INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(2,6,6);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(2,7,7);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(2,8,8);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(2,9,9);

/*poligon 3*/
INSERT INTO `mydb`.`POLIGON`(`id`) VALUES(3);

INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(10,44.741994, 20.527884);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(11,44.741019, 20.500418);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(12,44.742970, 20.491835);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(13,44.757355, 20.507285);

INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(3,10,10);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(3,11,11);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(3,12,12);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(3,13,13);

/*poligon4*/
INSERT INTO `mydb`.`POLIGON`(`id`) VALUES(4);

INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(14,44.820035, 20.458107);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(15,44.820408, 20.458568);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(16,44.819601, 20.459727);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(17,44.819251, 20.459169);

INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(4,14,14);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(4,15,15);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(4,16,16);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(4,17,17);

/*poligon 5*/
INSERT INTO `mydb`.`POLIGON`(`id`) VALUES(5);

INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(18,43.695321, 20.641763);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(19,43.693242, 20.644552);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`) VALUES(20,43.695135, 20.648544);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(21,43.700471, 20.644295);
INSERT INTO `mydb`.`tacka`(`id`, `latituda`, `longituda`)VALUES(22,43.699354, 20.641076);

INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(5,18,18);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(5,19,19);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(5,20,20);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(5,21,21);
INSERT INTO `mydb`.`TackePoligona`(`poligon`, `redniBroj`, `koordinata`) VALUES(5,22,22);

/*poligon 6*/
INSERT INTO `mydb`.`POLIGON`(`id`) VALUES(6);
INSERT INTO `mydb`.`tacka` (`id`, `latituda`, `longituda`) VALUES ('101', '44.7866','20.4489'), ('102', '45.2671','19.8335');
INSERT INTO `mydb`.`tackepoligona` (`poligon`, `rednibroj`, `koordinata`) VALUES ('6', '101','101'), ('6', '102','102');

/*objekat 1*/

INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`,`vrstaNatpisa`,`jezik`,`provincija`,`grad`,`mesto`,`pleme`,`modernaDrzava`,`modernoMesto`,`ustanova`,`korisnickoIme`,
`faza`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) 
VALUES ('1','O2','Natpis','1','2','1','1','21','11','1','1','3','Mirko', 'faza1', STR_TO_DATE('12-12-2013', '%d-%m-%Y'), STR_TO_DATE('12-12-2013','%d-%m-%Y'), 1, 1);
INSERT INTO `mydb`.`dodatniopis` (`id`, `objekat`) VALUES ('1', '1');
INSERT INTO `mydb`.`bog` (`id`, `ime`) VALUES ('1', 'zevs');
INSERT INTO `mydb`.`bibliografskipodatak` (`id`, `skracenica`, `naslov`,`putanja`) VALUES ('1', 'skr','naslov','path');
INSERT INTO `mydb`.`izvodbibliografskogpodatka` (`objekat`, `bibliografskiPodatak`, `strana`,`putanja`) VALUES ('1', '1','3','path');
INSERT INTO `mydb`.`osoba` (`id`, `name`, `praenomen`,`nomen`,`cognomen`,`agnomen`,`tribus`,`origo`) VALUES ('1','herkul','zeus','alkmena','nema','nema','nema','ne');
INSERT INTO `mydb`.`vojnajedinica` (`id`, `legija`, `pomocniOdred`) VALUES ('1', 'f2','nema');
INSERT INTO `mydb`.`fotografija` VALUES ('1','SL','img','1');
INSERT INTO `mydb`.`podesavanja` (`id`, `naziv`, `tip`,`vrednost`) VALUES ('1', 'pod1','tip1','vr100'),('2', 'pod2','tip2','vr101');

 /*objekat 2*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`,`vrstaNatpisa`,`jezik`,`provincija`,`grad`,`mesto`,`pleme`,`modernaDrzava`,`modernoMesto`,`ustanova`,`korisnickoIme`,
`faza`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) 
VALUES ('2','O2','Natpis','4','4','2','3','5','1','1','3','3','Mirko', 'zavrsnaFaza', STR_TO_DATE('12-01-2015','%d-%m-%Y'), STR_TO_DATE('12-01-2015','%d-%m-%Y'), 1, 1);
INSERT INTO `mydb`.`dodatniopis` (`id`, `objekat`) VALUES ('2', '2');
INSERT INTO `mydb`.`bog` (`id`, `ime`) VALUES ('2', 'atina');
INSERT INTO `mydb`.`osoba` (`id`, `name`, `praenomen`,`nomen`,`cognomen`,`agnomen`,`tribus`,`origo`) VALUES ('2','herkul','atina','alkmena','nema','nema','nema','ne');
/*objekat 3*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`,`vrstaNatpisa`,`jezik`,`provincija`,`grad`,`mesto`,`pleme`,`modernaDrzava`,`modernoMesto`,`ustanova`,`korisnickoIme`,
`faza`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) 
VALUES ('3','O3','Natpis2','7','1','1','2','2','1','1','3','4','Mirko', 'zavrsnaFaza', STR_TO_DATE('12-01-2015','%d-%m-%Y'), STR_TO_DATE('12-01-2015','%d-%m-%Y'), 1, 1);
INSERT INTO `mydb`.`dodatniopis` (`id`, `objekat`) VALUES ('3', '3');
INSERT INTO `mydb`.`bog` (`id`, `ime`) VALUES ('3', 'atina');
INSERT INTO `mydb`.`osoba` (`id`, `name`, `praenomen`,`nomen`,`cognomen`,`agnomen`,`tribus`,`origo`) VALUES ('3','herkul','atina','alkmena','nema','nema','nema','ne');


/* geoloska mesta*/
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(1,1);
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(2,1);
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(3,1);
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(4,1);
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(5,3);
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(6,1);


/*geoloska drzava*/
INSERT INTO `mydb`.`GeoDrzava`(`poligon`, `drzava`) VALUES(1,1);
INSERT INTO `mydb`.`GeoDrzava`(`poligon`, `drzava`) VALUES(2,1);
INSERT INTO `mydb`.`GeoDrzava`(`poligon`, `drzava`) VALUES(3,1);
INSERT INTO `mydb`.`GeoDrzava`(`poligon`, `drzava`) VALUES(4,1);
INSERT INTO `mydb`.`GeoDrzava`(`poligon`, `drzava`) VALUES(5,1);
INSERT INTO `mydb`.`geodrzava` (`poligon`, `drzava`) VALUES ('6','1');

INSERT INTO `mydb`.`geoustanova` (`tacka`,`ustanova`) VALUES ('101', '3'), ('102', '4');

LOCK TABLES `mydb`.`recnik` WRITE;
INSERT INTO `mydb`.`recnik` VALUES ('a',2),('ac',3),('accumsan',1),('adipiscing',1),('aliquam',2),('amet',3),('ante',2),('arcu',1),('auctor',1),('augue',2),('bibendum',3),('blandit',1),('condimentum',1),('consectetur',2),('consequat',1),('Cras',1),('Curabitur',1),('dapibus',1),('diam',1),('dictum',1),('dignissim',1),('dolor',4),('Donec',1),('Duis',1),('efficitur',2),('eget',4),('eleifend',2),('elit',2),('enim',1),('erat',2),('est',1),('et',4),('eu',1),('facilisi',1),('facilisis',1),('fames',1),('faucibus',2),('felis',2),('feugiat',2),('fringilla',4),('Fusce',2),('hendrerit',2),('id',3),('in',2),('Integer',2),('Interdum',1),('ipsum',2),('justo',1),('leo',2),('libero',3),('lobortis',2),('Lorem',2),('luctus',2),('magna',1),('malesuada',3),('massa',1),('mattis',1),('Mauris',3),('maximus',2),('molestie',1),('mollis',1),('nec',1),('neque',1),('nibh',1),('nisi',1),('nisl',1),('non',2),('Nulla',3),('Nullam',1),('nunc',2),('odio',2),('pharetra',2),('Phasellus',1),('porta',2),('posuere',4),('Praesent',1),('primis',1),('Proin',5),('pulvinar',2),('purus',2),('quis',3),('Quisque',1),('rhoncus',1),('risus',3),('rutrum',2),('sagittis',3),('sapien',1),('sed',8),('sem',1),('sit',3),('sodales',1),('suscipit',2),('Suspendisse',2),('tellus',2),('tempor',2),('tincidunt',2),('turpis',1),('ultrices',1),('ultricies',1),('urna',3),('ut',2),('varius',1),('vehicula',1),('vel',5),('velit',1),('venenatis',1),('vestibulum',1),('vitae',2),('Vivamus',3),('volutpat',1),('vulputate',1);



















