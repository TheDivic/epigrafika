
ALTER TABLE `mydb`.`korisnik` CHANGE `mod` `privilegije` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `korisnik` CHANGE `sifra` `sifra` CHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
