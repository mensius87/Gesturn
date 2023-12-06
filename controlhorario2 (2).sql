-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2021 at 01:07 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `controlhorario2`
--

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `Id` int(11) NOT NULL,
  `NombreDepartamento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`Id`, `NombreDepartamento`) VALUES
(1, 'RRHH'),
(2, 'Finanzas'),
(3, 'Marketing'),
(4, 'Otros'),
(5, 'Desarrollo');

-- --------------------------------------------------------

--
-- Table structure for table `descanso`
--

CREATE TABLE `descanso` (
  `Id` int(11) NOT NULL,
  `HoraInicioDescanso` datetime DEFAULT NULL,
  `HoraFinDescanso` datetime DEFAULT NULL,
  `TurnoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `descanso`
--

INSERT INTO `descanso` (`Id`, `HoraInicioDescanso`, `HoraFinDescanso`, `TurnoId`) VALUES
(88, '2021-11-01 20:00:00', '2021-11-01 21:00:00', 97),
(89, '2021-11-02 10:00:00', '2021-11-02 11:00:00', 98),
(90, '2021-11-02 12:00:00', '2021-11-02 13:00:00', 99),
(175, '2021-11-18 09:37:37', '2021-11-18 09:37:38', 265),
(176, '2021-11-18 09:37:52', '2021-11-18 09:37:53', 266),
(177, '2021-11-18 09:37:53', '2021-11-18 09:37:54', 266),
(178, '2021-11-18 09:37:54', '2021-11-18 09:37:54', 266),
(179, '2021-11-18 09:37:55', '2021-11-18 09:37:56', 266),
(225, '2021-11-19 12:56:11', '2021-11-19 12:56:32', 320),
(226, '2021-11-19 12:57:13', '2021-11-19 12:57:13', 321),
(227, '2021-11-19 12:57:51', '2021-11-19 12:57:52', 322),
(228, '2021-11-19 12:57:52', '2021-11-19 12:57:53', 322),
(229, '2021-11-19 12:57:53', '2021-11-19 12:57:53', 322),
(230, '2021-11-19 12:57:54', '2021-11-19 12:57:54', 322),
(231, '2021-11-19 12:57:54', '2021-11-19 12:57:55', 322),
(232, '2021-11-22 13:19:41', '2021-11-22 13:19:44', 323),
(233, '2021-11-22 13:19:47', '2021-11-22 13:19:47', 323),
(234, '2021-11-22 13:19:48', '2021-11-22 13:19:48', 323);

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(45) DEFAULT NULL,
  `Apellidos` varchar(45) DEFAULT NULL,
  `Teléfono` int(11) DEFAULT NULL,
  `HorasContrato` int(11) DEFAULT NULL,
  `Administra` tinyint(4) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `Contraseña` varchar(45) DEFAULT NULL,
  `DepartamentoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='\n';

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`Id`, `Nombre`, `Apellidos`, `Teléfono`, `HorasContrato`, `Administra`, `Email`, `Contraseña`, `DepartamentoId`) VALUES
(1, 'Sergio', 'Menéndez Pérez', 100000001, 8, 1, 'sergio@prueba.com', '3bffa4ebdf4874e506c2b12405796aa5', 5),
(4, 'Javier', 'Otero Villamil', 121212122, 6, 0, 'javier@prueba.com', '3c9c03d6008a5adf42c2a55dd4a1a9f2', 4),
(5, 'Julia', 'Ferrero García', 555555555, 8, 0, 'julia@prueba.com', 'c2e285cb33cecdbeb83d2189e983a8c0', 3),
(6, 'Jose Luis', 'Jimenez Márquez', 141414141, 4, 0, 'joseluis@prueba.com', '53184355a57c38c6015ab438838f7389', 3),
(7, 'Anaury', 'Sánchez González', 777777777, 4, 0, 'anaury@prueba.com ', '14af8662f51072bf2b5ddd077bf22ad5', 1),
(8, 'Sara', 'Menéndez Pérez', 888888888, 6, 0, 'sara@prueba.com ', '5bd537fc3789b5482e4936968f0fde95', 4),
(9, 'Alejandro', 'Lopez Fernández', 999999999, 5, 0, 'alejandro@prueba.com', 'd41d8cd98f00b204e9800998ecf8427e', 1),
(10, 'José', 'Albuerne Martín', 101010101, 0, 0, 'jose@prueba.com', '96917805fd060e3766a9a1b834639d35', 1),
(13, 'Mireiaaa', 'Martín García', 131313131, 1, 0, 'mireia@prueba.com', '6153328e647b7f211f9aed151532e28d', 5),
(16, 'Alexia', 'Jimenez Serrano', 654456321, 6, 0, 'alexia@prueba.com', 'e49797d16f72a95ce778fd871b017677', 4),
(17, 'Manuel', 'Sánchez Aznar', 643622345, 4, 0, 'manuel@prueba.com', '96917805fd060e3766a9a1b834639d35', 3);

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE `turno` (
  `Id` int(11) NOT NULL,
  `HoraInicioTurno` datetime DEFAULT NULL,
  `HoraFinTurno` datetime DEFAULT NULL,
  `EmpleadoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `turno`
--

INSERT INTO `turno` (`Id`, `HoraInicioTurno`, `HoraFinTurno`, `EmpleadoId`) VALUES
(97, '2021-11-01 16:00:00', '2021-11-01 21:00:00', 5),
(98, '2021-11-02 08:00:00', '2021-11-02 17:00:00', 5),
(99, '2021-11-03 08:00:00', '2021-11-03 17:00:00', 5),
(265, '2021-11-18 09:37:30', '2021-11-18 09:37:39', 5),
(266, '2021-11-18 09:37:51', '2021-11-18 09:37:57', 5),
(320, '2021-11-19 12:55:59', '2021-11-19 12:56:35', 5),
(321, '2021-11-19 12:56:45', '2021-11-19 12:57:14', 5),
(322, '2021-11-19 12:57:50', NULL, 5),
(323, '2021-11-22 13:19:25', '2021-11-22 13:20:18', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `descanso`
--
ALTER TABLE `descanso`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_Descanso_Turno1_idx` (`TurnoId`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_EMPLEADO_DEPARTAMENTO_idx` (`DepartamentoId`);

--
-- Indexes for table `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_TURNO_EMPLEADO1_idx` (`EmpleadoId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `descanso`
--
ALTER TABLE `descanso`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `turno`
--
ALTER TABLE `turno`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `descanso`
--
ALTER TABLE `descanso`
  ADD CONSTRAINT `fk_Descanso_Turno1` FOREIGN KEY (`TurnoId`) REFERENCES `turno` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_EMPLEADO_DEPARTAMENTO` FOREIGN KEY (`DepartamentoId`) REFERENCES `departamento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `turno`
--
ALTER TABLE `turno`
  ADD CONSTRAINT `fk_TURNO_EMPLEADO1` FOREIGN KEY (`EmpleadoId`) REFERENCES `empleado` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
