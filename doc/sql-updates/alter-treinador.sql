ALTER TABLE `treinador` DROP `idMapa`, DROP `x`, DROP `y`, DROP `nome`, DROP `dinheiro`;
ALTER TABLE `treinador` ADD `nome` VARCHAR(128) NOT NULL AFTER `id`;
ALTER TABLE `treinador` DROP `idGravacao`;