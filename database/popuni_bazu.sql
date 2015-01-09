INSERT INTO `mydb`.`grad` (`id`, `naziv`) VALUES ('1', 'Aleksandrovac'), ('2', 'Kraljevo'),
('3', 'Beograd'), ('4', 'Cacak'), ('5', 'Valjevo');

INSERT INTO `mydb`.`provincija` (`id`, `naziv`, `pocetak`, `kraj`) VALUES ('1', 'Thracia', '1. vek n.e.', '3. vek n.e'),
('2', 'Macedonia', '2. vek n.e.', '3. vek n.e'), ('3', 'Dalmatia', '2. vek p.n.e.', '5. vek n.e');

INSERT INTO `mydb`.`modernadrzava` (`id`, `naziv`) VALUES ('1', 'Srbija'),
('2', 'Makedonija'), ('3', 'Hrvatska');

INSERT INTO `mydb`.`vrstanatpisa` (`id`, `naziv`) VALUES ('1', 'Natpis1'), ('2', 'Natpis2'), ('3', 'Natpis3');


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





/* geoloska mesta*/
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(1,3);
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(2,3);
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(3,3)
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(4,3);
INSERT INTO `mydb`.`GeoMesto`(`poligon`,`mesto`) VALUES(5,2);

