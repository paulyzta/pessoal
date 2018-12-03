-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 01/12/2018 às 23:10
-- Versão do servidor: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- Versão do PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dev_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `listaIPTV`
--

CREATE TABLE `listaIPTV` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` text COLLATE utf8_unicode_ci,
  `grupo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idList` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8_unicode_ci,
  `ano` int(11) NOT NULL,
  `category` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `temporada` int(11) NOT NULL,
  `episodio` int(11) NOT NULL,
  `idTMDB` int(11) NOT NULL,
  `trailler` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poster` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `originalTitle` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `backdrop` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sinopse` text COLLATE utf8_unicode_ci NOT NULL,
  `nota` float NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `listaIPTV`
--
ALTER TABLE `listaIPTV`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `listaIPTV`
--
ALTER TABLE `listaIPTV`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
