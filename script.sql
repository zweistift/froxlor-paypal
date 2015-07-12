USE FROXLOR;
ALTER TABLE `froxlor`.`panel_customers` 
ENGINE =InnoDB;
CREATE TABLE `froxlor`.`zw_pay_abo` (
  `PK_ABO_ID` INT NOT NULL AUTO_INCREMENT,
  `ABO_KURZ` VARCHAR(10) NULL,
  `ABO_DESC` VARCHAR(45) NULL,
  `ABO_COSTS_MTH` DOUBLE NULL,
  `ABO_COSTS_YEAR` DOUBLE NULL,
  PRIMARY KEY (`PK_ABO_ID`));
ALTER TABLE `froxlor`.`panel_customers`
ADD COLUMN `zw_pay_abo_type` INT(10) NULL,
ADD COLUMN `zw_pay_abo_expire` DATE NULL,
ADD COLUMN `zw_pay_abo_payed` VARCHAR(45) NULL;




CREATE TABLE `froxlor`.`paypal_notifications` (
  `info_ID` INT NOT NULL AUTO_INCREMENT,
  `txn_id` VARCHAR(45) NULL,
  `payer_id` VARCHAR(13) NULL,
  `payment_status` VARCHAR(45) NULL,
  `receiver_mail` VARCHAR(45) NULL,
  `custom` VARCHAR(45) NULL,
  `txn_type` VARCHAR(45) NULL,
  `next_payment_date` VARCHAR(45) NULL,
  `time_created` VARCHAR(45) NULL,
  `reccuring_pyament_id` VARCHAR(45) NULL,
  PRIMARY KEY (`info_ID`));
