CREATE DATABASE ticket;

use ticket;

CREATE TABLE IF NOT EXISTS `client` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(244) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `client`
--

INSERT INTO `client` (`Id`, `Name`) VALUES
(1, 'Shoptime'),
(2, 'Casas Bahia'),
(3, 'Americanas'),
(4, 'Ricardo Eletro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reason`
--

CREATE TABLE IF NOT EXISTS `reason` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(244) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `reason`
--

INSERT INTO `reason` (`Id`, `Name`) VALUES
(1, 'Problema no sistema'),
(2, 'Sugestao melhoria'),
(3, 'Insatisfacao');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(244) COLLATE utf8_unicode_ci NOT NULL,
  `Date_Created` datetime DEFAULT NULL,
  `Date_Closed` datetime DEFAULT NULL,
  `Status` tinyint(1) NOT NULL,
  `IdClient` int(11) NOT NULL,
  `IdReason` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_IdClient` (`IdClient`),
  KEY `FK_IdReason` (`IdReason`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `ticket`
--

INSERT INTO `ticket` (`Id`, `Description`, `Date_Created`, `Date_Closed`, `Status`, `IdClient`, `IdReason`) VALUES
(13, 'Não estamos conseguindo realizar checagem de estoque no sistema', '2019-10-06 07:23:31', NULL, 0, 1, 1),
(14, 'teste para casas bahia', '2019-10-06 10:07:41', NULL, 0, 2, 0),
(37, 'Cliente não consegue acessar o software administrador', '2019-10-07 07:04:37', NULL, 1, 2, 3),
(24, 'Cliente gostaria de propor uma melhoria para o sistema financeiro.', '2019-10-27 12:00:00', NULL, 0, 1, 2),
(38, 'Cliente agradece pelo ótimo trabalho fornecido!', '2019-10-07 07:05:16', '2019-10-07 12:00:00', 0, 3, 2);
COMMIT;
