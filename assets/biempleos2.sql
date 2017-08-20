-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-08-2017 a las 00:34:18
-- Versión del servidor: 5.7.9
-- Versión de PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biempleos2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirante`
--

DROP TABLE IF EXISTS `aspirante`;
CREATE TABLE IF NOT EXISTS `aspirante` (
  `id_usuario` int(11) NOT NULL,
  `gcm` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

DROP TABLE IF EXISTS `cita`;
CREATE TABLE IF NOT EXISTS `cita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_local` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL,
  `mensaje` longtext NOT NULL,
  PRIMARY KEY (`id`,`id_usuario`) USING BTREE,
  KEY `id_local` (`id_local`),
  KEY `FK_EmpresaCita` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_expiracion` timestamp NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `local`
--

DROP TABLE IF EXISTS `local`;
CREATE TABLE IF NOT EXISTS `local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `numero` int(11) NOT NULL,
  `colonia` varchar(100) NOT NULL,
  `codigo_postal` int(11) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`,`id_usuario`) USING BTREE,
  KEY `FK_EmpresaLocal` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
CREATE TABLE IF NOT EXISTS `solicitud` (
  `id_usuario` int(11) NOT NULL,
  `foto` longtext,
  `nombre` text,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` tinyint(1) DEFAULT NULL,
  `nacionalidad` text,
  `estatura` double DEFAULT NULL,
  `peso` double DEFAULT NULL,
  `estado_civil` tinyint(1) DEFAULT NULL,
  `calle` text,
  `numero` text,
  `colonia` text,
  `codigo_postal` text,
  `curp` text,
  `rfc` text,
  `nss` text,
  `afore` text,
  `cartilla_militar` text,
  `pasaporte` text,
  `licencia` tinyint(1) DEFAULT NULL,
  `clase_licencia` tinyint(1) DEFAULT NULL,
  `numero_licencia` text,
  `deportista` tinyint(1) DEFAULT NULL,
  `deporte` text,
  `club` tinyint(1) DEFAULT NULL,
  `pasatiempo` text,
  `meta` text,
  `estudio` tinyint(1) DEFAULT NULL,
  `escuela` text,
  `inicio` date DEFAULT NULL,
  `finalizacion` date DEFAULT NULL,
  `titulo` tinyint(1) DEFAULT NULL,
  `idioma` text,
  `porcentaje` int(11) DEFAULT NULL,
  `funciones_oficina` text,
  `maquinaria_oficina` text,
  `software` text,
  `otras_funciones` text,
  `trabajo_anterior` tinyint(1) DEFAULT NULL,
  `tiempo_trabajo` double DEFAULT NULL,
  `compania` text,
  `direccion` text,
  `telefono` text,
  `puesto` text,
  `sueldo_inicial` double DEFAULT NULL,
  `sueldo_final` double DEFAULT NULL,
  `motivo_separacion` text,
  `nombre_jefe` text,
  `puesto_jefe` text,
  `nombre_ref1` text,
  `domicilio_ref1` text,
  `telefono_ref1` text,
  `ocupacion_ref1` text,
  `tiempo_ref1` double DEFAULT NULL,
  `nombre_ref2` text,
  `domicilio_ref2` text,
  `telefono_ref2` text,
  `ocupacion_ref2` text,
  `tiempo_ref2` double DEFAULT NULL,
  `nombre_ref3` text,
  `domicilio_ref3` text,
  `telefono_ref3` text,
  `ocupacion_ref3` text,
  `tiempo_ref3` double DEFAULT NULL,
  `parientes` tinyint(1) DEFAULT NULL,
  `afianzado` tinyint(1) DEFAULT NULL,
  `sindicato` tinyint(1) DEFAULT NULL,
  `seguro_vida` tinyint(1) DEFAULT NULL,
  `viajar` tinyint(1) DEFAULT NULL,
  `cambiar_residencia` tinyint(1) DEFAULT NULL,
  `otros_ingresos` tinyint(1) DEFAULT NULL,
  `importe_ingresos` double DEFAULT NULL,
  `conyuge_trabaja` tinyint(1) DEFAULT NULL,
  `percepcion` double DEFAULT NULL,
  `casa_propia` tinyint(1) DEFAULT NULL,
  `valor_casa` double DEFAULT NULL,
  `paga_renta` tinyint(1) DEFAULT NULL,
  `renta` double DEFAULT NULL,
  `dependientes` int(11) DEFAULT NULL,
  `automovil` tinyint(1) DEFAULT NULL,
  `deudas` tinyint(1) DEFAULT NULL,
  `importe_deudas` double DEFAULT NULL,
  `acreedor` text,
  `abono_mensual` double DEFAULT NULL,
  `gastos_mensuales` double DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `contrasena_hash` varchar(255) NOT NULL,
  `contrasena_reset_token` varchar(255) DEFAULT NULL,
  `rol` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `reset_token` (`contrasena_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante`
--

DROP TABLE IF EXISTS `vacante`;
CREATE TABLE IF NOT EXISTS `vacante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_local` int(11) NOT NULL,
  `puesto` varchar(255) NOT NULL,
  `sueldo` varchar(100) DEFAULT NULL,
  `ofrece` longtext,
  `requisito` longtext NOT NULL,
  `horario` varchar(100) NOT NULL,
  `fecha_publicacion` timestamp NULL DEFAULT NULL,
  `fecha_finalizacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`id_usuario`,`id_local`) USING BTREE,
  KEY `FK_EmpresaVacante` (`id_usuario`),
  KEY `FK_LocalVacante` (`id_local`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante_aspirante`
--

DROP TABLE IF EXISTS `vacante_aspirante`;
CREATE TABLE IF NOT EXISTS `vacante_aspirante` (
  `id_usuario` int(11) NOT NULL,
  `id_vacante` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_cambio_estado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`,`id_vacante`),
  KEY `FK_VacanteVA` (`id_vacante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aspirante`
--
ALTER TABLE `aspirante`
  ADD CONSTRAINT `FK_UsuarioAspirante` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `FK_EmpresaCita` FOREIGN KEY (`id_usuario`) REFERENCES `empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_LocalCita` FOREIGN KEY (`id_local`) REFERENCES `local` (`id`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `FK_UsuarioEmpresa` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `local`
--
ALTER TABLE `local`
  ADD CONSTRAINT `FK_EmpresaLocal` FOREIGN KEY (`id_usuario`) REFERENCES `empresa` (`id_usuario`);

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `FK_AspiranteSolicitud` FOREIGN KEY (`id_usuario`) REFERENCES `aspirante` (`id_usuario`);

--
-- Filtros para la tabla `vacante`
--
ALTER TABLE `vacante`
  ADD CONSTRAINT `FK_EmpresaVacante` FOREIGN KEY (`id_usuario`) REFERENCES `empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_LocalVacante` FOREIGN KEY (`id_local`) REFERENCES `local` (`id`);

--
-- Filtros para la tabla `vacante_aspirante`
--
ALTER TABLE `vacante_aspirante`
  ADD CONSTRAINT `FK_AspiranteVA` FOREIGN KEY (`id_usuario`) REFERENCES `aspirante` (`id_usuario`),
  ADD CONSTRAINT `FK_VacanteVA` FOREIGN KEY (`id_vacante`) REFERENCES `vacante` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
