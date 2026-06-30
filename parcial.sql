-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-06-2026 a las 15:01:31
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `parcial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_interes`
--

DROP TABLE IF EXISTS `areas_interes`;
CREATE TABLE IF NOT EXISTS `areas_interes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `areas_interes`
--

INSERT INTO `areas_interes` (`id`, `nombre`) VALUES
(6, 'Big Data'),
(8, 'Blockchain'),
(3, 'Ciberseguridad'),
(5, 'Cloud Computing'),
(4, 'Desarrollo Móvil'),
(1, 'Desarrollo Web'),
(9, 'DevOps'),
(2, 'Inteligencia Artificial'),
(7, 'IoT (Internet de las Cosas)'),
(10, 'Machine Learning');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscriptores`
--

DROP TABLE IF EXISTS `inscriptores`;
CREATE TABLE IF NOT EXISTS `inscriptores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identidad` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `edad` int NOT NULL,
  `sexo` enum('Masculino','Femenino','Otro') NOT NULL,
  `pais_residencia_id` int NOT NULL,
  `nacionalidad_id` int NOT NULL,
  `correo` varchar(150) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `observaciones` text,
  `firma_digital` text NOT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identidad` (`identidad`),
  UNIQUE KEY `uq_correo` (`correo`),
  UNIQUE KEY `uq_celular` (`celular`),
  KEY `fk_inscriptor_pais_residencia` (`pais_residencia_id`),
  KEY `fk_inscriptor_nacionalidad` (`nacionalidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inscriptores`
--

INSERT INTO `inscriptores` (`id`, `identidad`, `nombre`, `apellido`, `edad`, `sexo`, `pais_residencia_id`, `nacionalidad_id`, `correo`, `celular`, `observaciones`, `firma_digital`, `fecha_registro`) VALUES
(1, '8-1019-2150', 'Irvin', 'Gonzalez', 19, 'Masculino', 1, 1, 'irvin.gonzalez13@gmial.com', '64750144', 'kfehvcjefvjfecvugr', 'XxxGjfAjNX/nEosvuvnO414l9xPNkH8vBm0E7hfqFopSTEj9SsIQgR6+t5E8tbPy2+j68K1AcGFtfT+et9j0Un/czT+DCDh5ookT03He7Z2OuPGMm9NLqul7gc/IBfoJJ4o1almISO9xfdQsGx57qBpH2giPL83CyBmU30T8JtGf3WPdsOocXkNrrEPXUYMUkzWFMX0V0JS2cpNm1XZs3N4JDfefkVeBbkP3Am75REOzSIf/1e1JNnBApGYoLCd7FtXm14Ke421MxywZsRyYuxqCUsOANzqb0G61avwsspCsgzUprYaNf8zerfcK2a3d0sRc+jGxUzzQOMEzxC5/lg==', '2026-06-30 13:56:17'),
(5, '984837987', 'Irvin', 'Gonzalez', 21, 'Masculino', 1, 1, 'irvin.gonzalez12@gmial.com', '64750145', 'fjh4igf4htfgrygyu', 'Kf8We5HAfI02pH3/V9izlUd0AOXldHN7Skw4NjxeGj5Fn8FDzu2YFbzpKtdAzTEsc18lLFOl349d/uojBIHRWVYaWTHyjyoo0YxtSY7DL+j0h6vxCbsRhweNxmDJix+m5tROVwtxFfAtFC8DZlkGyeNAKFKg2M3OryFrdVFbkkZzFNuRON1nTFekvjkDODMrbGrc/eb+w1p/ZJJlpFOyhrFYecMGehsg4fmJs5jMutNUaXzamo9QBfaD62GC7GsFPXMyQysbaBFfnND6IDMbAUg72ecur3VFxvYTjqfP7iO7ct5GUgYXQvplpk9LE31DDHlIGrmFFGBxfKnUgAcykw==', '2026-06-30 14:07:42'),
(6, '7348743', 'Moises', 'Angeles', 19, 'Masculino', 1, 1, 'moi@gmail.com', '67097820', 'fbcfeuvcfvcgfcvgfvc', 'H5aoAfzJY8/YGrLY7Vf4rcItMnxEBGXvNqArHB4beYSEiM8A5PKpUF2OmXNmiXKs69ss25LZ3PKnIewdDl3XaM1Iifh4ouB2nWDPiuOaLCKvUZ6XS0MjADLPCS26XI6puzoy8F7lOk9iLWN9OBc+SQRbsJOeG/eI5Cgfr4qtiyVZXG6Ml50evwWAulxwln+8HLZ1694H0/IBzBFABZ+K4E0+g59vkoVVfnjsTVNlPLHKNLgWGE0IgL2Sv/dIfxuHDQFQI3ChamJ3cc1l0G9vA5l2hPMCUNYr+qxx2LAJ7SX+Sd5uuFcIPG1ThE/HMUrmC8Adm7DM8Tmwhz0AeOKSbA==', '2026-06-30 14:17:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscriptor_temas`
--

DROP TABLE IF EXISTS `inscriptor_temas`;
CREATE TABLE IF NOT EXISTS `inscriptor_temas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inscriptor_id` int NOT NULL,
  `area_interes_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_inscriptor_area` (`inscriptor_id`,`area_interes_id`),
  KEY `fk_temas_area` (`area_interes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inscriptor_temas`
--

INSERT INTO `inscriptor_temas` (`id`, `inscriptor_id`, `area_interes_id`) VALUES
(1, 1, 1),
(2, 1, 4),
(3, 5, 5),
(4, 5, 6),
(5, 6, 6),
(6, 6, 8),
(7, 6, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `nombre`) VALUES
(7, 'Argentina'),
(8, 'Chile'),
(2, 'Colombia'),
(3, 'Costa Rica'),
(6, 'España'),
(5, 'Estados Unidos'),
(4, 'México'),
(1, 'Panamá'),
(9, 'Perú'),
(10, 'Venezuela');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscriptores`
--
ALTER TABLE `inscriptores`
  ADD CONSTRAINT `fk_inscriptor_nacionalidad` FOREIGN KEY (`nacionalidad_id`) REFERENCES `paises` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscriptor_pais_residencia` FOREIGN KEY (`pais_residencia_id`) REFERENCES `paises` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscriptor_temas`
--
ALTER TABLE `inscriptor_temas`
  ADD CONSTRAINT `fk_temas_area` FOREIGN KEY (`area_interes_id`) REFERENCES `areas_interes` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_temas_inscriptor` FOREIGN KEY (`inscriptor_id`) REFERENCES `inscriptores` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
