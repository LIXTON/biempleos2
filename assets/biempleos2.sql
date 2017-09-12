-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2017 a las 01:36:01
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

--
-- Volcado de datos para la tabla `aspirante`
--

INSERT INTO `aspirante` (`id_usuario`, `gcm`, `activo`) VALUES
(4, '123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

DROP TABLE IF EXISTS `cita`;
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_usuario`, `nombre`) VALUES
(1, 'alfde'),
(2, 'zes'),
(3, 'asd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_paquete`
--

DROP TABLE IF EXISTS `empresa_paquete`;
CREATE TABLE IF NOT EXISTS `empresa_paquete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_paquete` int(11) NOT NULL,
  `no_vacante` int(11) NOT NULL,
  `fecha_expiracion` date NOT NULL,
  PRIMARY KEY (`id`,`id_empresa`) USING BTREE,
  KEY `FK_EmpresaEP` (`id_empresa`),
  KEY `FK_PaqueteEP` (`id_paquete`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa_paquete`
--

INSERT INTO `empresa_paquete` (`id`, `id_empresa`, `id_paquete`, `no_vacante`, `fecha_expiracion`) VALUES
(1, 1, 1, -1, '2017-10-09'),
(2, 2, 1, -1, '2017-10-09'),
(3, 3, 1, -1, '2017-10-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `local`
--

DROP TABLE IF EXISTS `local`;
CREATE TABLE IF NOT EXISTS `local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `numero` int(11) NOT NULL,
  `colonia` varchar(100) NOT NULL,
  `codigo_postal` int(11) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`,`id_empresa`) USING BTREE,
  KEY `FK_EmpresaLocal` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `local`
--

INSERT INTO `local` (`id`, `id_empresa`, `calle`, `numero`, `colonia`, `codigo_postal`, `pais`, `estado`, `ciudad`, `activo`) VALUES
(1, 1, 'test', 123, 'prueba', 123, 'asdasd', 'asdasd', 'asdas', 1),
(2, 1, 'prueba', 321, 'qwe', 321, 'ewq', 'ewq', 'ewq', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

DROP TABLE IF EXISTS `oferta`;
CREATE TABLE IF NOT EXISTS `oferta` (
  `id_paquete` int(11) NOT NULL,
  `descuento` varchar(20) NOT NULL,
  `paquete_padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_paquete`),
  KEY `paquete_padre` (`paquete_padre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete`
--

DROP TABLE IF EXISTS `paquete`;
CREATE TABLE IF NOT EXISTS `paquete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext,
  `no_vacante` int(11) NOT NULL,
  `no_cita` int(11) NOT NULL,
  `duracion` varchar(20) DEFAULT NULL,
  `precio` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paquete`
--

INSERT INTO `paquete` (`id`, `nombre`, `descripcion`, `no_vacante`, `no_cita`, `duracion`, `precio`) VALUES
(1, 'Prueba Gratuita', 'Se da 1 mes gratis con todas las funcionalidades', -1, -1, '1 mes', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
CREATE TABLE IF NOT EXISTS `solicitud` (
  `id_aspirante` int(11) NOT NULL,
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
  PRIMARY KEY (`id_aspirante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`id_aspirante`, `foto`, `nombre`, `fecha_nacimiento`, `sexo`, `nacionalidad`, `estatura`, `peso`, `estado_civil`, `calle`, `numero`, `colonia`, `codigo_postal`, `curp`, `rfc`, `nss`, `afore`, `cartilla_militar`, `pasaporte`, `licencia`, `clase_licencia`, `numero_licencia`, `deportista`, `deporte`, `club`, `pasatiempo`, `meta`, `estudio`, `escuela`, `inicio`, `finalizacion`, `titulo`, `idioma`, `porcentaje`, `funciones_oficina`, `maquinaria_oficina`, `software`, `otras_funciones`, `trabajo_anterior`, `tiempo_trabajo`, `compania`, `direccion`, `telefono`, `puesto`, `sueldo_inicial`, `sueldo_final`, `motivo_separacion`, `nombre_jefe`, `puesto_jefe`, `nombre_ref1`, `domicilio_ref1`, `telefono_ref1`, `ocupacion_ref1`, `tiempo_ref1`, `nombre_ref2`, `domicilio_ref2`, `telefono_ref2`, `ocupacion_ref2`, `tiempo_ref2`, `nombre_ref3`, `domicilio_ref3`, `telefono_ref3`, `ocupacion_ref3`, `tiempo_ref3`, `parientes`, `afianzado`, `sindicato`, `seguro_vida`, `viajar`, `cambiar_residencia`, `otros_ingresos`, `importe_ingresos`, `conyuge_trabaja`, `percepcion`, `casa_propia`, `valor_casa`, `paga_renta`, `renta`, `dependientes`, `automovil`, `deudas`, `importe_deudas`, `acreedor`, `abono_mensual`, `gastos_mensuales`) VALUES
(4, '', 'blah', NULL, NULL, '', NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', NULL, NULL, '', NULL, '', NULL, '', '', NULL, '', NULL, NULL, NULL, '', NULL, '', '', '', '', NULL, NULL, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', NULL, '', '', '', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `correo`, `auth_key`, `contrasena_hash`, `contrasena_reset_token`, `rol`) VALUES
(1, 'zas@g.com', 'ncx3boBBYog0IQn8m-4fjI-n3TRyIepT', '$2y$13$QERBeW4V0C07opXP86BFreJiI2K1ZYMO5ata6HPF4q2AMWQwS7lI6', NULL, 'empresa'),
(2, 'des@g.com', '1QCwngo2a3-39n27oEK78L42__5_Rm5e', '$2y$13$/liva2uafISXlHNjkiOH6.7chGQ5ze8MGlFdbnO4uJ6JwHUpubH0a', NULL, 'empresa'),
(3, 'asd@g.com', 'qWycFlrwtFkFRgzIjJvckirK47J8qsr-', '$2y$13$FBN2/vbtAf1jo7bTjybCGex4NSVwq63SGz4vtW/1f4a/gurhRZPKC', NULL, 'empresa'),
(4, 'movil@g.com', 'seec_kP_xxQJq0LsDXksDilE24zbow5P', '$2y$13$oeT/ZmyrDUspJbEjtsTsi.kRzRjcXvF7.nPBqj52kIiHUfMCN4Wtq', NULL, 'aspirante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante`
--

DROP TABLE IF EXISTS `vacante`;
CREATE TABLE IF NOT EXISTS `vacante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_local` int(11) NOT NULL,
  `puesto` varchar(255) NOT NULL,
  `sueldo` varchar(100) DEFAULT NULL,
  `ofrece` longtext,
  `requisito` longtext NOT NULL,
  `horario` varchar(100) NOT NULL,
  `fecha_publicacion` timestamp NULL DEFAULT NULL,
  `fecha_finalizacion` timestamp NOT NULL,
  `no_cita` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_empresa`,`id_local`) USING BTREE,
  KEY `FK_EmpresaVacante` (`id_empresa`),
  KEY `FK_LocalVacante` (`id_local`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `vacante`
--

INSERT INTO `vacante` (`id`, `id_empresa`, `id_local`, `puesto`, `sueldo`, `ofrece`, `requisito`, `horario`, `fecha_publicacion`, `fecha_finalizacion`, `no_cita`) VALUES
(1, 1, 2, 'asd', 'asd', 'asd', 'asd', 'asd', NULL, '2017-10-09 06:00:00', -1),
(2, 1, 1, 'test', '123', 'qwe', 'qwe', 'prueba', '2017-09-12 04:49:43', '2017-10-09 06:00:00', -1);

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
  ADD CONSTRAINT `FK_EmpresaCita` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_LocalCita` FOREIGN KEY (`id_local`) REFERENCES `local` (`id`),
  ADD CONSTRAINT `FK_VACita` FOREIGN KEY (`id_va`) REFERENCES `vacante_aspirante` (`id`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `FK_UsuarioEmpresa` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `empresa_paquete`
--
ALTER TABLE `empresa_paquete`
  ADD CONSTRAINT `FK_EmpresaEP` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_PaqueteEP` FOREIGN KEY (`id_paquete`) REFERENCES `paquete` (`id`);

--
-- Filtros para la tabla `local`
--
ALTER TABLE `local`
  ADD CONSTRAINT `FK_EmpresaLocal` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_usuario`);

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD CONSTRAINT `FK_PaqueteOferta` FOREIGN KEY (`id_paquete`) REFERENCES `paquete` (`id`),
  ADD CONSTRAINT `FK_PaquetePadreOferta` FOREIGN KEY (`paquete_padre`) REFERENCES `paquete` (`id`);

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `FK_AspiranteSolicitud` FOREIGN KEY (`id_aspirante`) REFERENCES `aspirante` (`id_usuario`);

--
-- Filtros para la tabla `vacante`
--
ALTER TABLE `vacante`
  ADD CONSTRAINT `FK_EmpresaVacante` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_LocalVacante` FOREIGN KEY (`id_local`) REFERENCES `local` (`id`);

--
-- Filtros para la tabla `vacante_aspirante`
--
ALTER TABLE `vacante_aspirante`
  ADD CONSTRAINT `FK_AspiranteVA` FOREIGN KEY (`id_aspirante`) REFERENCES `aspirante` (`id_usuario`),
  ADD CONSTRAINT `FK_VacanteVA` FOREIGN KEY (`id_vacante`) REFERENCES `vacante` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
