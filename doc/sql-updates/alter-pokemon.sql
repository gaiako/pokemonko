ALTER TABLE `pokemon` CHANGE `idTreinador` `idTreinadorGravacao` INT(11) NULL DEFAULT NULL;

/* Cássio 23/07/2016 */
ALTER TABLE `pokemon` ADD `b_evasiva` INT NOT NULL DEFAULT '0' AFTER `b_precisao`;
ALTER TABLE `pokemon` ADD `b_apaixonado` BOOLEAN NOT NULL DEFAULT FALSE AFTER `b_confuso`;