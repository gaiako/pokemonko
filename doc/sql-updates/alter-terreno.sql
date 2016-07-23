ALTER TABLE `terreno` CHANGE `imagem` `imagem` INT(11) NULL DEFAULT NULL;
ALTER TABLE `terreno` ADD `cor` VARCHAR(7) NULL AFTER `imagem`;
ALTER TABLE `terreno` CHANGE `nome` `nome` VARCHAR(100) NOT NULL;