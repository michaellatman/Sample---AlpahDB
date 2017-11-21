CREATE TABLE `mlatman`.`a_person` (
  `ap_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `m_inital` VARCHAR(1) NULL DEFAULT NULL,
  `national_rank` INT NULL DEFAULT 0,
  `local_rank` INT NULL DEFAULT 0,
  PRIMARY KEY (`ap_id`));
