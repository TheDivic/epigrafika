
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
  `id` INT NOT NULL ,
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
  `id` INT NOT NULL ,
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
  `sifra` CHAR(32) NOT NULL ,
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
  `pocetakGodina` YEAR NULL ,
  `pocetakVek` TINYINT NULL ,
  `pocetakOdrednica` VARCHAR(15) NULL ,
  `krajGodina` YEAR NULL ,
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

USE `mydb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;




INSERT INTO `mydb`.`provincija` (`id`, `naziv`, `pocetak`, `kraj`) VALUES ('1', 'Thracia', '1. vek n.e.', '3. vek n.e'),
('2', 'Macedonia', '2. vek n.e.', '3. vek n.e'), ('3', 'Dalmatia', '2. vek p.n.e.', '5. vek n.e');

INSERT INTO `mydb`.`grad` (`id`, `naziv`) VALUES ('1', 'Aleksandrovac'), ('2', 'Kraljevo'),
('3', 'Beograd'), ('4', 'Cacak'), ('5', 'Valjevo');

INSERT INTO `mydb`.`mesto` (`id`, `naziv`) VALUES ('11', 'Beograd'), ('21', 'Vojvodina'), ('31', 'Kosovo');


INSERT INTO `mydb`.`pleme` (`id`, `naziv`) VALUES ('11', 'Apace'), ('12', 'Sijukas');

INSERT INTO `mydb`.`vrstanatpisa` (`id`, `naziv`) VALUES ('1', 'Natpis1'), ('2', 'Natpis2'), ('3', 'Natpis3'); 

INSERT INTO `mydb`.`jezik` (`id`, `naziv`, `kod`) VALUES ('1', 'srpski','s1'), ('2', 'latinski','l2');

INSERT INTO `mydb`.`modernadrzava` (`id`, `naziv`) VALUES ('1', 'Srbija'),
('2', 'Makedonija'), ('3', 'Hrvatska');

INSERT INTO `mydb`.`modernomesto` (`id`, `naziv`, `modernaDrzava`) VALUES ('14', 'Beograd','1'), ('15', 'Novi Sad','3');

INSERT INTO `mydb`.`ustanova` (`id`, `naziv`, `modernomesto`) VALUES ('3', 'ustanova1','14'), ('4', 'ustanova2','15');

INSERT INTO `mydb`.`korisnik` (`korisnickoIme`, `sifra`, `ime`,`prezime`,`email`,`institucija`,`dodatneInformacije`,`mod`,`datumRegistrovanja`,`status`) VALUES 
('Mirko','pr10','Mirko','Ivic','mivic@hotmail.com','ibm','prazno','l3','12-12-2014','0');


INSERT INTO `mydb`.`objekat` (`id`, `oznaka`, `tekstNatpisa`,`vrstaNatpisa`,`jezik`,`provincija`,`grad`,`mesto`,`pleme`,`modernaDrzava`,`modernoMesto`,`ustanova`,`korisnickoIme`,
`faza`, `datumKreiranja`, `datumPoslednjeIzmene`, `datovano`, `lokalizovano`) 
VALUES ('1','O1','N','1','2','1','1','21','11','1','14','3','Mirko', 'faza1', '12-12-2013', '12-12-2013', 'true', 'true');

INSERT INTO `mydb`.`bibliografskipodatak` (`id`, `skracenica`, `naslov`,`putanja`) VALUES ('1', 'skr','naslov','path');


INSERT INTO `mydb`.`izvodbibliografskogpodatka` (`objekat`, `bibliografskiPodatak`, `strana`,`putanja`) VALUES ('1', '1','3','path');

INSERT INTO `mydb`.`dodatniopis` (`id`, `objekat`) VALUES ('105', '1');

INSERT INTO `mydb`.`bog` (`id`, `ime`) VALUES ('105', 'zevs');


INSERT INTO `mydb`.`osoba` (`id`, `name`, `praenomen`,`nomen`,`cognomen`,`agnomen`,`tribus`,`origo`) VALUES ('105','herkul','zeus','alkmena','nema','nema','nema','ne');

INSERT INTO `mydb`.`vojnajedinica` (`id`, `legija`, `pomocniOdred`) VALUES ('105', 'f2','nema');

INSERT INTO `mydb`.`fotografija` VALUES ('103','SL','img','1');

INSERT INTO `mydb`.`podesavanja` (`id`, `naziv`, `tip`,`vrednost`) VALUES ('1', 'pod1','tip1','vr100'),('2', 'pod2','tip2','vr101');

INSERT INTO `mydb`.`poligon` (`id`) VALUES ('3'), ('4');

INSERT INTO `mydb`.`tacka` (`id`, `latituda`, `longituda`) VALUES ('101', '32.80','86.10'), ('102', '31.90','92.10');

INSERT INTO `mydb`.`tackepoligona` (`poligon`, `rednibroj`, `koordinata`) VALUES ('3', '1','101'), ('4', '2','102');

INSERT INTO `mydb`.`geomesto` (`poligon`, `mesto`) VALUES ('3','14'), ('4','15');

INSERT INTO `mydb`.`geodrzava` (`poligon`, `drzava`) VALUES ('3','1'), ('4','3');

INSERT INTO `mydb`.`geoustanova` (`tacka`,`ustanova`) VALUES ('101', '3'), ('102', '4');




















