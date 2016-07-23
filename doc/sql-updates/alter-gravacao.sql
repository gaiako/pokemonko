ALTER TABLE `gravacao` CHANGE `dataCriacao` `dataCadastro` DATETIME NOT NULL;

ALTER TABLE `gravacao` ADD `idMapaInicial` INT NOT NULL AFTER `nome`;
/* Renomear a tabela 'jogador' para 'treinador'