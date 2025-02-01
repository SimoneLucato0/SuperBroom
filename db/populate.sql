-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Feb 02, 2022 alle 15:41
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

--
-- Svuota la tabella prima dell'inserimento `Amministratore`
--

TRUNCATE TABLE `Amministratore`;
--
-- Dump dei dati per la tabella `Amministratore`
--

INSERT INTO `Amministratore` (`id`) VALUES
(1);

--
-- Svuota la tabella prima dell'inserimento `Anagrafica`
--

TRUNCATE TABLE `Anagrafica`;
--
-- Dump dei dati per la tabella `Anagrafica`
--

INSERT INTO `Anagrafica` (`id`, `cognome`, `nome`, `mail`, `data_nascita`) VALUES
(1, 'Bros', 'Mario', 'mario@example.com', '1997-04-12'),
(2, 'Bros', 'Luigi', 'luigi@example.com', '1997-04-12'),
(17, 'Scandaletti', 'Elia', 'elia.scandaletti@studenti.unipd.it', '2000-10-18'),
(42, 'Greggio', 'Marta', 'mario@example.com', '1997-04-12'),
(43, 'Lucato', 'Simone', 'test@example.com', '2001-01-30'),
(65, 'Scandaloso', 'Elia', 'boh@gmail.com', '1996-10-18');

--
-- Svuota la tabella prima dell'inserimento `GalleriaModello`
--

TRUNCATE TABLE `GalleriaModello`;
--
-- Dump dei dati per la tabella `GalleriaModello`
--

INSERT INTO `GalleriaModello` (`modello`, `img`) VALUES
('Ferrari Portofino', 'images/auto/Ferrari Portofino/galleria-0.jpeg'),
('Ferrari Portofino', 'images/auto/Ferrari Portofino/galleria-1.jpeg'),
('Ferrari SF90 Stradale', 'images/auto/Ferrari SF90 Stradale/galleria-0.jpeg'),
('Ferrari SF90 Stradale', 'images/auto/Ferrari SF90 Stradale/galleria-1.jpeg');

--
-- Svuota la tabella prima dell'inserimento `GalleriaPista`
--

TRUNCATE TABLE `GalleriaPista`;
--
-- Dump dei dati per la tabella `GalleriaPista`
--

INSERT INTO `GalleriaPista` (`pista`, `img`) VALUES
('Autodromo di Imola', 'images/pista/Autodromo di Imola/galleria-0.jpeg'),
('Autodromo di Imola', 'images/pista/Autodromo di Imola/galleria-1.jpeg'),
('Autodromo internazionale del Mugello', 'images/pista/Autodromo internazionale del Mugello/galleria-0.jpeg'),
('Autodromo Nazionale di Monza', 'images/pista/Autodromo Nazionale di Monza/galleria-0.jpeg'),
('Misano World Circuit Marco Simoncelli', 'images/pista/Misano World Circuit Marco Simoncelli/galleria-0.jpeg'),
('Misano World Circuit Marco Simoncelli', 'images/pista/Misano World Circuit Marco Simoncelli/galleria-1.jpeg');

--
-- Svuota la tabella prima dell'inserimento `Immagine`
--

TRUNCATE TABLE `Immagine`;
--
-- Dump dei dati per la tabella `Immagine`
--

INSERT INTO `Immagine` (`path`, `alt`) VALUES
('images/auto/Alfa Romeo Stelvio Quadrifoglio/Alfa Romeo Stelvio Quadrifoglio.jpeg', 'Fotografia della macchina Stelvio Quadrifoglio della casa automobilistica Alfa Romeo'),
('images/auto/Ferrari Portofino/Ferrari Portofino.jpeg', 'Ferrari Portofino rossa in una esposizione automobilistica, col tettuccio chiuso'),
('images/auto/Ferrari Portofino/galleria-0.jpeg', 'Ferrari Portofino rossa in una esposizione automobilistica, col tettuccio aperto'),
('images/auto/Ferrari Portofino/galleria-1.jpeg', 'Interni in eco pelle rossa di una Ferrari Portofino'),
('images/auto/Ferrari SF90 Stradale/Ferrari SF90 Stradale.jpeg', 'sf90 stradale in pista'),
('images/auto/Ferrari SF90 Stradale/galleria-0.jpeg', 'Fotografia degli interni della sf90 stradale, sedili rivestiti in pelle nera'),
('images/auto/Ferrari SF90 Stradale/galleria-1.jpeg', 'Fotografia di Charles Leclerc, pilota di Formula 1 per la scuderia Ferrari, appoggiato ad una SF90 Stradale in occasione di un remake di un corto metraggio francese girato a Monaco'),
('images/auto/Lamborghini Huracan Evo/Lamborghini Huracan Evo.jpeg', 'Fotografia dell&#039;automobile Lamborghini Huracan, super car da strada di lusso'),
('images/pista/Autodromo di Imola/Autodromo di Imola.png', 'Mappa del circuito di Imola'),
('images/pista/Autodromo di Imola/galleria-0.jpeg', 'Partenza del circuito di Imola'),
('images/pista/Autodromo di Imola/galleria-1.jpeg', 'Box del circuito di Imola'),
('images/pista/Autodromo internazionale del Mugello/Autodromo internazionale del Mugello.png', 'Tracciato del Mugello, circuito italiano di Formula 1 situato in provincia di Firenze.'),
('images/pista/Autodromo internazionale del Mugello/galleria-0.jpeg', 'Fotografia del traguardo del circuito del Mugello'),
('images/pista/Autodromo Nazionale di Monza/Autodromo Nazionale di Monza.png', 'Contorno dell&#039;autodromo nazionale di Monza, circuito italiano di Formula 1 situato in provincia di Monza e di Brianza'),
('images/pista/Autodromo Nazionale di Monza/galleria-0.jpeg', 'Fotografia del circuito che inquadra la curva parabolica e degli alberi'),
('images/pista/Autodromo Riccardo Paletti/Autodromo Riccardo Paletti.png', 'Contorno del tracciato di Varano de Melegari, circuito italiano situato in provincia di Parma'),
('images/pista/Misano World Circuit Marco Simoncelli/galleria-0.jpeg', 'Fotografia dall&#039;alto che inquadra la pista di Misano, il cielo e gli alberi attorno al tracciato'),
('images/pista/Misano World Circuit Marco Simoncelli/galleria-1.jpeg', 'Dettaglio della pista che raffigura una dedica per Marco Simoncelli, pilota italiano morto a Misano nel 2011'),
('images/pista/Misano World Circuit Marco Simoncelli/Misano World Circuit Marco Simoncelli.png', 'contorno del tracciato motociclistico di Misano, circuito situato in provincia di Rimini');

--
-- Svuota la tabella prima dell'inserimento `Modello`
--

TRUNCATE TABLE `Modello`;
--
-- Dump dei dati per la tabella `Modello`
--

INSERT INTO `Modello` (`nome`, `costo_km`, `categoria`, `descrizione`, `img`) VALUES
('Alfa Romeo Stelvio Quadrifoglio', '3.00', 'SUV', 'L&#039;Alfa Romeo Stelvio (nome in codice Tipo 949) &egrave; il primo crossover SUV di segmento D presentato dalla casa automobilistica italiana Alfa Romeo alla fine del 2016 per entrare poi a listino all&#039;inizio dell&#039;anno successivo.', 'images/auto/Alfa Romeo Stelvio Quadrifoglio/Alfa Romeo Stelvio Quadrifoglio.jpeg'),
('Ferrari Portofino', '8.00', 'Gran Turismo', 'La Ferrari Portofino (nome in codice F164) &egrave; un&#039;autovettura sportiva di tipo gran turismo con carrozzeria coup&eacute;-cabriolet prodotta dalla casa automobilistica italiana Ferrari a partire dal 2018.', 'images/auto/Ferrari Portofino/Ferrari Portofino.jpeg'),
('Ferrari SF90 Stradale', '34.00', 'Supersport', 'La Ferrari SF90 Stradale &egrave; una vettura supersportiva ad alimentazione ibrida prodotta dalla casa automobilistica italiana Ferrari a partire dal 2019, in occasione dei 90 anni della Scuderia Ferrari.\r\nIspirata all&#039;omonima monoposto di Formula 1, &egrave; la prima vettura ibrida plug-in di serie della casa del cavallino rampante.\r\nQuesta soluzione le ha anche permesso di diventare la Ferrari stradale pi&ugrave; potente della storia.', 'images/auto/Ferrari SF90 Stradale/Ferrari SF90 Stradale.jpeg'),
('Lamborghini Huracan Evo', '6.00', 'Sport', 'La Lamborghini Hurac&aacute;n &egrave; il compromesso ideale tra tecnologia e design. \r\nLa prima emozione si prova semplicemente guardandola. Linee nette, aerodinamiche, progettate per fendere l&#039;aria e domare la strada. La seconda si sperimenta toccandola. Le migliori abilit&agrave; artigiane italiane sono dedicate all&#039;esecuzione di finiture di prestigio e qualit&agrave; senza precedenti. Il terzo tuffo al cuore si prova premendo il pulsante dell&#039;accensione e sentendo il motore ad aspirazione naturale V10 e tutta la tecnologia che serve per controllarlo. L&#039;ultima emozione proviene dal sistema di illuminazione full LED e dalla plancia con TFT da 12.3&quot;, per un&#039;incomparabile esperienza di guida.', 'images/auto/Lamborghini Huracan Evo/Lamborghini Huracan Evo.jpeg');

--
-- Svuota la tabella prima dell'inserimento `Pista`
--

TRUNCATE TABLE `Pista`;
--
-- Dump dei dati per la tabella `Pista`
--

INSERT INTO `Pista` (`nome`, `provincia`, `descrizione`, `costo_fisso`, `lunghezza`, `larghezza`, `n_curve`, `dislivello`, `rettilineo`, `img`) VALUES
('Autodromo di Imola', 'BO', 'L&#039;autodromo Enzo e Dino Ferrari, comunemente noto come autodromo di Imola, &egrave; un circuito automobilistico situato nel comune di Imola, nella citt&agrave; metropolitana di Bologna.', '40.00', '4.909', '12.00', 19, '10.00', '1.200', 'images/pista/Autodromo di Imola/Autodromo di Imola.png'),
('Autodromo internazionale del Mugello', 'FI', 'L&#039;autodromo internazionale del Mugello, noto anche come Mugello Circuit, &egrave; un circuito automobilistico e motociclistico italiano. Si trova nel comune di Scarperia e San Piero, in provincia di Firenze, ed &egrave; di propriet&agrave; della Ferrari.\r\n\r\nNon molto distante dall&#039;attuale impianto sorgeva il rinomato circuito stradale del Mugello, sede di gare automobilistiche disputatesi, senza soluzione di continuit&agrave;, dal 1914 al 1970.', '62.00', '5.245', '12.00', 15, '41.00', '1.141', 'images/pista/Autodromo internazionale del Mugello/Autodromo internazionale del Mugello.png'),
('Autodromo Nazionale di Monza', 'MB', 'L&#039;autodromo nazionale di Monza &egrave; un circuito automobilistico internazionale situato all&#039;interno del parco di Monza. &Egrave; il quarto autodromo permanente pi&ugrave; antico al mondo. &Egrave; il circuito dove si sono svolti pi&ugrave; Gran Premi di Formula 1.', '51.00', '5.793', '12.00', 11, '10.00', '1.973', 'images/pista/Autodromo Nazionale di Monza/Autodromo Nazionale di Monza.png'),
('Autodromo Riccardo Paletti', 'PR', 'L&#039;autodromo Riccardo Paletti &egrave; un circuito che si trova nel comune di Varano de&#039; Melegari in provincia di Parma. Fondato nel 1969, l&#039;impianto &egrave; stato dedicato nel 1983 alla memoria del giovane pilota italiano Riccardo Paletti, deceduto nel 1982 durante il Gran Premio del Canada di Formula 1.', '31.00', '2.360', '8.00', 14, '0.00', '0.476', 'images/pista/Autodromo Riccardo Paletti/Autodromo Riccardo Paletti.png'),
('Misano World Circuit Marco Simoncelli', 'RN', 'Il Misano World Circuit Marco Simoncelli &egrave; un circuito motociclistico situato nel comune di Misano Adriatico, in provincia di Rimini, precisamente nella frazione di Santa Monica e vicino al bacino del Conca. &Egrave; intitolato alla memoria di Marco Simoncelli, motociclista italiano deceduto nel 2011.', '64.00', '4.226', '13.00', 15, '11.00', '0.550', 'images/pista/Misano World Circuit Marco Simoncelli/Misano World Circuit Marco Simoncelli.png');

--
-- Svuota la tabella prima dell'inserimento `Prenotazione`
--

TRUNCATE TABLE `Prenotazione`;
--
-- Dump dei dati per la tabella `Prenotazione`
--

INSERT INTO `Prenotazione` (`id`, `utente`, `data_ora`, `modello`, `pista`, `ora_inizio`, `ora_fine`, `num_giri`, `costo`, `destinatario`) VALUES
(15, 2, '2022-01-31 22:27:58', 'Lamborghini Huracan Evo', 'Autodromo di Imola', '2022-04-01 06:30:00', '2022-04-01 10:30:00', 6, '216.72', 2),
(20, NULL, '2022-02-02 15:33:21', 'Ferrari Portofino', 'Misano World Circuit Marco Simoncelli', '2022-04-03 06:30:00', '2022-04-03 10:30:00', 7, '300.66', 65),
(21, 1, '2022-02-02 15:38:45', 'Ferrari Portofino', 'Misano World Circuit Marco Simoncelli', '2022-05-14 12:00:00', '2022-05-14 16:00:00', 4, '199.23', 1);

--
-- Svuota la tabella prima dell'inserimento `Specifica`
--

TRUNCATE TABLE `Specifica`;
--
-- Dump dei dati per la tabella `Specifica`
--

INSERT INTO `Specifica` (`modello`, `nome`, `valore`) VALUES
('Alfa Romeo Stelvio Quadrifoglio', 'Motore', '2,9 l V6'),
('Alfa Romeo Stelvio Quadrifoglio', 'Peso a vuoto', '1830 kg'),
('Alfa Romeo Stelvio Quadrifoglio', 'Potenza', '510 cavalli'),
('Alfa Romeo Stelvio Quadrifoglio', 'Velocit&agrave; massima', '283 km/h'),
('Ferrari Portofino', 'Cambio', 'automatico Getrag a 7 rapporti'),
('Ferrari Portofino', 'Cilindrata', '3855 cc'),
('Ferrari Portofino', 'Potenza', '600 CV a 7500 giri/minuto'),
('Ferrari Portofino', 'Tipo motore', 'V8 a 90&deg; bi-turbo'),
('Ferrari Portofino', 'Trazione', 'posteriore'),
('Ferrari Portofino', 'Velocit&agrave; massima', '320 km/h'),
('Ferrari SF90 Stradale', 'Autonomia batteria', '25 km/h'),
('Ferrari SF90 Stradale', 'Consumo ', '6,1 litri per 100 km'),
('Ferrari SF90 Stradale', 'Motore', '4,0 litri V8'),
('Ferrari SF90 Stradale', 'Peso a vuoto', '1570 kg'),
('Lamborghini Huracan Evo', 'Potenza', 'Da 610 a 640 cavalli'),
('Lamborghini Huracan Evo', 'Trazione', 'Integrale 4x4 oppure posteriore'),
('Lamborghini Huracan Evo', 'Velocit&agrave; massima', '320 km/h');

--
-- Svuota la tabella prima dell'inserimento `Utente`
--

TRUNCATE TABLE `Utente`;
--
-- Dump dei dati per la tabella `Utente`
--

INSERT INTO `Utente` (`id`, `username`, `pw`) VALUES
(1, 'admin', '$2y$10$gDF7pUM6aRKcscovb1RHauTpi9oJF8Ocihv01sA5l9jKcoKfN0zqe'),
(2, 'user', '$2y$10$r240Td.daWYIompvCiYrMukL0FOFIpMuTXuOuwxlopbfiysPbGVZK');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
