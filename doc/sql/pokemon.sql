-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2016 at 02:05 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pokemon`
--

-- --------------------------------------------------------

--
-- Table structure for table `acao`
--

CREATE TABLE `acao` (
  `id` int(11) NOT NULL,
  `nome` varchar(128) NOT NULL,
  `descricao` text NOT NULL,
  `urlDestino` int(11) DEFAULT NULL,
  `idMapaDestino` int(11) DEFAULT NULL,
  `idItemObtido` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ataque`
--

CREATE TABLE `ataque` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` int(11) NOT NULL,
  `especial` tinyint(1) NOT NULL DEFAULT '0',
  `dano` int(11) NOT NULL,
  `recuperacao` int(11) NOT NULL,
  `precisao` int(11) NOT NULL,
  `sempreAcerta` tinyint(1) NOT NULL DEFAULT '0',
  `idEfeito` int(11) DEFAULT NULL,
  `precisaoEfeito` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ataque`
--

INSERT INTO `ataque` (`id`, `nome`, `tipo`, `especial`, `dano`, `recuperacao`, `precisao`, `sempreAcerta`, `idEfeito`, `precisaoEfeito`, `ativo`) VALUES
(1, 'Choque do trovao', 12, 1, 70, 0, 100, 0, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `evolucao`
--

CREATE TABLE `evolucao` (
  `id` int(11) NOT NULL,
  `idPokemon` int(11) NOT NULL,
  `idEvolucao` int(11) NOT NULL,
  `nivelNecessario` int(11) DEFAULT NULL,
  `itemNecessario` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `evolucao`
--

INSERT INTO `evolucao` (`id`, `idPokemon`, `idEvolucao`, `nivelNecessario`, `itemNecessario`, `ativo`) VALUES
(1, 1, 2, 500, 0, 1),
(2, 2, 3, 1000, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gravacao`
--

CREATE TABLE `gravacao` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dataCriacao` datetime NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `nome` varchar(128) NOT NULL,
  `descricao` text NOT NULL,
  `valor` float(7,2) NOT NULL,
  `disponivelNaLoja` tinyint(1) NOT NULL DEFAULT '1',
  `imagem` varchar(128) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jogador`
--

CREATE TABLE `jogador` (
  `id` int(11) NOT NULL,
  `humano` tinyint(1) NOT NULL DEFAULT '1',
  `dificuldade` int(11) DEFAULT '1',
  `idGravacao` int(11) NOT NULL,
  `idMapa` int(11) NOT NULL,
  `x` int(11) NOT NULL DEFAULT '1',
  `y` int(11) NOT NULL DEFAULT '1',
  `nome` varchar(100) NOT NULL,
  `cor` int(11) NOT NULL,
  `dinheiro` float(7,2) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mapa`
--

CREATE TABLE `mapa` (
  `id` int(11) NOT NULL,
  `nome` varchar(128) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mapa_pixel`
--

CREATE TABLE `mapa_pixel` (
  `id` int(11) NOT NULL,
  `idMapa` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `idTerreno` int(11) NOT NULL,
  `idObjeto` int(11) DEFAULT NULL,
  `idAcao` int(11) NOT NULL,
  `aparecePokemon` tinyint(1) NOT NULL DEFAULT '0',
  `possivelCaminhar` tinyint(1) NOT NULL DEFAULT '1',
  `dificuldade` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ops`
--

CREATE TABLE `ops` (
  `id` int(11) NOT NULL,
  `arquivo` text NOT NULL,
  `trace` text NOT NULL,
  `mensagem` text NOT NULL,
  `horario` datetime NOT NULL,
  `ativo` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ops`
--

INSERT INTO `ops` (`id`, `arquivo`, `trace`, `mensagem`, `horario`, `ativo`) VALUES
(1, 'pokemon.dev/', 'Fatal error', 'Thursday 21st of July 2016 12:47:25 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:25', 1),
(2, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:25 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:25', 1),
(3, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:25 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:25', 1),
(4, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:25 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:25', 1),
(5, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:25 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(6, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(7, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(8, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(9, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(10, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(11, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(12, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(13, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(14, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(15, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(16, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(17, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(18, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(19, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(20, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:26', 1),
(21, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:26 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(22, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:27 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(23, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:27 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(24, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:27 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(25, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:27 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(26, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:27 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(27, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:27 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(28, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:27 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(29, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:27 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:27', 1),
(30, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(31, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(32, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(33, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(34, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(35, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(36, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(37, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(38, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(39, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(40, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(41, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(42, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:28', 1),
(43, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:33 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:33', 1),
(44, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:33 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:33', 1),
(45, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(46, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(47, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(48, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(49, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(50, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(51, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(52, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(53, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(54, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(55, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(56, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(57, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(58, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(59, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(60, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(61, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:34 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:34', 1),
(62, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:35 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:35', 1),
(63, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:47:35 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:47:35', 1),
(64, 'pokemon.dev/', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(65, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(66, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(67, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(68, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(69, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(70, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(71, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(72, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(73, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(74, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(75, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(76, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:03 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:03', 1),
(77, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:04 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:04', 1),
(78, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:04 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:04', 1),
(79, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:04 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:04', 1),
(80, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:04 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:04', 1),
(81, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:04 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:04', 1),
(82, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:04 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:04', 1),
(83, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:04 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:04', 1),
(84, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:04 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:04', 1),
(85, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:48 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:48', 1),
(86, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:48 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:48', 1),
(87, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:48 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:48', 1),
(88, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:48 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:48', 1),
(89, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:48 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:48', 1),
(90, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(91, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(92, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(93, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(94, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(95, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(96, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(97, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(98, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(99, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(100, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(101, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(102, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(103, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:49 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:49', 1),
(104, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:50 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:50', 1),
(105, 'pokemon.dev/ops', 'Fatal error', 'Thursday 21st of July 2016 12:48:50 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:48:50', 1),
(106, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(107, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(108, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(109, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(110, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(111, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(112, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(113, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(114, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(115, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:16 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:16', 1),
(116, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:28 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:28', 1),
(117, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(118, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(119, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(120, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(121, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(122, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(123, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(124, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(125, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(126, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:49:29 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:49:29', 1),
(127, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(128, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(129, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(130, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(131, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(132, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(133, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(134, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(135, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1),
(136, 'pokemon.dev/ops/', 'Fatal error', 'Thursday 21st of July 2016 12:51:58 AM\n\nArray\n(\n    [type] => 1\n    [message] => Class ''ClienteController'' not found\n    [file] => C:\\xampp\\htdocs\\pokemon\\util\\Util.php\n    [line] => 23\n)\n\n\nIP = 127.0.0.1\n\nPOST = Array\n(\n    [senha] => \n)\n', '2016-07-20 19:51:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pokemon`
--

CREATE TABLE `pokemon` (
  `id` int(11) NOT NULL,
  `idPokemonBase` int(11) NOT NULL,
  `idJogador` int(11) DEFAULT NULL,
  `hp` int(11) NOT NULL,
  `ataque` int(11) NOT NULL,
  `defesa` int(11) NOT NULL,
  `especial` int(11) NOT NULL,
  `agilidade` int(11) NOT NULL,
  `experiencia` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `b_precisao` int(11) NOT NULL DEFAULT '100',
  `b_hp` int(11) NOT NULL,
  `b_ataque` int(11) NOT NULL,
  `b_defesa` int(11) NOT NULL,
  `b_especial` int(11) NOT NULL,
  `b_agilidade` int(11) NOT NULL,
  `b_paralisado` tinyint(1) NOT NULL DEFAULT '0',
  `b_queimado` tinyint(1) NOT NULL DEFAULT '0',
  `b_plantado` tinyint(1) NOT NULL DEFAULT '0',
  `b_envenenado` tinyint(1) NOT NULL DEFAULT '0',
  `b_congelado` tinyint(1) NOT NULL DEFAULT '0',
  `b_dormindo` tinyint(1) NOT NULL DEFAULT '0',
  `b_confuso` tinyint(1) NOT NULL DEFAULT '0',
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pokemon_base`
--

CREATE TABLE `pokemon_base` (
  `id` int(1) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `som` varchar(100) DEFAULT NULL,
  `idTipo` int(11) NOT NULL,
  `idTipo2` int(11) DEFAULT NULL,
  `hp` int(11) NOT NULL,
  `ataque` int(11) NOT NULL,
  `defesa` int(11) NOT NULL,
  `agilidade` int(11) NOT NULL,
  `especial` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `sortePokeball` int(11) NOT NULL,
  `nivel` tinyint(4) NOT NULL,
  `raridade` int(11) NOT NULL DEFAULT '1',
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pokemon_base`
--

INSERT INTO `pokemon_base` (`id`, `nome`, `som`, `idTipo`, `idTipo2`, `hp`, `ataque`, `defesa`, `agilidade`, `especial`, `exp`, `sortePokeball`, `nivel`, `raridade`, `ativo`) VALUES
(1, 'Bulbasaur', NULL, 11, 4, 2, 3, 2, 3, 3, 0, 0, 2, 50, 1),
(2, 'Ivysaur', NULL, 11, 4, 3, 3, 3, 4, 3, 0, 0, 3, 50, 1),
(3, 'Venusaur', NULL, 11, 4, 3, 4, 4, 5, 4, 0, 0, 4, 50, 1),
(4, 'Charmander', NULL, 9, NULL, 0, 0, 0, 0, 0, 0, 0, 2, 50, 1),
(5, 'Charmeleon', NULL, 9, NULL, 0, 0, 0, 0, 0, 0, 0, 3, 50, 1),
(6, 'Charizard', NULL, 9, 3, 0, 0, 0, 0, 0, 0, 0, 4, 70, 1),
(7, 'Squirtle', NULL, 10, NULL, 0, 0, 0, 0, 0, 0, 0, 2, 1, 1),
(8, 'Wartortle', NULL, 10, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(9, 'Blastoise', NULL, 10, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(10, 'Caterpie', NULL, 7, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(11, 'Metapod', NULL, 7, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(12, 'Butterfree', NULL, 7, 3, 0, 0, 0, 0, 0, 0, 0, 1, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `terreno`
--

CREATE TABLE `terreno` (
  `id` int(11) NOT NULL,
  `nome` int(11) NOT NULL,
  `imagem` int(11) NOT NULL,
  `bloqueadoUp` tinyint(1) NOT NULL DEFAULT '0',
  `bloqueadoLeft` tinyint(1) NOT NULL DEFAULT '0',
  `bloqueadoRight` tinyint(1) NOT NULL DEFAULT '0',
  `bloqueadoDown` tinyint(1) NOT NULL DEFAULT '0',
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo`
--

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cor` varchar(7) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo`
--

INSERT INTO `tipo` (`id`, `nome`, `cor`, `ativo`) VALUES
(1, 'Normal', '', 1),
(2, 'Lutador', '#DE8833', 1),
(3, 'Voador', '#8888EE', 1),
(4, 'Veneno', '#A158A1', 1),
(5, 'Terra', '#B29F51', 1),
(6, 'Pedra', '#CCCCCC', 1),
(7, 'Inseto', '#ACB840', 1),
(8, 'Fantasma', '#7B699A', 1),
(9, 'Fogo', '#FF2222', 1),
(10, 'Ãgua', '#0055FF', 1),
(11, 'Planta', '#33DD33', 1),
(12, 'ElÃ©trico', '#F8D54A', 1),
(13, 'PsÃ­quico', '#FF00FF', 1),
(14, 'Gelo', '#00AAFF', 1),
(15, 'DragÃ£o', '#00FFFF', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acao`
--
ALTER TABLE `acao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ataque`
--
ALTER TABLE `ataque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evolucao`
--
ALTER TABLE `evolucao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gravacao`
--
ALTER TABLE `gravacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapa`
--
ALTER TABLE `mapa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapa_pixel`
--
ALTER TABLE `mapa_pixel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idMapa` (`idMapa`,`x`,`y`);

--
-- Indexes for table `pokemon`
--
ALTER TABLE `pokemon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pokemon_base`
--
ALTER TABLE `pokemon_base`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terreno`
--
ALTER TABLE `terreno`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acao`
--
ALTER TABLE `acao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ataque`
--
ALTER TABLE `ataque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `evolucao`
--
ALTER TABLE `evolucao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gravacao`
--
ALTER TABLE `gravacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mapa`
--
ALTER TABLE `mapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mapa_pixel`
--
ALTER TABLE `mapa_pixel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pokemon`
--
ALTER TABLE `pokemon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pokemon_base`
--
ALTER TABLE `pokemon_base`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `terreno`
--
ALTER TABLE `terreno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
