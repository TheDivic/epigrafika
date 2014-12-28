-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb.recnik
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb.recnik
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb.recnik`.`recnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`recnik` ;

CREATE TABLE IF NOT EXISTS `mydb`.`recnik` (
  `rec` VARCHAR(15) NOT NULL,
  `brojPonavljanja` INT NULL DEFAULT 1,
  PRIMARY KEY (`rec`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



