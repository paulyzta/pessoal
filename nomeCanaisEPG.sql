-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 28/12/2018 às 15:21
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
-- Estrutura para tabela `nomeCanaisEPG`
--

CREATE TABLE `nomeCanaisEPG` (
  `id` int(11) NOT NULL,
  `grupo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nomeListaIPTV` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nomeListaCLARO` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `claro_id` int(10) NOT NULL,
  `nomeListaTVMAGAZINE` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `TVMagazine_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `nomeCanaisEPG`
--

INSERT INTO `nomeCanaisEPG` (`id`, `grupo`, `nomeListaIPTV`, `nomeListaCLARO`, `claro_id`, `nomeListaTVMAGAZINE`, `TVMagazine_id`) VALUES
(1, 'Big Brother Brasil', 'BBB', '', 0, '', ''),
(2, 'Canais Globo', 'Globo RJ', 'Globo', 107, '', ''),
(3, 'Canais Globo', 'Globo SP', '', 0, 'Globo SP', 'globo-sp/GSP'),
(4, 'Canais Globo', 'Globo MG', '', 0, '', ''),
(5, 'Canais Globo', 'Globo Nordeste', '', 0, '', ''),
(6, 'Canais Globo', 'Globo RPC TV Curitiba', '', 0, '', ''),
(7, 'Canais Globo', 'Globo RPC Foz do Iguaçu', '', 0, '', ''),
(8, 'Canais Globo', 'Globo RPC TV Paraná', '', 0, '', ''),
(9, 'Canais Globo', 'Globo NSC TV Florianopolis', '', 0, '', ''),
(10, 'Canais Globo', 'Globo NSC TV Chapecó', '', 0, '', ''),
(11, 'Canais Globo', 'Globo RBS TV Porto Alegre', '', 0, '', ''),
(12, 'Canais Globo', 'Globo TV Gazeta Vitória', '', 0, '', ''),
(13, 'Canais Globo', 'Globo TV Gazeta Alagoas', '', 0, '', ''),
(14, 'Canais Globo', 'Globo TV Sergipe', '', 0, '', ''),
(15, 'Canais Globo', 'Globo TV Clube Teresina', '', 0, '', ''),
(16, 'Canais Globo', 'Globo Brasília', '', 0, '', ''),
(17, 'Canais Globo', 'Globo Bahia', '', 0, '', ''),
(18, 'Canais Globo', 'Globo TV Anhanguera Goiânia', '', 0, '', ''),
(19, 'Canais Globo', 'Globo TV Mirante Sao Luis', '', 0, '', ''),
(20, 'Canais Globo', 'Globo TV Morena Campo Grande', '', 0, '', ''),
(21, 'Canais Globo', 'Globo Internacional', '', 0, '', ''),
(22, 'Canais Globo', 'Globo Portugal', '', 0, '', ''),
(23, 'Canais Globo', 'Globo Now', '', 0, '', ''),
(24, 'Globo Regionais', 'Globo InterTV Cabugi', '', 0, '', ''),
(25, 'Globo Regionais', 'Globo Inter TV RN', '', 0, '', ''),
(26, 'Globo Regionais', 'Globo TV Verdes Mares', '', 0, '', ''),
(27, 'Globo Regionais', 'Globo TV Amazonas', '', 0, '', ''),
(28, 'Globo Regionais', 'Globo EPTV Campinas', '', 0, '', ''),
(29, 'Globo Regionais', 'Globo EPTV Ribeirão Preto', '', 0, '', ''),
(30, 'Globo Regionais', 'Globo EPTV São Carlos', '', 0, '', ''),
(31, 'Globo Regionais', 'Globo EPTV Araraquara', '', 0, '', ''),
(32, 'Globo Regionais', 'Globo Tv Tem Sao Jose do Rio Preto', '', 0, '', ''),
(33, 'Globo Regionais', 'Globo Tv Tem Sorocaba', '', 0, '', ''),
(34, 'Globo Regionais', 'Globo Tv Tem Bauru', '', 0, '', ''),
(35, 'Globo Regionais', 'Globo TV Tribuna', '', 0, '', ''),
(36, 'Globo Regionais', 'Globo TV Liberal Belém', '', 0, '', ''),
(37, 'Globo Regionais', 'Globo TV Centro America MT', '', 0, '', ''),
(38, 'Globo Regionais', 'Globo TV Vanguarda S. J. dos Campos', '', 0, '', ''),
(39, 'Canais Abertos', 'RecordTV SP', 'RECORD', 80, 'Record SP', 'record-sp/RHD'),
(40, 'Canais Abertos', 'RecordTV RJ', 'RECORD', 80, '', ''),
(41, 'Canais Abertos', 'RecordTV MG', '', 0, '', ''),
(42, 'Canais Abertos', 'RecordTV DF', '', 0, '', ''),
(43, 'Canais Abertos', 'RecordTV RS', '', 0, '', ''),
(44, 'Canais Abertos', 'RecordTV BA', '', 0, '', ''),
(45, 'Canais Abertos', 'RecordTV Portugal', '', 0, '', ''),
(46, 'Canais Abertos', 'Sbt', 'SBT', 86, 'SBT SP', 'sbt-sp/SBP'),
(47, 'Canais Abertos', 'SBT SP Interior', '', 0, '', ''),
(48, 'Canais Abertos', 'Band', 'BAND', 5, 'BAND', 'band/BAN'),
(49, 'Canais Abertos', 'Rede Tv', 'Rede TV', 240, 'Rede TV!', 'rede-tv/RTV'),
(50, 'Canais Abertos', 'Canal Brasil', 'Canal Brasil', 14, 'Canal Brasil', 'canal-brasil/CBR'),
(51, 'Canais Abertos', 'Futura', 'Futura', 46, '', '-1'),
(52, 'Canais Abertos', 'TV Cultura', 'TV Cultura', 103, 'TV Cultura', 'tv-cultura/CUL'),
(53, 'Canais Abertos', 'TV Brasil', 'TV Brasil', 101, 'TV Brasil', 'tv-brasil/TED'),
(54, 'Canais Abertos', 'TV Gazeta', '', -1, 'TV Gazeta', 'tv-gazeta/GAZ'),
(55, 'Canais Abertos', 'TV Diario', '', -1, '', '-1'),
(56, 'Canais Abertos', 'TV Escola', 'TV Escola', 105, 'TV Escola', 'tv-escola/ESC'),
(57, 'Canais Abertos', 'TV Câmara', 'TV Câmara', 104, 'TV Câmara', 'tv-camara/CAM'),
(58, 'Canais Abertos', 'TV Justica', 'TV Justiça', 108, 'TV Justiça', 'tv-justica/JUS'),
(59, 'Canais Abertos', 'TV Senado', 'TV Senado', 110, 'TV Senado', 'tv-senado/SEN'),
(60, 'Canais Abertos', 'NBR', 'NBR', 69, 'NBR - TV Nacional Brasil', 'nbr--tv-nacional-brasil/NBR'),
(61, 'Canais Abertos', 'Terra Viva', 'Terra Viva', 118, '', '-1'),
(62, 'Canais Abertos', 'Canal Rural', 'Canal Rural', 15, '', '-1'),
(63, 'Canais Abertos', 'Rede Brasil', 'Rede Brasil', 235, '', ''),
(64, 'Noticias', 'Globo News', 'GloboNews', 49, 'Globo News', 'globo-news/GLN'),
(65, 'Noticias', 'Band News', 'Band News', 7, 'Band News', 'band-news/NEW'),
(66, 'Noticias', 'Record News', 'Record News', 81, 'Record News', 'record-news/RCN'),
(67, 'Esportes', 'SporTV', 'SporTV', 93, 'SPORTV', 'sportv/SPO'),
(68, 'Esportes', 'SporTv 2', 'Sportv 2', 94, 'SPORTV 2', 'sportv-2/SP2'),
(69, 'Esportes', 'SporTV 3', 'Sportv 3', 186, 'SPORTV 3', 'sportv-3/SP3'),
(70, 'Esportes', 'Fox Sports', 'Fox Sports', 92, 'FOX Sports', 'fox-sports/FSP'),
(71, 'Esportes', 'Fox Sports 2', 'Fox Sports 2', 248, 'FOX Sports 2', 'fox-sports-2/FS2'),
(72, 'Esportes', 'ESPN Brasil', 'ESPN Brasil', 35, 'ESPN Brasil', 'espn-brasil/ESB'),
(73, 'Esportes', 'ESPN', 'ESPN HD', 290, 'ESPN', 'espn/ESP'),
(74, 'Esportes', 'ESPN 2', 'ESPN +', 143, 'ESPN+', 'espn/ESI'),
(75, 'Esportes', 'ESPN Extra', '', -1, '', '-1'),
(76, 'Esportes', 'Combate', 'Combate', 23, 'Combate', 'combate/135'),
(77, 'Esportes', 'Band Sports', 'Band Sports HD', 292, 'Band Sports', 'band-sports/BSP'),
(78, 'Esportes', 'NBA TV', '', -1, '', ''),
(79, 'Premiere', 'Premiere Clubes', 'Premiere Clubes', 75, 'Premiere Clubes', 'premiere-clubes/121'),
(80, 'Premiere', 'PFC', 'Premiere Clubes', 75, '', ''),
(81, 'Premiere', 'Premiere 2', '', -1, 'Premiere 2', 'premiere-2/9A2'),
(82, 'Premiere', 'Premiere 3', '', -1, 'Premiere 3', 'premiere-3/9A3'),
(83, 'Premiere', 'Premiere 4', '', -1, 'Premiere 4', 'premiere-4/9A4'),
(84, 'Premiere', 'Premiere 5', '', -1, 'Premiere 5', 'premiere-5/9A5'),
(85, 'Premiere', 'Premiere 6', '', -1, 'Premiere 6', 'premiere-6/9A6'),
(86, 'Premiere', 'Premiere 7', '', -1, 'Premiere 7', 'premiere-7/9A7'),
(87, 'Premiere', 'Premiere 8', '', -1, 'Premiere 8 Mosaico', 'premiere-8-mosaico/9A8'),
(88, 'Premiere', 'Premiere 9', '', -1, '', '-1'),
(89, 'Premiere', 'Tabela Jogos Premiere', '', -1, '', '-1'),
(90, 'Globosat Filmes', 'Telecine Premium', 'Telecine Premium HD', 97, 'Telecine Premium', 'telecine-premium/TC1'),
(91, 'Globosat Filmes', 'Telecine Pipoca', 'Telecine Pipoca HD', 98, 'Telecine Pipoca', 'telecine-pipoca/TC4'),
(92, 'Globosat Filmes', 'Telecine Action', 'Telecine Action HD', 145, 'Telecine Action', 'telecine-action/TC2'),
(93, 'Globosat Filmes', 'Telecine Touch', 'Telecine Touch HD', 208, 'Telecine Touch', 'telecine-touch/TC3'),
(94, 'Globosat Filmes', 'Telecine Fun', 'Telecine Fun HD', 209, 'Telecine Fun', 'telecine-fun/TC6'),
(95, 'Globosat Filmes', 'Telecine Cult', 'Telecine Cult', 113, 'Telecine Cult', 'telecine-cult/TC5'),
(96, 'Globosat Filmes', 'MegaPix', 'Megapix HD', 286, 'Megapix', 'megapix/MPX'),
(97, 'Globosat Filmes', 'Universal TV', 'Universal Channel HD', 285, 'Universal Channel', 'universal-channel/USA'),
(98, 'Globosat Filmes', 'Studio Universal', 'Studio Universal', 95, 'Studio Universal', 'studio-universal/HAL'),
(99, 'Globosat Filmes', 'Syfy', 'Syfy', 88, 'Syfy', 'syfy/SCI'),
(100, 'Rede HBO - MAX', 'HBO', 'HBO', 56, 'HBO', 'hbo/HBO'),
(101, 'Rede HBO - MAX', 'HBO 2', 'HBO 2', 50, 'HBO 2', 'hbo-2/HB2'),
(102, 'Rede HBO - MAX', 'HBO Signature', 'HBO Signature', 51, 'HBO Signature', 'hbo-signature/HFE'),
(103, 'Rede HBO - MAX', 'HBO Family', 'HBO Family', 52, 'HBO Family', 'hbo-family/HFA'),
(104, 'Rede HBO - MAX', 'HBO Plus', 'HBO Plus', 55, 'HBO Plus', 'hbo-plus/HPL'),
(105, 'Rede HBO - MAX', 'HBO Plus e', 'HBO Plus *e', 54, 'HBO Plus E', 'hbo-plus-e/HPE'),
(106, 'Rede HBO - MAX', 'Max Prime', 'Max Prime', 65, 'Max Prime', 'max-prime/MAP'),
(107, 'Rede HBO - MAX', 'MAX Prime e', 'Max Prime *e', 66, 'Max Prime *e', 'max-prime-e/MPE'),
(108, 'Rede HBO - MAX', 'Max UP', '', -1, 'Max Up', 'max-up/MAX'),
(109, 'Rede HBO - MAX', 'Max', 'Max', 21, 'Max', 'max/MXE'),
(110, 'Filmes E Series', 'Warner Channel', 'Warner Channel', 124, 'Warner Channel', 'warner-channel/WBT'),
(111, 'Filmes E Series', 'Cinemax', 'Cinemax', 19, 'Cinemax', 'cinemax/MNX'),
(112, 'Filmes E Series', 'Space', 'Space', 91, 'Space', 'space/SPA'),
(113, 'Filmes E Series', 'Paramount', 'Paramount', 123, 'Paramount Channel', 'paramount-channel/PAR'),
(114, 'Filmes E Series', 'TNT', 'TNT', 100, 'TNT', 'tnt/TNT'),
(115, 'Filmes E Series', 'TNT Séries', '', -1, 'TNT Séries', 'tnt-series/TNS'),
(116, 'Filmes E Series', 'AMC', '', -1, '', '-1'),
(117, 'Filmes E Series', 'AXN', 'AXN', 2, 'AXN', 'axn/AXN'),
(118, 'Filmes E Series', 'Fox', 'FOX', 40, 'FOX', 'fox/FOX'),
(119, 'Filmes E Series', 'Fox Premium 1', '', -1, '', '-1'),
(120, 'Filmes E Series', 'Fox Premium 2', '', -1, '', '-1'),
(121, 'Filmes E Series', 'Fox Life', 'Fox Life', 249, 'FOX Life', 'fox-life/FLI'),
(122, 'Filmes E Series', 'FX', 'FX', 42, 'FX', 'fx/CFX'),
(123, 'Filmes E Series', 'Sony', 'Sony', 90, 'Sony', 'sony/SET'),
(124, 'Filmes E Series', 'TBS', 'TBS', 224, 'TBS', 'tbs/TBS'),
(125, 'Filmes E Series', 'TCM', 'TCM', 96, 'TCM', 'tcm/TCM'),
(126, 'Filmes E Series', 'Film & Arts', '', -1, 'Film &amp; Arts', 'film--arts/BRA'),
(127, 'Filmes E Series', 'I-Sat', '', -1, '', '-1'),
(128, 'Documentarios', 'Animal Planet', 'Animal Planet', 3, 'Animal Planet', 'animal-planet/APL'),
(129, 'Documentarios', 'Discovery Channel', 'Discovery Channel', 28, 'Discovery Channel', 'discovery-channel/DIS'),
(130, 'Documentarios', 'Discovery Turbo', 'Discovery Turbo', 147, 'Discovery Turbo', 'discovery-turbo/DTU'),
(131, 'Documentarios', 'Discovery H&H', 'Discovery Home &amp; Health', 29, 'Home &amp; Health', 'home--health/HEA'),
(132, 'Documentarios', 'Discovery Civilization', '', -1, 'Discovery Civilization', 'discovery-civilization/DCI'),
(133, 'Documentarios', 'Discovery Science', '', -1, 'Discovery Science', 'discovery-science/DSC'),
(134, 'Documentarios', 'History Channel', 'The History Channel', 119, 'History Channel', 'history-channel/HIS'),
(135, 'Documentarios', 'H2', 'H2', 10, 'H2', 'h2/CH2'),
(136, 'Documentarios', 'National Geographic', 'National Geographic', 71, 'NatGeo', 'natgeo/SUP'),
(137, 'Documentarios', 'Nat Geo Wild', 'Nat Geo Wild HD', 167, 'NatGeo Wild', 'natgeo-wild/NGH'),
(138, 'Documentarios', 'ID - Investigation Discovery', 'ID - Investigação Discovery', 61, 'Investigação Discovery', 'investigacao-discovery/LIV'),
(139, 'Documentarios', 'Fish Tv', '', -1, 'FishTV', 'fishtv/BQ6'),
(140, 'Variedades E Musicas', 'Multishow', 'Multishow', 68, 'Multishow', 'multishow/MSW'),
(141, 'Variedades E Musicas', 'Viva', 'Canal Viva', 17, 'Viva', 'viva/VIV'),
(142, 'Variedades E Musicas', 'GNT', 'GNT', 48, 'GNT', 'gnt/GNT'),
(143, 'Variedades E Musicas', 'Mais Globosat', '+ GLOBOSAT', 201, 'Mais Globosat', 'mais-globosat/GHS'),
(144, 'Variedades E Musicas', 'Comedy Central', 'Comedy Central', 188, 'Comedy Central', 'comedy-central/CCE'),
(145, 'Variedades E Musicas', 'MTV', 'MTV', 246, 'MTV', 'mtv/MTV'),
(146, 'Variedades E Musicas', 'MTV Live', '', -1, '', '-1'),
(147, 'Variedades E Musicas', 'BIS', 'BIS', 202, 'BIS', 'bis/MSD'),
(148, 'Variedades E Musicas', 'Prime Box Brazil', 'Prime Box Brazil', 148, '', '-1'),
(149, 'Variedades E Musicas', 'Music Box Brazil', 'Music Box Brazil', 222, '', '-1'),
(150, 'Variedades E Musicas', 'Vh1 Megahits', '', -1, '', '-1'),
(151, 'Variedades E Musicas', 'TruTv', 'TruTV', 120, 'truTV', 'trutv/TRU'),
(152, 'Variedades E Musicas', 'A&E BR', 'A&amp;E', 1, 'A&amp;E', 'ae/MDO'),
(153, 'Variedades E Musicas', 'OFF', 'OFF', 200, 'OFF', 'off/OFS'),
(154, 'Variedades E Musicas', 'Woohoo', 'WooHoo', 125, 'WOOHOO', 'woohoo/WOO'),
(155, 'Variedades E Musicas', 'TLC', 'TLC', 31, 'TLC', 'tlc/TRV'),
(156, 'Variedades E Musicas', 'Food Network', '', -1, '', '-1'),
(157, 'Variedades E Musicas', 'E! BR', 'E!', 34, 'E!', 'e/EET'),
(158, 'Variedades E Musicas', 'Lifetime', '', -1, 'Lifetime', 'lifetime/ANX'),
(159, 'Variedades E Musicas', 'Arte 1', 'Arte 1', 211, 'Arte 1', 'arte-1/BQ5'),
(160, 'Variedades E Musicas', 'Play Tv', 'Play TV', 199, 'Play TV', 'play-tv/PLV'),
(161, 'Variedades E Musicas', 'NHK', 'NHK PREMIUM', 150, 'NHK', 'nhk/NHK'),
(162, 'Religiosos', 'Rede Vida', 'Rede Vida', 234, 'Rede Vida', 'rede-vida/VDA'),
(163, 'Religiosos', 'TV Aparecida', 'Aparecida', 232, 'TV Aparecida', 'tv-aparecida/APA'),
(164, 'Religiosos', 'Canção Nova', 'Canção Nova', 102, 'Canção Nova', 'cancao-nova/CNV'),
(165, 'Religiosos', 'Novo tempo', '', -1, '', '-1'),
(166, 'Religiosos', 'TV Gideões', '', -1, '', '-1'),
(167, 'Religiosos', 'Gospel Brasil', '', -1, '', '-1'),
(168, 'Religiosos', 'RIT', 'RIT', 233, '', '-1'),
(169, 'Religiosos', 'RBI TV', 'RBI TV', 230, '', '-1'),
(170, 'Religiosos', 'TV Mundial', '', -1, '', '-1'),
(171, 'Religiosos', 'Canal Promessas', '', -1, '', '-1'),
(172, 'Religiosos', 'TV Missao', '', -1, '', '-1'),
(173, 'Religiosos', 'Rede Gospel', '', -1, '', '-1'),
(174, 'Religiosos', 'Rede 21', '', -1, 'Canal 21', 'canal-21/C21'),
(175, 'Religiosos', 'Boa Vontade TV', 'Boa Vontade TV', 357, '', '-1'),
(176, 'Religiosos', 'TV Evangelizar', '', -1, '', '-1'),
(177, 'Infantil', 'Discovery Kids', 'Discovery Kids', 30, 'Discovery Kids', 'discovery-kids/DIK'),
(178, 'Infantil', 'PlayKids', '', -1, '', '-1'),
(179, 'Infantil', 'Disney Channel', 'Disney', 33, 'Disney Channel', 'disney-channel/DNY'),
(180, 'Infantil', 'Cartoon Network', 'Cartoon Network', 18, 'Cartoon Network', 'cartoon-network/CAR'),
(181, 'Infantil', 'Disney Jr', 'Disney Júnior', 77, 'Disney Junior', 'disney-junior/PHD'),
(182, 'Infantil', 'Nickelodeon', 'Nickelodeon', 74, 'Nickelodeon', 'nickelodeon/NIC'),
(183, 'Infantil', 'Nick Jr', 'Nick Jr.', 73, '', '-1'),
(184, 'Infantil', 'Gloob', 'Gloob', 191, 'Gloob', 'gloob/GOB'),
(185, 'Infantil', 'Boomerang', 'Boomerang', 11, 'Boomerang', 'boomerang/BMG'),
(186, 'Infantil', 'Globinho', '', -1, '', '-1'),
(187, 'Infantil', 'Nat Geo Kids', '', -1, '', '-1'),
(188, 'Infantil', 'TV Rá Tim Bum', 'TV Rá Tim Bum', 109, '', '-1'),
(189, 'Infantil', 'Tooncast', 'TOONCAST', 175, 'Tooncast', 'tooncast/TOC'),
(190, 'Infantil', 'Baby - TV', '', -1, '', '-1'),
(191, 'Infantil', 'Zoomoo', '', -1, '', '-1'),
(192, 'Infantil', 'Disney XD', 'Disney XD', 32, 'Disney XD', 'disney-xd/DXD');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `nomeCanaisEPG`
--
ALTER TABLE `nomeCanaisEPG`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `nomeCanaisEPG`
--
ALTER TABLE `nomeCanaisEPG`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
