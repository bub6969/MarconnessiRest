-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 27, 2025 alle 10:37
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marconnessi_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `annunci`
--

CREATE TABLE `annunci` (
  `id_annuncio` int(11) NOT NULL,
  `oggetto_annuncio` varchar(255) NOT NULL,
  `corpo_annuncio` text NOT NULL,
  `data_annuncio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `annunci`
--

INSERT INTO `annunci` (`id_annuncio`, `oggetto_annuncio`, `corpo_annuncio`, `data_annuncio`, `id_persona`) VALUES
(26, 'comunicazione 27/05/2025', 'prova della bacheca di marconnessi', '2025-05-27 08:32:38', 25);

-- --------------------------------------------------------

--
-- Struttura della tabella `aule`
--

CREATE TABLE `aule` (
  `id_aula` int(11) NOT NULL,
  `aula` varchar(20) NOT NULL,
  `id_edificio` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `aule`
--

INSERT INTO `aule` (`id_aula`, `aula`, `id_edificio`) VALUES
(1, 'Aula Test', 'm'),
(2, '00', 'i'),
(3, '02', 'i'),
(4, '03', 'i'),
(5, '04', 'i'),
(6, '05', 'i'),
(7, '06', 'i'),
(8, '07', 'i'),
(9, '08', 'i'),
(10, '09', 'i'),
(11, '11', 'i'),
(12, '12', 'i'),
(13, '13', 'i'),
(14, '14', 'i'),
(15, '15', 'i'),
(16, '16', 'i'),
(17, '17', 'i'),
(18, '20', 'i'),
(19, '21', 'i'),
(20, '22', 'i'),
(21, '23', 'i'),
(22, '24', 'i'),
(23, '25', 'i'),
(24, '26', 'i'),
(25, '27', 'i'),
(26, '28', 'i'),
(27, '29', 'i'),
(28, '48', 'f'),
(29, 'M1', 'm'),
(30, 'M2', 'm'),
(31, 'M3', 'm'),
(32, 'M4', 'm'),
(33, 'M5', 'm'),
(34, 'M6', 'm'),
(35, '30 C', 'c'),
(36, '31 C', 'c'),
(37, '32 C', 'c'),
(38, '33 C', 'c'),
(39, '34 C', 'c'),
(40, '35 C', 'c'),
(41, '36 C', 'c'),
(42, '39 F', 'f'),
(43, '40 F', 'f'),
(44, '41 F', 'f'),
(45, '42 F', 'f'),
(46, '43 F', 'f'),
(47, '44 F', 'f'),
(48, '45 F', 'f'),
(49, '46 F', 'f'),
(50, '47 F', 'f'),
(51, '49 F', 'f'),
(52, '50 S', 's'),
(53, '51 S', 's'),
(54, '52 S', 's'),
(55, '53 S', 's'),
(56, '54 S', 's'),
(57, '55 S', 's'),
(58, '56 S', 's'),
(59, '57 S', 's'),
(60, '2 CHI', 'i'),
(61, '2 FIS', 'i'),
(62, 'LAB. OMU', 'i'),
(63, 'AULA MAGNA', 'i'),
(64, 'BIBLIOTECA', 'i'),
(65, 'LAB. INF.1', 'i'),
(66, 'LAB. INF.2', 'i'),
(67, 'LAB. INF.3', 'i'),
(68, 'LAB. INF.4', 'i'),
(69, 'LAB. FISICA', 'i'),
(70, 'LAB. MACCH.', 'i'),
(71, 'LAB. TEPSEE', 'i'),
(72, 'AULA DISEGNO', 'i'),
(73, 'LAB. CHIMICA', 'i'),
(74, 'LAB. E.ONICA', 'i'),
(75, 'LAB. GRAFICA', 'i'),
(76, 'LAB. SISTEMI', 'i'),
(77, 'LAB. BIOLOGIA', 'i'),
(78, 'LAB. GRAFICO-LIN', 'i'),
(79, 'AULA TEC + LAB MIS', 'i'),
(80, 'Aula Test', 'm');

-- --------------------------------------------------------

--
-- Struttura della tabella `classi`
--

CREATE TABLE `classi` (
  `id_classe` int(11) NOT NULL,
  `classe` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `classi`
--

INSERT INTO `classi` (`id_classe`, `classe`) VALUES
(1, '1AE'),
(2, '1AGC'),
(3, '1AIT'),
(4, '1AME'),
(5, '1ASA'),
(6, '1BE'),
(7, '1BGC'),
(8, '1BIT'),
(9, '1BME'),
(10, '1BSA'),
(11, '1CIT'),
(12, '1CME'),
(13, '1CSA'),
(14, '1DIT'),
(15, '1DSA'),
(16, '1EIG'),
(17, '2AE'),
(18, '2AGC'),
(19, '2AIT'),
(20, '2AME'),
(21, '2ASA'),
(22, '2BE'),
(23, '2BGC'),
(24, '2BIT'),
(25, '2BME'),
(26, '2BSA'),
(27, '2CIT'),
(28, '2CME'),
(29, '2CSA'),
(30, '2DIT'),
(31, '2EIT'),
(32, '3AE'),
(33, '3AEn'),
(34, '3AGC'),
(35, '3AI'),
(36, '3AMM'),
(37, '3ASA'),
(38, '3AT'),
(39, '3BE'),
(40, '3BGC'),
(41, '3BI'),
(42, '3BSA'),
(43, '3CI'),
(44, '3CSA'),
(45, '4AE'),
(46, '4AEn'),
(47, '4AGC'),
(48, '4AI'),
(49, '4AMM'),
(50, '4ASA'),
(51, '4BGC'),
(52, '4BI'),
(53, '4BMM'),
(54, '4BSA'),
(55, '4BTE-E'),
(56, '4BTE-T'),
(57, '4BTE'),
(58, '4CI'),
(59, '4CSA'),
(60, '4DI'),
(61, '5AE'),
(62, '5AEn'),
(63, '5AGC'),
(64, '5AI'),
(65, '5ASA'),
(66, '5ATM-M'),
(67, '5ATM-T'),
(68, '5ATM'),
(69, '5BE'),
(70, '5BGC'),
(71, '5BI'),
(72, '5BSA'),
(73, '5CI'),
(74, '5CSA');

-- --------------------------------------------------------

--
-- Struttura della tabella `edifici`
--

CREATE TABLE `edifici` (
  `id_edificio` varchar(1) NOT NULL,
  `edificio` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `edifici`
--

INSERT INTO `edifici` (`id_edificio`, `edificio`) VALUES
('c', 'classico'),
('f', 'fermi'),
('i', 'sede centrale'),
('m', 'moduli'),
('s', 'scientifico');

-- --------------------------------------------------------

--
-- Struttura della tabella `frequenta`
--

CREATE TABLE `frequenta` (
  `id_frequenta` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `frequenta`
--

INSERT INTO `frequenta` (`id_frequenta`, `id_classe`, `id_persona`) VALUES
(1, 64, 26),
(2, 64, 27),
(3, 64, 28),
(4, 64, 29),
(5, 64, 30),
(6, 64, 31),
(7, 64, 32),
(8, 64, 33),
(9, 64, 34),
(10, 64, 35),
(11, 64, 36),
(12, 64, 37),
(13, 64, 38),
(14, 64, 39),
(15, 64, 40),
(16, 64, 41),
(17, 64, 42),
(18, 64, 43),
(19, 64, 44),
(20, 64, 45),
(21, 64, 46),
(22, 64, 47);

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzo`
--

CREATE TABLE `indirizzo` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `indirizzo`
--

INSERT INTO `indirizzo` (`ID`, `Nome`) VALUES
(1, 'Liceo Scientifico - Opzione Scienze Applicate'),
(2, 'Tecnologico - Disciplina Generale'),
(6, 'Tecnologico - Elettronica ed Elettrotecnica'),
(5, 'Tecnologico - Energia'),
(3, 'Tecnologico - Grafica e Comunicazione'),
(7, 'Tecnologico - Informatica e Telecomunicazioni'),
(4, 'Tecnologico - Meccanica, Meccatronica');

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzomateria`
--

CREATE TABLE `indirizzomateria` (
  `IndirizzoID` int(11) NOT NULL,
  `MateriaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `indirizzomateria`
--

INSERT INTO `indirizzomateria` (`IndirizzoID`, `MateriaID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(2, 1),
(2, 4),
(2, 6),
(2, 9),
(2, 11),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 26),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 31),
(5, 17),
(5, 18),
(5, 19),
(5, 20),
(5, 21),
(5, 22),
(5, 27),
(5, 28),
(5, 29),
(5, 30),
(5, 31),
(6, 17),
(6, 18),
(6, 19),
(6, 20),
(6, 21),
(6, 22),
(6, 32),
(6, 33),
(6, 34),
(7, 7),
(7, 17),
(7, 18),
(7, 19),
(7, 20),
(7, 21),
(7, 22),
(7, 35),
(7, 36),
(7, 37),
(7, 38);

-- --------------------------------------------------------

--
-- Struttura della tabella `insegna`
--

CREATE TABLE `insegna` (
  `id_insegna` int(11) NOT NULL,
  `id_professore` int(11) NOT NULL,
  `id_lezione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `insegna`
--

INSERT INTO `insegna` (`id_insegna`, `id_professore`, `id_lezione`) VALUES
(2, 59, 25),
(3, 57, 27),
(4, 59, 26),
(5, 55, 28),
(6, 58, 32),
(7, 59, 31),
(8, 58, 30),
(9, 56, 30),
(10, 57, 29),
(11, 62, 29),
(12, 58, 33),
(13, 58, 34),
(14, 57, 49),
(15, 62, 49),
(16, 57, 50),
(17, 62, 50),
(18, 58, 51),
(19, 56, 51),
(20, 58, 52),
(21, 56, 52),
(22, 61, 35),
(23, 60, 36),
(24, 64, 37),
(25, 55, 38),
(26, 55, 39),
(27, 60, 40),
(28, 59, 53),
(29, 65, 53),
(30, 59, 54),
(31, 65, 54),
(32, 60, 41),
(33, 60, 42),
(34, 58, 55),
(35, 54, 43),
(36, 54, 44),
(37, 59, 45),
(38, 65, 45),
(39, 60, 46),
(40, 60, 47),
(41, 64, 48),
(42, 64, 56);

-- --------------------------------------------------------

--
-- Struttura della tabella `lezioni`
--

CREATE TABLE `lezioni` (
  `id_lezione` int(11) NOT NULL,
  `ora_lezione` int(11) NOT NULL,
  `giorno_lezione` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `lezioni`
--

INSERT INTO `lezioni` (`id_lezione`, `ora_lezione`, `giorno_lezione`, `id_aula`, `id_classe`, `id_materia`) VALUES
(25, 1, 1, 52, 64, 7),
(26, 2, 1, 52, 64, 7),
(27, 3, 1, 52, 64, 36),
(28, 4, 1, 52, 64, 2),
(29, 3, 2, 76, 64, 36),
(30, 2, 2, 65, 64, 35),
(31, 1, 2, 14, 64, 7),
(32, 5, 1, 52, 64, 35),
(33, 4, 2, 52, 64, 37),
(34, 5, 2, 52, 64, 37),
(35, 5, 3, 52, 64, 13),
(36, 6, 3, 52, 64, 4),
(37, 1, 4, 52, 64, 6),
(38, 2, 4, 52, 64, 2),
(39, 3, 4, 52, 64, 2),
(40, 4, 4, 52, 64, 1),
(41, 1, 5, 52, 64, 1),
(42, 2, 5, 52, 64, 1),
(43, 4, 5, 52, 64, 11),
(44, 5, 5, 52, 64, 11),
(45, 1, 6, 66, 64, 7),
(46, 2, 6, 52, 64, 1),
(47, 3, 6, 52, 64, 4),
(48, 4, 6, 52, 64, 6),
(49, 1, 3, 66, 64, 36),
(50, 2, 3, 66, 64, 36),
(51, 3, 3, 76, 64, 35),
(52, 4, 3, 76, 64, 35),
(53, 5, 4, 65, 64, 7),
(54, 6, 4, 65, 64, 7),
(55, 3, 5, 52, 64, 37),
(56, 5, 6, 52, 64, 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `materie`
--

CREATE TABLE `materie` (
  `id_materia` int(11) NOT NULL,
  `nome_materia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `materie`
--

INSERT INTO `materie` (`id_materia`, `nome_materia`) VALUES
(22, 'Complementi di matematica'),
(16, 'Diritto ed economia'),
(10, 'Disegno e Storia dell’arte'),
(30, 'Disegno, progettazione e organizzazione industriale'),
(12, 'Educazione civica'),
(32, 'Elettrotecnica ed elettronica'),
(5, 'Filosofia'),
(8, 'Fisica'),
(15, 'Geografia generale ed economia'),
(37, 'Gestione progetto, organizzazione d’impresa'),
(31, 'Impianti energetici, disegno e progettazione'),
(7, 'Informatica'),
(26, 'Laboratori tecnici'),
(2, 'Lingua e cultura straniera (Inglese)'),
(1, 'Lingua e letteratura italiana'),
(14, 'Lingua inglese'),
(6, 'Matematica'),
(27, 'Meccanica, macchine ed energia'),
(25, 'Organizzazione e gestione dei processi produttivi'),
(23, 'Progettazione multimediale'),
(13, 'Religione cattolica o Attività alternative'),
(21, 'Scienze e tecnologie applicate'),
(18, 'Scienze integrate (CHIMICA)'),
(17, 'Scienze integrate (FISICA)'),
(11, 'Scienze motorie e sportive'),
(9, 'Scienze naturali (Biologia, Chimica, Scienze della Terra)'),
(34, 'Sistemi automatici'),
(28, 'Sistemi e automazione'),
(35, 'Sistemi e reti'),
(4, 'Storia'),
(3, 'Storia e Geografia'),
(19, 'Tecnologia e tecniche di rappresentazione grafica'),
(24, 'Tecnologie dei processi di produzione'),
(33, 'Tecnologie e progettazione di sistemi elettrici ed elettronici'),
(36, 'Tecnologie e progettazione di sistemi informatici e di telecomunicazioni'),
(20, 'Tecnologie informatiche'),
(29, 'Tecnologie meccaniche di processo e di prodotto'),
(38, 'Telecomunicazioni');

-- --------------------------------------------------------

--
-- Struttura della tabella `persone`
--

CREATE TABLE `persone` (
  `id_persona` int(11) NOT NULL,
  `mail` varchar(319) NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `data_nascita` date NOT NULL,
  `ruolo` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `persone`
--

INSERT INTO `persone` (`id_persona`, `mail`, `password`, `nome`, `cognome`, `data_nascita`, `ruolo`, `created`) VALUES
(25, 'mirkonufrio@marconnessi.admin.com', '1b9410a1a15a07c11d68f9e7b3e607678c6fbd178fd445f8f0924cde8bce0b81', 'Mirko', 'Nufrio', '2006-02-26', 1, '2025-05-25 21:31:52'),
(26, 'alessandroarcenni@marconnessi.com', '7d85d1c355ae8e75b942c4afcad6495dd1b50fda8aff57dc8ca61558e7e36ec4', 'Alessandro', 'Arcenni', '2006-05-11', 3, '2025-05-27 08:34:21'),
(27, 'tommasobassoni@marconnessi.com', 'cd69a8f70be7cffb27ebce3dcdfd6f2fc9470c3c20fc291c20c9ea603b570ac2', 'Tommaso', 'Bassoni', '2006-03-07', 3, '2025-05-23 22:42:14'),
(28, 'francescobrachini@marconnessi.com', 'c21d899bbd35638843beda0da150fe54128e87a27e057f95c666848a7b216116', 'Francesco', 'Brachini', '2006-12-27', 3, '2025-05-23 22:42:14'),
(29, 'tommasobuselli@marconnessi.com', '08755c730766b5cd457545be61a134a0a472b517cd09a16110d5e714b7d1790e', 'Tommaso', 'Buselli', '2006-06-26', 3, '2025-05-23 22:42:14'),
(30, 'matteostefanciuca@marconnessi.com', 'dfda6d275fc6ba7484659203d28bc9ce086e32fa6250b4d996a7efbb5ea44063', 'Matteo', 'Stefan Ciuca', '2006-04-17', 3, '2025-05-23 22:42:14'),
(31, 'lorenzocipolli@marconnessi.com', 'ad1a7cc507f551925b0ae80136645159e9718f95cfe5eed307edc9620c1cdb97', 'Lorenzo', 'Cipolli', '2006-04-04', 3, '2025-05-23 22:42:14'),
(32, 'angelodepalo@marconnessi.com', '6ee9870a361b62c0371a2071fb49c4ca8623d478dbb3dec71b7fb3363feaadce', 'Angelo', 'Depalo', '2006-09-14', 3, '2025-05-23 22:42:14'),
(33, 'mattiafaraoni@marconnessi.com', 'ae1464730ed0e8218b859d5c57c6f891bcdd82a35df33a660fdbf0afafbf3035', 'Mattia', 'Faraoni', '2006-03-26', 3, '2025-05-23 22:42:14'),
(34, 'nicholasgiaconia@marconnessi.com', '2c4c8e81248a681fb8ee7580ba0b0a6c56d331db2f5536d94d5f9be52a326ce7', 'Nicholas', 'Giaconia', '2006-05-12', 3, '2025-05-23 22:42:14'),
(35, 'antonkovalenko@marconnessi.com', '9ffe8c52dbc646fb9e5bb474572b3fb2f38271750f5f6c02cbc22a9a6a0960aa', 'Anton', 'Kovalenko', '2006-09-07', 3, '2025-05-23 22:42:14'),
(36, 'mattialombardi@marconnessi.com', '12b8a05d3a848a355537ef6b372de526488b94ca38c7e49656b7b5344ce65d85', 'Mattia', 'Lombardi', '2006-03-31', 3, '2025-05-23 22:42:14'),
(37, 'andreamiranda@marconnessi.com', 'cccbb12ff4335512e066fda678c09dd5727f6188cc55597567ae65cd2ee80f03', 'Andrea', 'Miranda', '2006-02-13', 3, '2025-05-23 22:42:14'),
(38, 'filippomosti@marconnessi.com', '638b713235bfb8ac7ddcfbfc6b2e2e5498bb6616a93981ca540b740db6e18ca5', 'Filippo', 'Mosti', '2006-07-26', 3, '2025-05-23 22:42:14'),
(39, 'mirkonufrio@marconnessi.com', '5befea829ac20c44e2a51cfc485ab9e1e1497a140e569613b8e3ee34fd8a30fa', 'Mirko', 'Nufrio', '2006-06-16', 3, '2025-05-27 07:02:02'),
(40, 'alessandropasqualetti@marconnessi.com', 'd8f0a8d39bf43618e66961529f7f0cc5c74e2efe685a76600079675908231fcf', 'Alessandro', 'Pasqualetti', '2006-04-05', 3, '2025-05-23 22:42:14'),
(41, 'lorenzorusso@marconnessi.com', 'd1618420e34c6b1d6adbd404579581569711a3fa5badbb5d7be4111d78b1061a', 'Lorenzo', 'Russo', '2006-11-01', 3, '2025-05-23 22:42:14'),
(42, 'matteostizza@marconnessi.com', 'd3b3213fff7c200b1dffc9c311f1234394dc56a770faa2cb41b14627108b2044', 'Matteo', 'Stizza', '2006-12-03', 3, '2025-05-23 22:42:14'),
(43, 'diegoticciati@marconnessi.com', '5b494dd381c6cee46c4a0306918c5dc68f74afb5ac3f177f80728decaaad867f', 'Diego', 'Ticciati', '2006-05-25', 3, '2025-05-23 22:42:14'),
(44, 'lorenzotremolanti@marconnessi.com', '7509acf33d29d6f6ebcd3f3d204bf31ad368000704d7fee8f44fcda5ee39348f', 'Lorenzo', 'Tremolanti', '2006-04-01', 3, '2025-05-23 22:42:14'),
(45, 'damianoucciardo@marconnessi.com', '96e3161f033167c7c5238c6484c88f2fc8ea88f4af95d680e9f7b7495e08b267', 'Damiano', 'Ucciardo', '2006-07-02', 3, '2025-05-26 08:17:12'),
(46, 'romannonikolovvratsov@marconnessi.com', 'b6d962771ecd156720871917b6b9532e3c67af7e10c5b02f59c50c94b33cd277', 'Romanno ', 'Vratsov nikolov', '2006-05-19', 3, '2025-05-25 23:01:27'),
(47, 'fangzhenglin@marconnessi.com', '8daf6ca7170ba127f9566a99fd464d35fc01382b5f05b04faf8a9ceba595ee02', 'Fang Zheng', 'Lin', '2006-10-12', 3, '2025-05-25 23:01:49'),
(48, 'test5@esempio.com', 'password', 'Mario', 'Rossi', '2000-01-01', 3, '2025-05-24 01:53:07'),
(49, 'test4634@esempio.com', 'password', 'Mario', 'Rossi', '2000-01-01', 3, '2025-05-24 01:53:55'),
(50, 'test_diego', 'Admin00', 'Diego', 'Ticciati', '2005-10-15', 1, '2025-05-25 17:32:24'),
(52, 'test_diego2', 'e6fe636511f4e52b3d29fe549355fb71e76fa0ec3d394d3dd5b15303dfbf53c0', 'Diego', 'Ticciati', '2005-10-15', 1, '2025-05-25 17:36:14'),
(53, 'marialuisabaracani@marconnessi.prof.com', '5abc95a6ab194f07a9978be7ad1506fc653e4032c541d227a43564d8eb38a6f8', 'Maria Luisa', 'Baracani', '1982-04-28', 2, '2025-05-25 22:59:29'),
(54, 'danielabondi@marconnessi.prof.com', 'c93b6a33f9c6c35c408188d19a6dc3c90984e003eec7b81351b6e71bb9a8fd65', 'Daniela', 'Bondi', '1981-06-15', 2, '2025-05-25 22:59:29'),
(55, 'raffaellacaprio@marconnessi.prof.com', '7c58b8d9a36ad14c5583cf1668f0c06bece7bb4532bc03a42000c5528a7f1903', 'Raffaella', 'Caprio', '1979-11-22', 2, '2025-05-25 22:59:29'),
(56, 'riccardocervelli@marconnessi.prof.com', '9e6d3eb0a7fa5b009e2d716cfb5a4fbd61246e3bcfa9cbb3d3bb43cf67289f5f', 'Riccardo', 'Cervelli', '1983-02-07', 2, '2025-05-25 22:59:29'),
(57, 'mircociriello@marconnessi.prof.com', '2a013208c8263f2b402d3c073d74713c6c53a3ee9d76a8e3ab2d82a774a4a60d', 'Mirco', 'Ciriello', '1980-12-12', 2, '2025-05-25 22:59:29'),
(58, 'vincenzashohrehdemarco@marconnessi.prof.com', 'b5ce02a2b7e9f114607c85c574dea987cd05948de94a4c4c0143e6a19b5d3d1d', 'Vincenza ', 'Shohreh De Marco', '1977-03-03', 2, '2025-05-27 07:02:43'),
(59, 'carminepierofantauzzi@marconnessi.prof.com', 'c8b9cbb659416e88d2c328e49125e29f73f6402abbb0ed3b3e1e1419a3098423', 'Carmine Piero', 'Fantauzzi', '1984-07-30', 2, '2025-05-25 22:59:29'),
(60, 'claudiafederici@marconnessi.prof.com', '7f92bb8c4f0a38b44d3dd98c7b6d5f2ed028e20cd0531fae40368c68e0ff1e20', 'Claudia', 'Federici', '1985-05-20', 2, '2025-05-25 22:59:29'),
(61, 'francescofederico@marconnessi.prof.com', '9b37d73b7e001ac7ecda8a243c5b1651e27b96402072a3e91ab9d1777b0d30cc', 'Francesco', 'Federico', '1978-10-19', 2, '2025-05-25 22:59:29'),
(62, 'stefanolenzi@marconnessi.prof.com', 'eec0a65adf9ebfa81a09b7e83fc9cde8c64e0f962be5e1b3214c89695f6a6b77', 'Stefano', 'Lenzi', '1986-01-10', 2, '2025-05-25 22:59:29'),
(63, 'serenamarradi@marconnessi.prof.com', '1db4a50f1ed2715c3a703b63e65ae250cb42a5b07ab5a045db76c92e0cce1a14', 'Serena', 'Marradi', '1982-09-02', 2, '2025-05-25 22:59:29'),
(64, 'anamelin@marconnessi.prof.com', '72ccdf3f01291c9f299cc0c2e003367689e84294491a65cc82b7cf93a1dfe4b7', 'Ana', 'Melin', '1983-06-18', 2, '2025-05-25 22:59:29'),
(65, 'elisaschianodicola@marconnessi.prof.com', 'fc56fd148c98b616d399f3f3b730ce2d163a4c7a18e2542f5f538dc2f6a57c10', 'Elisa', 'Schiano Di Cola', '1980-08-24', 2, '2025-05-25 22:59:29'),
(66, 'gabrieletoni@marconnessi.prof.com', '5b5937a1f9c6fae3a4a236b8987a14e5c5761ed24e1f12bc8bce6c6a3bffb848', 'Gabriele', 'Toni', '1979-04-09', 2, '2025-05-25 22:59:29');

-- --------------------------------------------------------

--
-- Struttura della tabella `ruoli`
--

CREATE TABLE `ruoli` (
  `id_ruolo` int(11) NOT NULL,
  `ruolo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ruoli`
--

INSERT INTO `ruoli` (`id_ruolo`, `ruolo`) VALUES
(1, 'amministratore'),
(2, 'professore'),
(3, 'studente');

-- --------------------------------------------------------

--
-- Struttura della tabella `settimana`
--

CREATE TABLE `settimana` (
  `id_giorno` int(11) NOT NULL,
  `giorno` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `settimana`
--

INSERT INTO `settimana` (`id_giorno`, `giorno`) VALUES
(1, 'Lunedì'),
(2, 'Martedì'),
(3, 'Mercoled'),
(4, 'Giovedì'),
(5, 'Venerdì'),
(6, 'Sabato'),
(7, 'Domenica');

-- --------------------------------------------------------

--
-- Struttura della tabella `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `oggetto_domanda` varchar(255) NOT NULL,
  `data_domanda` datetime DEFAULT current_timestamp(),
  `domanda_txt` text NOT NULL,
  `data_risposta` datetime DEFAULT NULL,
  `risposta_txt` text DEFAULT NULL,
  `id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ticket`
--

INSERT INTO `ticket` (`id`, `oggetto_domanda`, `data_domanda`, `domanda_txt`, `data_risposta`, `risposta_txt`, `id_persona`) VALUES
(20, 'accesso registro', '2025-05-27 09:56:32', 'come posso accedere al registro elettronico?\n', NULL, NULL, 26);

--
-- Trigger `ticket`
--
DELIMITER $$
CREATE TRIGGER `aggiorna_data_risposta` BEFORE UPDATE ON `ticket` FOR EACH ROW BEGIN
  IF NEW.risposta_txt IS NOT NULL AND OLD.risposta_txt IS NULL THEN
    SET NEW.data_risposta = CURRENT_TIMESTAMP;
  END IF;
END
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `annunci`
--
ALTER TABLE `annunci`
  ADD PRIMARY KEY (`id_annuncio`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indici per le tabelle `aule`
--
ALTER TABLE `aule`
  ADD PRIMARY KEY (`id_aula`),
  ADD KEY `id_edificio` (`id_edificio`);

--
-- Indici per le tabelle `classi`
--
ALTER TABLE `classi`
  ADD PRIMARY KEY (`id_classe`);

--
-- Indici per le tabelle `edifici`
--
ALTER TABLE `edifici`
  ADD PRIMARY KEY (`id_edificio`);

--
-- Indici per le tabelle `frequenta`
--
ALTER TABLE `frequenta`
  ADD PRIMARY KEY (`id_frequenta`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indici per le tabelle `indirizzo`
--
ALTER TABLE `indirizzo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Nome` (`Nome`);

--
-- Indici per le tabelle `indirizzomateria`
--
ALTER TABLE `indirizzomateria`
  ADD PRIMARY KEY (`IndirizzoID`,`MateriaID`),
  ADD KEY `MateriaID` (`MateriaID`);

--
-- Indici per le tabelle `insegna`
--
ALTER TABLE `insegna`
  ADD PRIMARY KEY (`id_insegna`),
  ADD KEY `id_persona` (`id_professore`),
  ADD KEY `id_lezione` (`id_lezione`);

--
-- Indici per le tabelle `lezioni`
--
ALTER TABLE `lezioni`
  ADD PRIMARY KEY (`id_lezione`),
  ADD KEY `id_aula` (`id_aula`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `lezioni_settimana` (`giorno_lezione`);

--
-- Indici per le tabelle `materie`
--
ALTER TABLE `materie`
  ADD PRIMARY KEY (`id_materia`),
  ADD UNIQUE KEY `Nome` (`nome_materia`);

--
-- Indici per le tabelle `persone`
--
ALTER TABLE `persone`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `ruolo` (`ruolo`);

--
-- Indici per le tabelle `ruoli`
--
ALTER TABLE `ruoli`
  ADD PRIMARY KEY (`id_ruolo`);

--
-- Indici per le tabelle `settimana`
--
ALTER TABLE `settimana`
  ADD PRIMARY KEY (`id_giorno`);

--
-- Indici per le tabelle `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_persona` (`id_persona`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `annunci`
--
ALTER TABLE `annunci`
  MODIFY `id_annuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `aule`
--
ALTER TABLE `aule`
  MODIFY `id_aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT per la tabella `classi`
--
ALTER TABLE `classi`
  MODIFY `id_classe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT per la tabella `frequenta`
--
ALTER TABLE `frequenta`
  MODIFY `id_frequenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `indirizzo`
--
ALTER TABLE `indirizzo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `insegna`
--
ALTER TABLE `insegna`
  MODIFY `id_insegna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT per la tabella `lezioni`
--
ALTER TABLE `lezioni`
  MODIFY `id_lezione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT per la tabella `materie`
--
ALTER TABLE `materie`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT per la tabella `persone`
--
ALTER TABLE `persone`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT per la tabella `ruoli`
--
ALTER TABLE `ruoli`
  MODIFY `id_ruolo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `annunci`
--
ALTER TABLE `annunci`
  ADD CONSTRAINT `annunci_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persone` (`id_persona`);

--
-- Limiti per la tabella `aule`
--
ALTER TABLE `aule`
  ADD CONSTRAINT `id_edificio` FOREIGN KEY (`id_edificio`) REFERENCES `edifici` (`id_edificio`);

--
-- Limiti per la tabella `frequenta`
--
ALTER TABLE `frequenta`
  ADD CONSTRAINT `frequenta_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id_classe`),
  ADD CONSTRAINT `frequenta_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `persone` (`id_persona`);

--
-- Limiti per la tabella `indirizzomateria`
--
ALTER TABLE `indirizzomateria`
  ADD CONSTRAINT `indirizzomateria_ibfk_1` FOREIGN KEY (`IndirizzoID`) REFERENCES `indirizzo` (`ID`),
  ADD CONSTRAINT `indirizzomateria_ibfk_2` FOREIGN KEY (`MateriaID`) REFERENCES `materie` (`id_materia`);

--
-- Limiti per la tabella `insegna`
--
ALTER TABLE `insegna`
  ADD CONSTRAINT `insegna_ibfk_1` FOREIGN KEY (`id_professore`) REFERENCES `persone` (`id_persona`),
  ADD CONSTRAINT `insegna_ibfk_2` FOREIGN KEY (`id_lezione`) REFERENCES `lezioni` (`id_lezione`);

--
-- Limiti per la tabella `lezioni`
--
ALTER TABLE `lezioni`
  ADD CONSTRAINT `lezioni_aula` FOREIGN KEY (`id_aula`) REFERENCES `aule` (`id_aula`),
  ADD CONSTRAINT `lezioni_classe` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id_classe`),
  ADD CONSTRAINT `lezioni_materia` FOREIGN KEY (`id_materia`) REFERENCES `materie` (`id_materia`),
  ADD CONSTRAINT `lezioni_settimana` FOREIGN KEY (`giorno_lezione`) REFERENCES `settimana` (`id_giorno`);

--
-- Limiti per la tabella `persone`
--
ALTER TABLE `persone`
  ADD CONSTRAINT `persone_ibfk_1` FOREIGN KEY (`ruolo`) REFERENCES `ruoli` (`id_ruolo`),
  ADD CONSTRAINT `persone_ibfk_2` FOREIGN KEY (`ruolo`) REFERENCES `ruoli` (`id_ruolo`);

--
-- Limiti per la tabella `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persone` (`id_persona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
