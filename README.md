# froxlor-paypal
Some Strings and Scripts to insert for enabling paypal Subscriptions in Froxlor Client Mode.

Important:
Project-Name  zw_pay




##Pre-Settings
ALTER TABLE `froxlor`.`panel_customers`
ADD COLUMN `zw_pay_abo_type` INT(10) NULL,
ADD COLUMN `zw_pay_abo_expire` DATE NULL,
ADD COLUMN `zw_pay_abo_payed` VARCHAR(45) NULL;


