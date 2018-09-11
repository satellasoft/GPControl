-- MySQL Script generated by MySQL Workbench
-- Thu Sep  6 17:41:13 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema gerenciadorprojetos
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema gerenciadorprojetos
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `gerenciadorprojetos` DEFAULT CHARACTER SET utf8 ;
USE `gerenciadorprojetos` ;

-- -----------------------------------------------------
-- Table `gerenciadorprojetos`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerenciadorprojetos`.`usuario` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(50) NOT NULL,
  `status` INT(1) NOT NULL,
  `permissao` INT(1) NOT NULL COMMENT '1 = adm\n2 = Comum',
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`cod`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gerenciadorprojetos`.`projeto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerenciadorprojetos`.`projeto` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `descricao` TEXT NOT NULL,
  `thumb` VARCHAR(50) NULL,
  `data` DATETIME NOT NULL,
  `status` INT(1) NOT NULL COMMENT '1 = Ativo\n2 = Desativado',
  `usuario_cod` INT NOT NULL,
  PRIMARY KEY (`cod`),
  INDEX `fk_projeto_usuario1_idx` (`usuario_cod` ASC),
  CONSTRAINT `fk_projeto_usuario1`
    FOREIGN KEY (`usuario_cod`)
    REFERENCES `gerenciadorprojetos`.`usuario` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gerenciadorprojetos`.`usuario_projeto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerenciadorprojetos`.`usuario_projeto` (
  `usuario_cod` INT NOT NULL,
  `projeto_cod` INT NOT NULL,
  PRIMARY KEY (`usuario_cod`, `projeto_cod`),
  INDEX `fk_usuario_has_projeto_projeto1_idx` (`projeto_cod` ASC),
  INDEX `fk_usuario_has_projeto_usuario_idx` (`usuario_cod` ASC),
  CONSTRAINT `fk_usuario_has_projeto_usuario`
    FOREIGN KEY (`usuario_cod`)
    REFERENCES `gerenciadorprojetos`.`usuario` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_projeto_projeto1`
    FOREIGN KEY (`projeto_cod`)
    REFERENCES `gerenciadorprojetos`.`projeto` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gerenciadorprojetos`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerenciadorprojetos`.`categoria` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `status` INT(1) NOT NULL,
  `projeto_cod` INT NOT NULL,
  PRIMARY KEY (`cod`),
  INDEX `fk_categoria_projeto1_idx` (`projeto_cod` ASC),
  CONSTRAINT `fk_categoria_projeto1`
    FOREIGN KEY (`projeto_cod`)
    REFERENCES `gerenciadorprojetos`.`projeto` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gerenciadorprojetos`.`modulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerenciadorprojetos`.`modulo` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(200) NOT NULL,
  `descricao` TEXT NOT NULL,
  `status` INT(1) NOT NULL COMMENT '1 = Ativado\n2 = Resolvido',
  `data` DATETIME NOT NULL,
  `usuario_cod` INT NOT NULL,
  `categoria_cod` INT NOT NULL,
  `projeto_cod` INT NOT NULL,
  PRIMARY KEY (`cod`),
  INDEX `fk_modulo_usuario1_idx` (`usuario_cod` ASC),
  INDEX `fk_modulo_categoria1_idx` (`categoria_cod` ASC),
  INDEX `fk_modulo_projeto1_idx` (`projeto_cod` ASC),
  CONSTRAINT `fk_modulo_usuario1`
    FOREIGN KEY (`usuario_cod`)
    REFERENCES `gerenciadorprojetos`.`usuario` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modulo_categoria1`
    FOREIGN KEY (`categoria_cod`)
    REFERENCES `gerenciadorprojetos`.`categoria` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modulo_projeto1`
    FOREIGN KEY (`projeto_cod`)
    REFERENCES `gerenciadorprojetos`.`projeto` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gerenciadorprojetos`.`resposta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerenciadorprojetos`.`resposta` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `descricao` TEXT NOT NULL,
  `data` DATETIME NOT NULL,
  `modulo_cod` INT NOT NULL,
  `usuario_cod` INT NOT NULL,
  PRIMARY KEY (`cod`),
  INDEX `fk_resposta_modulo1_idx` (`modulo_cod` ASC),
  INDEX `fk_resposta_usuario1_idx` (`usuario_cod` ASC),
  CONSTRAINT `fk_resposta_modulo1`
    FOREIGN KEY (`modulo_cod`)
    REFERENCES `gerenciadorprojetos`.`modulo` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resposta_usuario1`
    FOREIGN KEY (`usuario_cod`)
    REFERENCES `gerenciadorprojetos`.`usuario` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;