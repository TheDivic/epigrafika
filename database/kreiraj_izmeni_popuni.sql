
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `mydb` ;
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Provincija`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Provincija` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Provincija` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  `pocetak` VARCHAR(45) NOT NULL ,
  `kraj` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Grad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Grad` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Grad` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Mesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Mesto` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Mesto` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Pleme`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Pleme` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Pleme` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`VrstaNatpisa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`VrstaNatpisa` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`VrstaNatpisa` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Jezik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Jezik` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Jezik` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  `kod` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`ModernaDrzava`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`ModernaDrzava` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`ModernaDrzava` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`ModernoMesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`ModernoMesto` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`ModernoMesto` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  `modernaDrzava` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ModernoMesto_ModernaDrzava1_idx` (`modernaDrzava` ASC) ,
  CONSTRAINT `fk_ModernoMesto_ModernaDrzava1`
    FOREIGN KEY (`modernaDrzava` )
    REFERENCES `mydb`.`ModernaDrzava` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ustanova`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Ustanova` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Ustanova` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL ,
  `modernoMesto` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Ustanova_ModernoMesto1_idx` (`modernoMesto` ASC) ,
  CONSTRAINT `fk_Ustanova_ModernoMesto1`
    FOREIGN KEY (`modernoMesto` )
    REFERENCES `mydb`.`ModernoMesto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Korisnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Korisnik` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Korisnik` (
  `korisnickoIme` VARCHAR(20) NOT NULL ,
  `sifra` CHAR(100) NOT NULL ,
  `ime` VARCHAR(45) NOT NULL ,
  `prezime` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `institucija` VARCHAR(100) NOT NULL ,
  `dodatneInformacije` VARCHAR(45) NULL ,
  `mod` VARCHAR(20) NOT NULL ,
  `datumRegistrovanja` DATE NOT NULL ,
  `status` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`korisnickoIme`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Objekat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Objekat` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Objekat` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `oznaka` VARCHAR(15) NOT NULL ,
  `tekstNatpisa` VARCHAR(1000) NOT NULL ,
  `vrstaNatpisa` INT NOT NULL ,
  `jezik` INT NOT NULL ,
  `provincija` INT NOT NULL ,
  `grad` INT NOT NULL ,
  `mesto` INT NOT NULL ,
  `pleme` INT NOT NULL ,
  `modernaDrzava` INT NOT NULL ,
  `modernoMesto` INT NOT NULL ,
  `ustanova` INT NOT NULL ,
  `pocetakGodina` INTEGER NULL ,
  `pocetakVek` TINYINT NULL ,
  `pocetakOdrednica` VARCHAR(15) NULL ,
  `krajGodina` INTEGER NULL ,
  `krajVek` TINYINT NULL ,
  `krajOdrednica` VARCHAR(15) NULL ,
  `tip` VARCHAR(45) NULL ,
  `materijal` VARCHAR(45) NULL ,
  `dimenzije` VARCHAR(20) NULL ,
  `komentar` VARCHAR(1000) NULL ,
  `faza` VARCHAR(45) NOT NULL ,
  `korisnickoIme` VARCHAR(20) NOT NULL ,
  `datumKreiranja` DATE NOT NULL ,
  `datumPoslednjeIzmene` DATE NOT NULL ,
  `datovano` TINYINT(1) NOT NULL ,
  `lokalizovano` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Objekat_Jezik_idx` (`jezik` ASC) ,
  INDEX `fk_Objekat_VrstaNatpisa1_idx` (`vrstaNatpisa` ASC) ,
  INDEX `fk_Objekat_Provincija1_idx` (`provincija` ASC) ,
  INDEX `fk_Objekat_Grad1_idx` (`grad` ASC) ,
  INDEX `fk_Objekat_Mesto1_idx` (`mesto` ASC) ,
  INDEX `fk_Objekat_Pleme1_idx` (`pleme` ASC) ,
  INDEX `fk_Objekat_ModernoMesto1_idx` (`modernoMesto` ASC) ,
  INDEX `fk_Objekat_Ustanova1_idx` (`ustanova` ASC) ,
  INDEX `fk_Objekat_Korisnik1_idx` (`korisnickoIme` ASC) ,
  INDEX `fk_Objekat_ModernaDrzava1_idx` (`modernaDrzava` ASC) ,
  CONSTRAINT `fk_Objekat_Jezik`
    FOREIGN KEY (`jezik` )
    REFERENCES `mydb`.`Jezik` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_VrstaNatpisa1`
    FOREIGN KEY (`vrstaNatpisa` )
    REFERENCES `mydb`.`VrstaNatpisa` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_Provincija1`
    FOREIGN KEY (`provincija` )
    REFERENCES `mydb`.`Provincija` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_Grad1`
    FOREIGN KEY (`grad` )
    REFERENCES `mydb`.`Grad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_Mesto1`
    FOREIGN KEY (`mesto` )
    REFERENCES `mydb`.`Mesto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_Pleme1`
    FOREIGN KEY (`pleme` )
    REFERENCES `mydb`.`Pleme` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_ModernoMesto1`
    FOREIGN KEY (`modernoMesto` )
    REFERENCES `mydb`.`ModernoMesto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_Ustanova1`
    FOREIGN KEY (`ustanova` )
    REFERENCES `mydb`.`Ustanova` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_Korisnik1`
    FOREIGN KEY (`korisnickoIme` )
    REFERENCES `mydb`.`Korisnik` (`korisnickoIme` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objekat_ModernaDrzava1`
    FOREIGN KEY (`modernaDrzava` )
    REFERENCES `mydb`.`ModernaDrzava` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`BibliografskiPodatak`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`BibliografskiPodatak` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`BibliografskiPodatak` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `skracenica` VARCHAR(20) NOT NULL ,
  `naslov` VARCHAR(45) NOT NULL ,
  `putanja` VARCHAR(256) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`IzvodBibliografskogPodatka`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`IzvodBibliografskogPodatka` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`IzvodBibliografskogPodatka` (
  `objekat` INT NOT NULL ,
  `bibliografskiPodatak` INT NOT NULL ,
  `strana` TINYINT NOT NULL ,
  `putanja` VARCHAR(256) NOT NULL ,
  PRIMARY KEY (`objekat`, `bibliografskiPodatak`, `strana`) ,
  INDEX `fk_IzvodBibliografskogPodatka_Objekat1_idx` (`objekat` ASC) ,
  INDEX `fk_IzvodBibliografskogPodatka_BibliografskiPodatak1_idx` (`bibliografskiPodatak` ASC) ,
  CONSTRAINT `fk_IzvodBibliografskogPodatka_Objekat1`
    FOREIGN KEY (`objekat` )
    REFERENCES `mydb`.`Objekat` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_IzvodBibliografskogPodatka_BibliografskiPodatak1`
    FOREIGN KEY (`bibliografskiPodatak` )
    REFERENCES `mydb`.`BibliografskiPodatak` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`DodatniOpis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`DodatniOpis` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`DodatniOpis` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `objekat` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_DodatniOpis_Objekat1_idx` (`objekat` ASC) ,
  CONSTRAINT `fk_DodatniOpis_Objekat1`
    FOREIGN KEY (`objekat` )
    REFERENCES `mydb`.`Objekat` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Bog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Bog` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Bog` (
  `id` INT NOT NULL ,
  `ime` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Bog_DodatniOpis1_idx` (`id` ASC) ,
  CONSTRAINT `fk_Bog_DodatniOpis1`
    FOREIGN KEY (`id` )
    REFERENCES `mydb`.`DodatniOpis` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Osoba`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Osoba` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Osoba` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `praenomen` VARCHAR(45) NULL ,
  `nomen` VARCHAR(45) NULL ,
  `cognomen` VARCHAR(45) NULL ,
  `agnomen` VARCHAR(45) NULL ,
  `tribus` VARCHAR(45) NULL ,
  `origo` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Osoba_DodatniOpis1_idx` (`id` ASC) ,
  CONSTRAINT `fk_Osoba_DodatniOpis1`
    FOREIGN KEY (`id` )
    REFERENCES `mydb`.`DodatniOpis` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`VojnaJedinica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`VojnaJedinica` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`VojnaJedinica` (
  `id` INT NOT NULL ,
  `legija` VARCHAR(45) NOT NULL ,
  `pomocniOdred` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_VojnaJedinica_DodatniOpis1_idx` (`id` ASC) ,
  CONSTRAINT `fk_VojnaJedinica_DodatniOpis1`
    FOREIGN KEY (`id` )
    REFERENCES `mydb`.`DodatniOpis` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Fotografija`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Fotografija` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Fotografija` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  `putanja` VARCHAR(256) NOT NULL ,
  `objekat` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Fotografija_Objekat1_idx` (`objekat` ASC) ,
  CONSTRAINT `fk_Fotografija_Objekat1`
    FOREIGN KEY (`objekat` )
    REFERENCES `mydb`.`Objekat` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Podesavanja`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Podesavanja` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Podesavanja` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  `tip` VARCHAR(45) NOT NULL ,
  `vrednost` VARCHAR(500) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Poligon`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Poligon` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Poligon` (
  `id` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Tacka`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Tacka` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Tacka` (
  `id` INT NOT NULL ,
  `latituda` FLOAT NOT NULL ,
  `longituda` FLOAT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`TackePoligona`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`TackePoligona` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`TackePoligona` (
  `poligon` INT NOT NULL ,
  `redniBroj` INT NOT NULL ,
  `koordinata` INT NOT NULL ,
  PRIMARY KEY (`poligon`, `redniBroj`) ,
  INDEX `fk_Sadrzi_Tacka1_idx` (`koordinata` ASC) ,
  CONSTRAINT `fk_Sadrzi_Poligon1`
    FOREIGN KEY (`poligon` )
    REFERENCES `mydb`.`Poligon` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sadrzi_Tacka1`
    FOREIGN KEY (`koordinata` )
    REFERENCES `mydb`.`Tacka` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`GeoMesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`GeoMesto` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`GeoMesto` (
  `poligon` INT NOT NULL ,
  `mesto` INT NOT NULL ,
  PRIMARY KEY (`poligon`, `mesto`) ,
  INDEX `fk_GeoMesto_ModernoMesto1_idx` (`mesto` ASC) ,
  CONSTRAINT `fk_GeoMesto_Poligon1`
    FOREIGN KEY (`poligon` )
    REFERENCES `mydb`.`Poligon` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GeoMesto_ModernoMesto1`
    FOREIGN KEY (`mesto` )
    REFERENCES `mydb`.`ModernoMesto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`GeoDrzava`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`GeoDrzava` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`GeoDrzava` (
  `poligon` INT NOT NULL ,
  `drzava` INT NOT NULL ,
  PRIMARY KEY (`poligon`, `drzava`) ,
  INDEX `fk_GeoDrzava_ModernaDrzava1_idx` (`drzava` ASC) ,
  CONSTRAINT `fk_GeoDrzava_Poligon1`
    FOREIGN KEY (`poligon` )
    REFERENCES `mydb`.`Poligon` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GeoDrzava_ModernaDrzava1`
    FOREIGN KEY (`drzava` )
    REFERENCES `mydb`.`ModernaDrzava` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`GeoUstanova`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`GeoUstanova` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`GeoUstanova` (
  `tacka` INT NOT NULL ,
  `ustanova` INT NOT NULL ,
  PRIMARY KEY (`tacka`, `ustanova`) ,
  INDEX `fk_GeoUstanova_Ustanova1_idx` (`ustanova` ASC) ,
  CONSTRAINT `fk_GeoUstanova_Tacka1`
    FOREIGN KEY (`tacka` )
    REFERENCES `mydb`.`Tacka` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GeoUstanova_Ustanova1`
    FOREIGN KEY (`ustanova` )
    REFERENCES `mydb`.`Ustanova` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mydb.recnik`.`recnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`recnik` ;

CREATE TABLE IF NOT EXISTS `mydb`.`recnik` (
  `rec` VARCHAR(15) NOT NULL,
  `brojPonavljanja` INT NULL DEFAULT 1,
  PRIMARY KEY (`rec`))
ENGINE = InnoDB;

USE `mydb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;




ALTER TABLE `mydb`.`korisnik` CHANGE `mod` `privilegije` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `mydb`.`korisnik` CHANGE `sifra` `sifra` CHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

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

/*objekat 4*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`, `vrstaNatpisa`, `jezik`, `provincija`, `grad`, `mesto`, `pleme`, `modernaDrzava`, `modernoMesto`, `ustanova`, `pocetakGodina`, `pocetakVek`, `pocetakOdrednica`, `krajGodina`, `krajVek`, `krajOdrednica`, `tip`, `materijal`, `dimenzije`, `komentar`, `faza`, `korisnickoIme`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) VALUES (NULL, 'O4', 'Natpis4', '4', '4', '1', '2', '2', '4', '1', '3', '4', NULL, '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zavrsnaFaza', 'Mirko', '2015-01-14', '2015-01-14', '1', '1');

/*objekat 5*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`, `vrstaNatpisa`, `jezik`, `provincija`, `grad`, `mesto`, `pleme`, `modernaDrzava`, `modernoMesto`, `ustanova`, `pocetakGodina`, `pocetakVek`, `pocetakOdrednica`, `krajGodina`, `krajVek`, `krajOdrednica`, `tip`, `materijal`, `dimenzije`, `komentar`, `faza`, `korisnickoIme`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) VALUES (NULL, 'O45', 'Natpis45', '4', '4', '1', '4', '3', '1', '1', '3', '4', NULL, '20', 'drugaPolovina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zavrsnaFaza', 'Mirko', '2015-01-14', '2015-01-14', '1', '1');

/*objekat 6*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`, `vrstaNatpisa`, `jezik`, `provincija`, `grad`, `mesto`, `pleme`, `modernaDrzava`, `modernoMesto`, `ustanova`, `pocetakGodina`, `pocetakVek`, `pocetakOdrednica`, `krajGodina`, `krajVek`, `krajOdrednica`, `tip`, `materijal`, `dimenzije`, `komentar`, `faza`, `korisnickoIme`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) VALUES (NULL, 'O6', 'Natpis6', '4', '4', '1', '4', '3', '1', '1', '3', '4', '1991', '20', 'drugaPolovina', NULL, '21', NULL, NULL, NULL, NULL, NULL, 'zavrsnaFaza', 'Mirko', '2015-01-14', '2015-01-14', '1', '1');

/*objekat 7*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`, `vrstaNatpisa`, `jezik`, `provincija`, `grad`, `mesto`, `pleme`, `modernaDrzava`, `modernoMesto`, `ustanova`, `pocetakGodina`, `pocetakVek`, `pocetakOdrednica`, `krajGodina`, `krajVek`, `krajOdrednica`, `tip`, `materijal`, `dimenzije`, `komentar`, `faza`, `korisnickoIme`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) VALUES (NULL, 'O7', 'Natpis7', '4', '4', '1', '4', '3', '1', '1', '3', '4', NULL, '20', 'prvaPolovina', NULL, '21', NULL, NULL, NULL, NULL, NULL, 'zavrsnaFaza', 'Mirko', '2015-01-14', '2015-01-14', '1', '1');

/*objekat 8*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`, `vrstaNatpisa`, `jezik`, `provincija`, `grad`, `mesto`, `pleme`, `modernaDrzava`, `modernoMesto`, `ustanova`, `pocetakGodina`, `pocetakVek`, `pocetakOdrednica`, `krajGodina`, `krajVek`, `krajOdrednica`, `tip`, `materijal`, `dimenzije`, `komentar`, `faza`, `korisnickoIme`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) VALUES (NULL, 'O7', 'Natpis7', '4', '4', '1', '4', '3', '1', '1', '3', '4', NULL, '20', 'prvaPolovina', '2003', '21', 'prvaPolovina', NULL, NULL, NULL, NULL, 'zavrsnaFaza', 'Mirko', '2015-01-14', '2015-01-14', '1', '1');

/*objekat 9*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`, `vrstaNatpisa`, `jezik`, `provincija`, `grad`, `mesto`, `pleme`, `modernaDrzava`, `modernoMesto`, `ustanova`, `pocetakGodina`, `pocetakVek`, `pocetakOdrednica`, `krajGodina`, `krajVek`, `krajOdrednica`, `tip`, `materijal`, `dimenzije`, `komentar`, `faza`, `korisnickoIme`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) VALUES (NULL, 'O7', 'Natpis7', '4', '4', '1', '4', '3', '1', '1', '3', '4', NULL, '20', 'drugaPolovina', '2003', '21', 'prvaPolovina', NULL, NULL, NULL, NULL, 'zavrsnaFaza', 'Mirko', '2015-01-14', '2015-01-14', '1', '1');

/*objekat 10*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`, `vrstaNatpisa`, `jezik`, `provincija`, `grad`, `mesto`, `pleme`, `modernaDrzava`, `modernoMesto`, `ustanova`, `pocetakGodina`, `pocetakVek`, `pocetakOdrednica`, `krajGodina`, `krajVek`, `krajOdrednica`, `tip`, `materijal`, `dimenzije`, `komentar`, `faza`, `korisnickoIme`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) VALUES (NULL, 'O7', 'Natpis7', '4', '4', '1', '1', '4', '1', '3', '3', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zavrsnaFaza', 'Mirko', '2015-01-14', '2015-01-14', '1', '1');

/*objekat 11*/
INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`, `vrstaNatpisa`, `jezik`, `provincija`, `grad`, `mesto`, `pleme`, `modernaDrzava`, `modernoMesto`, `ustanova`, `pocetakGodina`, `pocetakVek`, `pocetakOdrednica`, `krajGodina`, `krajVek`, `krajOdrednica`, `tip`, `materijal`, `dimenzije`, `komentar`, `faza`, `korisnickoIme`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) VALUES (NULL, 'O2', 'Natpis', '4', '4', '2', '3', '5', '1', '1', '3', '3', '1904', '20', 'prvaPolovina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zavrsnaFaza', 'Mirko', '2015-01-12', '2015-01-12', '1', '1');


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



















