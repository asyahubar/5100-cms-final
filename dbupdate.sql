SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`recipes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`recipes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL ,
  `time_preparing` INT(6) UNSIGNED NULL ,
  `instructions` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`measurments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`measurments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `title_UNIQUE` (`title` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`ingredients`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`ingredients` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `title_UNIQUE` (`title` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`pivot`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`pivot` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `recipe_id` INT UNSIGNED NOT NULL ,
  `ingredient_id` INT UNSIGNED NOT NULL ,
  `measurment_id` INT UNSIGNED NOT NULL ,
  `ingredient_count` INT NOT NULL ,
  PRIMARY KEY (`id`, `recipe_id`, `ingredient_id`) ,
  INDEX `fk_recepies_has_ingredients_ingredients1_idx` (`ingredient_id` ASC) ,
  INDEX `fk_recepies_has_ingredients_recepies_idx` (`recipe_id` ASC) ,
  INDEX `fk_recepies_has_ingredients_measurments1_idx` (`measurment_id` ASC) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_recepies_has_ingredients_recepies`
    FOREIGN KEY (`recipe_id` )
    REFERENCES `mydb`.`recipes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recepies_has_ingredients_ingredients1`
    FOREIGN KEY (`ingredient_id` )
    REFERENCES `mydb`.`ingredients` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recepies_has_ingredients_measurments1`
    FOREIGN KEY (`measurment_id` )
    REFERENCES `mydb`.`measurments` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`roles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `role_id` INT UNSIGNED NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `nickname`  NOT NULL ,
  PRIMARY KEY (`id`, `role_id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `fk_users_roles1_idx` (`role_id` ASC) ,
  UNIQUE INDEX `nickname_UNIQUE` (`nickname` ASC) ,
  CONSTRAINT `fk_users_roles1`
    FOREIGN KEY (`role_id` )
    REFERENCES `mydb`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mydb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
