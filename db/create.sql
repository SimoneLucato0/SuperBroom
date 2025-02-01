-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Feb 02, 2022 alle 15:42
-- Versione del server: 10.3.32-MariaDB-0ubuntu0.20.04.1
-- Versione PHP: 7.4.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `escandal`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Amministratore`
--

DROP TABLE IF EXISTS `Amministratore`;
CREATE TABLE IF NOT EXISTS `Amministratore` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Anagrafica`
--

DROP TABLE IF EXISTS `Anagrafica`;
CREATE TABLE IF NOT EXISTS `Anagrafica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cognome` varchar(64) NOT NULL,
  `nome` varchar(64) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `data_nascita` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `GalleriaModello`
--

DROP TABLE IF EXISTS `GalleriaModello`;
CREATE TABLE IF NOT EXISTS `GalleriaModello` (
  `modello` varchar(64) NOT NULL,
  `img` varchar(256) NOT NULL,
  PRIMARY KEY (`modello`,`img`),
  KEY `GalleriaModello_ibfk_2` (`img`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `GalleriaPista`
--

DROP TABLE IF EXISTS `GalleriaPista`;
CREATE TABLE IF NOT EXISTS `GalleriaPista` (
  `pista` varchar(64) NOT NULL,
  `img` varchar(256) NOT NULL,
  PRIMARY KEY (`pista`,`img`),
  KEY `GalleriaPista_ibfk_2` (`img`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Immagine`
--

DROP TABLE IF EXISTS `Immagine`;
CREATE TABLE IF NOT EXISTS `Immagine` (
  `path` varchar(256) NOT NULL,
  `alt` varchar(256) NOT NULL,
  PRIMARY KEY (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Modello`
--

DROP TABLE IF EXISTS `Modello`;
CREATE TABLE IF NOT EXISTS `Modello` (
  `nome` varchar(64) NOT NULL,
  `costo_km` decimal(10,2) NOT NULL,
  `categoria` varchar(64) NOT NULL,
  `descrizione` text NOT NULL,
  `img` varchar(256) NOT NULL,
  PRIMARY KEY (`nome`) USING BTREE,
  KEY `Modello_ibfk_1` (`img`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Pista`
--

DROP TABLE IF EXISTS `Pista`;
CREATE TABLE IF NOT EXISTS `Pista` (
  `nome` varchar(64) NOT NULL,
  `provincia` char(2) NOT NULL,
  `descrizione` text NOT NULL,
  `costo_fisso` decimal(10,2) NOT NULL,
  `lunghezza` decimal(10,3) NOT NULL,
  `larghezza` decimal(10,2) NOT NULL,
  `n_curve` int(11) NOT NULL,
  `dislivello` decimal(10,2) NOT NULL,
  `rettilineo` decimal(10,3) NOT NULL,
  `img` varchar(256) NOT NULL,
  PRIMARY KEY (`nome`) USING BTREE,
  KEY `Pista_ibfk_1` (`img`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Prenotazione`
--

DROP TABLE IF EXISTS `Prenotazione`;
CREATE TABLE IF NOT EXISTS `Prenotazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utente` int(11) DEFAULT NULL,
  `data_ora` datetime NOT NULL DEFAULT current_timestamp(),
  `modello` varchar(64) NOT NULL,
  `pista` varchar(64) NOT NULL,
  `ora_inizio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ora_fine` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `num_giri` int(11) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `destinatario` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `utente` (`utente`,`ora_inizio`) USING BTREE,
  KEY `Prenotazione_ibfk_3` (`destinatario`),
  KEY `Prenotazione_ibfk_4` (`modello`),
  KEY `Prenotazione_ibfk_5` (`pista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Specifica`
--

DROP TABLE IF EXISTS `Specifica`;
CREATE TABLE IF NOT EXISTS `Specifica` (
  `modello` varchar(64) NOT NULL,
  `nome` varchar(256) NOT NULL,
  `valore` varchar(256) NOT NULL,
  PRIMARY KEY (`modello`,`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

DROP TABLE IF EXISTS `Utente`;
CREATE TABLE IF NOT EXISTS `Utente` (
  `id` int(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `pw` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Amministratore`
--
ALTER TABLE `Amministratore`
  ADD CONSTRAINT `Amministratore_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `GalleriaModello`
--
ALTER TABLE `GalleriaModello`
  ADD CONSTRAINT `GalleriaModello_ibfk_2` FOREIGN KEY (`img`) REFERENCES `Immagine` (`path`) ON UPDATE CASCADE,
  ADD CONSTRAINT `GalleriaModello_ibfk_3` FOREIGN KEY (`modello`) REFERENCES `Modello` (`nome`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `GalleriaPista`
--
ALTER TABLE `GalleriaPista`
  ADD CONSTRAINT `GalleriaPista_ibfk_2` FOREIGN KEY (`img`) REFERENCES `Immagine` (`path`) ON UPDATE CASCADE,
  ADD CONSTRAINT `GalleriaPista_ibfk_3` FOREIGN KEY (`pista`) REFERENCES `Pista` (`nome`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `Modello`
--
ALTER TABLE `Modello`
  ADD CONSTRAINT `Modello_ibfk_1` FOREIGN KEY (`img`) REFERENCES `Immagine` (`path`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `Pista`
--
ALTER TABLE `Pista`
  ADD CONSTRAINT `Pista_ibfk_1` FOREIGN KEY (`img`) REFERENCES `Immagine` (`path`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `Prenotazione`
--
ALTER TABLE `Prenotazione`
  ADD CONSTRAINT `Prenotazione_ibfk_3` FOREIGN KEY (`destinatario`) REFERENCES `Anagrafica` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Prenotazione_ibfk_4` FOREIGN KEY (`modello`) REFERENCES `Modello` (`nome`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Prenotazione_ibfk_5` FOREIGN KEY (`pista`) REFERENCES `Pista` (`nome`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Prenotazione_ibfk_6` FOREIGN KEY (`utente`) REFERENCES `Utente` (`id`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `Specifica`
--
ALTER TABLE `Specifica`
  ADD CONSTRAINT `Specifica_ibfk_1` FOREIGN KEY (`modello`) REFERENCES `Modello` (`nome`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `Utente`
--
ALTER TABLE `Utente`
  ADD CONSTRAINT `Utente_ibfk_2` FOREIGN KEY (`id`) REFERENCES `Anagrafica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
