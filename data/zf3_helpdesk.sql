DROP SCHEMA IF EXISTS `zf3_helpdesk` ;
CREATE SCHEMA IF NOT EXISTS `zf3_helpdesk` DEFAULT CHARACTER SET utf8 ;
USE `zf3_helpdesk` ;

DROP TABLE IF EXISTS `zf3_helpdesk`.`users` ;
CREATE TABLE IF NOT EXISTS `zf3_helpdesk`.`users` (
  `id` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email_confirmed` TINYINT(1) NOT NULL,
  `token` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

DROP TABLE IF EXISTS `zf3_helpdesk`.`tickets` ;
CREATE TABLE IF NOT EXISTS `zf3_helpdesk`.`tickets` (
  `id` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(85) NOT NULL,
  `description` LONGTEXT NOT NULL,
  `priority` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tickets_users1_idx` (`user` ASC),
  CONSTRAINT `fk_tickets_users`
    FOREIGN KEY (`user`)
    REFERENCES `zf3_helpdesk`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

DROP TABLE IF EXISTS `zf3_helpdesk`.`attachments` ;
CREATE TABLE IF NOT EXISTS `zf3_helpdesk`.`attachments` (
  `id` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(85) NOT NULL,
  `file` VARCHAR(45) NOT NULL,
  `ticket` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_attachments_tickets_idx` (`ticket` ASC),
  CONSTRAINT `fk_attachments_tickets`
    FOREIGN KEY (`ticket`)
    REFERENCES `zf3_helpdesk`.`tickets` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
