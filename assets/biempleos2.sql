-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2017 a las 17:34:56
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

DROP DATABASE IF EXISTS biempleos2.`biempleos2`;
CREATE DATABASE IF NOT EXISTS biempleos2.`biempleos2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirante`
--

DROP TABLE IF EXISTS biempleos2.`aspirante`;
CREATE TABLE IF NOT EXISTS biempleos2.`aspirante` (
  `id_usuario` int(11) NOT NULL,
  `gcm` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

DROP TABLE IF EXISTS biempleos2.`cita`;
CREATE TABLE IF NOT EXISTS biempleos2.`cita` (
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

DROP TABLE IF EXISTS biempleos2.`empresa`;
CREATE TABLE IF NOT EXISTS biempleos2.`empresa` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_paquete`
--

DROP TABLE IF EXISTS biempleos2.`empresa_paquete`;
CREATE TABLE IF NOT EXISTS biempleos2.`empresa_paquete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_paquete` int(11) NOT NULL,
  `no_vacante` int(11) NOT NULL,
  `fecha_expiracion` date NOT NULL,
  PRIMARY KEY (`id`,`id_empresa`) USING BTREE,
  KEY `FK_EmpresaEP` (`id_empresa`),
  KEY `FK_PaqueteEP` (`id_paquete`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `local`
--

DROP TABLE IF EXISTS biempleos2.`local`;
CREATE TABLE IF NOT EXISTS biempleos2.`local` (
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

DROP TABLE IF EXISTS biempleos2.`oferta`;
CREATE TABLE IF NOT EXISTS biempleos2.`oferta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paquete` int(11) NOT NULL,
  `descuento` varchar(20) NOT NULL,
  `paquete_padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paquete_padre` (`paquete_padre`),
  KEY `id_paquete` (`id_paquete`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`id`, `id_paquete`, `descuento`, `paquete_padre`) VALUES
(1, 5, '10%', 2),
(2, 6, '10%', 2),
(3, 7, '10%', 2),
(4, 8, '10%', 2),
(5, 9, '10%', 2),
(6, 10, '10%', 2),
(7, 5, '20%', 3),
(8, 6, '20%', 3),
(9, 7, '20%', 3),
(10, 8, '20%', 3),
(11, 9, '20%', 3),
(12, 10, '20%', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete`
--

DROP TABLE IF EXISTS biempleos2.`paquete`;
CREATE TABLE IF NOT EXISTS biempleos2.`paquete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext,
  `no_vacante` int(11) NOT NULL,
  `no_cita` int(11) NOT NULL,
  `duracion` varchar(20) DEFAULT NULL,
  `precio` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paquete`
--

INSERT INTO `paquete` (`id`, `nombre`, `descripcion`, `no_vacante`, `no_cita`, `duracion`, `precio`) VALUES
(1, 'Prueba Gratuita', 'Se da 1 mes gratis con todas las funcionalidades', -1, -1, '1 mes', 0),
(2, 'Pyme', 'Ideal para negocios pequeños que estan empezando', 3, 15, '15 dias', 197.95),
(3, 'Franquisia', 'Ideal para empresas pequeñas o medianas que estan empezando o ya tienen experiencia', 12, 60, '1 mes', 1978.95),
(4, 'Industrial', 'Ideal para empresas pequeñas que estan empezando', -1, -1, '1 mes', 26999.99),
(5, '[PUV]', NULL, 1, 5, '1 semana', 72),
(6, '[PUV]', NULL, 1, 5, '2 semanas', 126),
(7, '[PUV]', NULL, 1, 5, '1 mes', 180),
(8, '[PUC]', NULL, 0, 5, NULL, 36),
(9, '[PUC]', NULL, 0, 15, NULL, 63),
(10, '[PUC]', NULL, 0, 30, NULL, 108);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

DROP TABLE IF EXISTS biempleos2.`solicitud`;
CREATE TABLE IF NOT EXISTS biempleos2.`solicitud` (
  `id_aspirante` int(11) NOT NULL,
  `foto` longtext,
  `nombre` text,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` varchar(15) DEFAULT NULL,
  `nacionalidad` text,
  `estatura` double DEFAULT NULL,
  `peso` double DEFAULT NULL,
  `estado_civil` varchar(20) DEFAULT NULL,
  `calle` text,
  `numero` text,
  `colonia` text,
  `codigo_postal` text,
  `lugar_residencia` varchar(255) DEFAULT NULL,
  `lugar_nacimiento` varchar(255) DEFAULT NULL,
  `vive_con` varchar(40) DEFAULT NULL,
  `curp` text,
  `rfc` text,
  `nss` text,
  `afore` text,
  `cartilla_militar` text,
  `pasaporte` text,
  `clase_licencia` varchar(100) DEFAULT NULL,
  `numero_licencia` text,
  `deporte` text,
  `club` varchar(255) DEFAULT NULL,
  `pasatiempo` text,
  `meta` text,
  `padre_nombre` text,
  `padre_vivefin` tinyint(4) DEFAULT NULL,
  `padre_domicilio` varchar(255) DEFAULT NULL,
  `padre_ocupacion` varchar(255) DEFAULT NULL,
  `madre_nombre` text,
  `madre_vivefin` tinyint(4) DEFAULT NULL,
  `madre_domicilio` varchar(255) DEFAULT NULL,
  `madre_ocupacion` varchar(255) DEFAULT NULL,
  `pareja_nombre` text,
  `pareja_vivefin` tinyint(4) DEFAULT NULL,
  `pareja_domicilio` varchar(255) DEFAULT NULL,
  `pareja_ocupacion` varchar(255) DEFAULT NULL,
  `hijos` varchar(255) DEFAULT NULL,
  `estudio` varchar(100) DEFAULT NULL,
  `escuela` text,
  `inicio` date DEFAULT NULL,
  `finalizacion` date DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `idioma` text,
  `funciones_oficina` text,
  `maquinaria_oficina` text,
  `software` text,
  `otras_funciones` text,
  `tiempo_trabajo` int(3) DEFAULT NULL,
  `compania` text,
  `direccion` text,
  `telefono` text,
  `puesto` text,
  `sueldo_inicial` double DEFAULT NULL,
  `sueldo_final` double DEFAULT NULL,
  `motivo_separacion` text,
  `nombre_jefe` text,
  `puesto_jefe` text,
  `solicitud_informe` tinyint(4) DEFAULT NULL,
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
  `dependientes` varchar(40) DEFAULT NULL,
  `automovil` tinyint(1) DEFAULT NULL,
  `deudas` tinyint(1) DEFAULT NULL,
  `importe_deudas` double DEFAULT NULL,
  `acreedor` text,
  `abono_mensual` double DEFAULT NULL,
  `gastos_mensuales` double DEFAULT NULL,
  PRIMARY KEY (`id_aspirante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS biempleos2.`usuario`;
CREATE TABLE IF NOT EXISTS biempleos2.`usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `contrasena_hash` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `rol` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `reset_token` (`reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante`
--

DROP TABLE IF EXISTS biempleos2.`vacante`;
CREATE TABLE IF NOT EXISTS biempleos2.`vacante` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante_aspirante`
--

DROP TABLE IF EXISTS biempleos2.`vacante_aspirante`;
CREATE TABLE IF NOT EXISTS biempleos2.`vacante_aspirante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aspirante` int(11) NOT NULL,
  `id_vacante` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_cambio_estado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_VacanteVA` (`id_vacante`),
  KEY `FK_AspiranteVA` (`id_aspirante`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aspirante`
--
ALTER TABLE biempleos2.`aspirante`
  ADD CONSTRAINT `FK_UsuarioAspirante` FOREIGN KEY (`id_usuario`) REFERENCES biempleos2.`usuario` (`id`);

--
-- Filtros para la tabla `cita`
--
ALTER TABLE biempleos2.`cita`
  ADD CONSTRAINT `FK_EmpresaCita` FOREIGN KEY (`id_empresa`) REFERENCES biempleos2.`empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_LocalCita` FOREIGN KEY (`id_local`) REFERENCES biempleos2.`local` (`id`),
  ADD CONSTRAINT `FK_VACita` FOREIGN KEY (`id_va`) REFERENCES biempleos2.`vacante_aspirante` (`id`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE biempleos2.`empresa`
  ADD CONSTRAINT `FK_UsuarioEmpresa` FOREIGN KEY (`id_usuario`) REFERENCES biempleos2.`usuario` (`id`);

--
-- Filtros para la tabla `empresa_paquete`
--
ALTER TABLE biempleos2.`empresa_paquete`
  ADD CONSTRAINT `FK_EmpresaEP` FOREIGN KEY (`id_empresa`) REFERENCES biempleos2.`empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_PaqueteEP` FOREIGN KEY (`id_paquete`) REFERENCES biempleos2.`paquete` (`id`);

--
-- Filtros para la tabla `local`
--
ALTER TABLE biempleos2.`local`
  ADD CONSTRAINT `FK_EmpresaLocal` FOREIGN KEY (`id_empresa`) REFERENCES biempleos2.`empresa` (`id_usuario`);

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE biempleos2.`oferta`
  ADD CONSTRAINT `FK_PaqueteOferta` FOREIGN KEY (`id_paquete`) REFERENCES biempleos2.`paquete` (`id`),
  ADD CONSTRAINT `FK_PaquetePadreOferta` FOREIGN KEY (`paquete_padre`) REFERENCES biempleos2.`paquete` (`id`);

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE biempleos2.`solicitud`
  ADD CONSTRAINT `FK_AspiranteSolicitud` FOREIGN KEY (`id_aspirante`) REFERENCES biempleos2.`aspirante` (`id_usuario`);

--
-- Filtros para la tabla `vacante`
--
ALTER TABLE biempleos2.`vacante`
  ADD CONSTRAINT `FK_EmpresaVacante` FOREIGN KEY (`id_empresa`) REFERENCES biempleos2.`empresa` (`id_usuario`),
  ADD CONSTRAINT `FK_LocalVacante` FOREIGN KEY (`id_local`) REFERENCES biempleos2.`local` (`id`);

--
-- Filtros para la tabla `vacante_aspirante`
--
ALTER TABLE biempleos2.`vacante_aspirante`
  ADD CONSTRAINT `FK_AspiranteVA` FOREIGN KEY (`id_aspirante`) REFERENCES biempleos2.`aspirante` (`id_usuario`),
  ADD CONSTRAINT `FK_VacanteVA` FOREIGN KEY (`id_vacante`) REFERENCES biempleos2.`vacante` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
