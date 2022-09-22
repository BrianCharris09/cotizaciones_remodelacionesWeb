-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2022 at 09:56 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `remodelaciones`
--

-- --------------------------------------------------------

--
-- Table structure for table `historial_remodelaciones`
--

CREATE TABLE `historial_remodelaciones` (
  `codhistorial_remodelaciones` int(11) NOT NULL,
  `medidaParedA` double NOT NULL,
  `medidaParedB` double NOT NULL,
  `medidasRestanteA` double NOT NULL,
  `mediasrestamtesB` double NOT NULL,
  `totalareaConstruccion` double NOT NULL,
  `totalCotizacion` double NOT NULL,
  `resivirasesoramiento` tinyint(4) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  `fechaModificacion` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `objetos`
--

CREATE TABLE `objetos` (
  `codObjeto` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `medidas` double NOT NULL,
  `imagen` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `objetos`
--

INSERT INTO `objetos` (`codObjeto`, `tipo`, `medidas`, `imagen`) VALUES
(20, 'campana', 30, 'img/campana1.jpg'),
(95, 'lavaplatos', 24, 'img/lavaplatos.png'),
(120, 'nevera', 31, 'img/nevera1.jpg'),
(180, 'nevera', 32, 'img/nevera2.jpg'),
(199, 'nevera', 37, 'img/nevera3.jpg'),
(201, 'estufa', 30, 'img/estufa1.png');

-- --------------------------------------------------------

--
-- Table structure for table `objetosarea`
--

CREATE TABLE `objetosarea` (
  `idobjetosArea` int(11) NOT NULL,
  `codObjeto` int(11) NOT NULL,
  `codhistorial_remodelaciones` int(11) NOT NULL,
  `posicion` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsers` int(11) NOT NULL,
  `nombres` varchar(60) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `ciudad` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`idUsers`, `nombres`, `correo`, `telefono`, `ciudad`, `estado`, `direccion`) VALUES
(11, 'Brayan Jesus Charris Cantillo', 'bjcharris4@gmail.com', '3046613064', 'New York', 'New York', 'Avenida 12A # 123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `historial_remodelaciones`
--
ALTER TABLE `historial_remodelaciones`
  ADD PRIMARY KEY (`codhistorial_remodelaciones`),
  ADD KEY `UserService` (`idUser`);

--
-- Indexes for table `objetos`
--
ALTER TABLE `objetos`
  ADD PRIMARY KEY (`codObjeto`);

--
-- Indexes for table `objetosarea`
--
ALTER TABLE `objetosarea`
  ADD PRIMARY KEY (`idobjetosArea`),
  ADD UNIQUE KEY `codObjeto_UNIQUE` (`codObjeto`),
  ADD KEY `historialremodelacion_idx` (`codhistorial_remodelaciones`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historial_remodelaciones`
--
ALTER TABLE `historial_remodelaciones`
  MODIFY `codhistorial_remodelaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32124235;

--
-- AUTO_INCREMENT for table `objetosarea`
--
ALTER TABLE `objetosarea`
  MODIFY `idobjetosArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historial_remodelaciones`
--
ALTER TABLE `historial_remodelaciones`
  ADD CONSTRAINT `UserService` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `objetosarea`
--
ALTER TABLE `objetosarea`
  ADD CONSTRAINT `codobjeto` FOREIGN KEY (`codObjeto`) REFERENCES `objetos` (`codObjeto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `historialremodelacion` FOREIGN KEY (`codhistorial_remodelaciones`) REFERENCES `historial_remodelaciones` (`codhistorial_remodelaciones`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
