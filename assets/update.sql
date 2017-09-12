-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2017 a las 00:18:07
-- Versión del servidor: 5.7.9
-- Versión de PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biempleos2`
--

-- --------------------------------------------------------

--
-- DROP DE TABLAS EN ORDEN
--

DROP TABLE IF EXISTS `cita`;
DROP TABLE IF EXISTS `vacante_aspirante`;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante_aspirante`
--

DROP TABLE IF EXISTS `vacante_aspirante`;
CREATE TABLE IF NOT EXISTS `vacante_aspirante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aspirante` int(11) NOT NULL,
  `id_vacante` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_cambio_estado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_VacanteVA` (`id_vacante`),
  KEY `FK_AspiranteVA` (`id_aspirante`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE IF NOT EXISTS `cita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_local` int(11) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_va` int(11) NOT NULL,
  `fecha` timestamp NOT NULL,
  `mensaje` longtext NOT NULL,
  PRIMARY KEY (`id`,`id_empresa`) USING BTREE,
  KEY `FK_EmpresaCita` (`id_empresa`),
  KEY `FK_VACita` (`id_va`) USING BTREE,
  KEY `FK_LocalCita` (`id_local`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vacante_aspirante`
--
ALTER TABLE `vacante_aspirante`
  ADD CONSTRAINT `FK_AspiranteVA` FOREIGN KEY (`id_aspirante`) REFERENCES `aspirante` (`id_usuario`),
  ADD CONSTRAINT `FK_VacanteVA` FOREIGN KEY (`id_vacante`) REFERENCES `vacante` (`id`);

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `FK_EmpresaCita` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_LocalCita` FOREIGN KEY (`id_local`) REFERENCES `local` (`id`),
  ADD CONSTRAINT `FK_VACita` FOREIGN KEY (`id_va`) REFERENCES `vacante_aspirante` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
