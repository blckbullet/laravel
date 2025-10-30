-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2025 a las 01:37:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `escuelita`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `matricula` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `segundo_nombre` varchar(50) DEFAULT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `carrera_id` bigint(20) UNSIGNED NOT NULL,
  `semestre_actual` tinyint(3) UNSIGNED DEFAULT NULL,
  `es_egresado` tinyint(1) NOT NULL DEFAULT 0,
  `esta_activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`matricula`, `nombre`, `segundo_nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `telefono`, `carrera_id`, `semestre_actual`, `es_egresado`, `esta_activo`, `created_at`, `updated_at`) VALUES
('21220501', 'Ana', 'Sofía', 'García', 'López', '21220501@escuela.mx', '22210501', 1, 3, 0, 0, '2025-10-29 22:46:36', '2025-10-30 05:36:50'),
('21220502', 'Bruno', NULL, 'Hernández', 'Martínez', '21220502@escuela.mx', '22210502', 2, 5, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220503', 'Carla', 'Patricia', 'Rodríguez', 'Pérez', '21220503@escuela.mx', '22210503', 3, 7, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220504', 'David', 'Alejandro', 'Fernández', 'Gómez', '21220504@escuela.mx', '22210504', 4, 9, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220505', 'Elena', NULL, 'Díaz', 'Sánchez', '21220505@escuela.mx', '22210505', 5, 1, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220506', 'Fernando', 'José', 'Moreno', 'González', '21220506@escuela.mx', '22210506', 1, 3, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220507', 'Gabriela', NULL, 'Jiménez', 'Cruz', '21220507@escuela.mx', '22210507', 2, 5, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220508', 'Hugo', 'Alberto', 'Ruiz', 'Flores', '21220508@escuela.mx', '22210508', 3, 7, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220509', 'Irene', 'Beatriz', 'Torres', 'Vázquez', '21220509@escuela.mx', '22210509', 4, 9, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220510', 'Jorge', NULL, 'Rojas', 'Mendoza', '21220510@escuela.mx', '22210510', 5, 2, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220511', 'Karen', 'Daniela', 'Soto', 'Silva', '21220511@escuela.mx', '22210511', 1, 4, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220512', 'Leonardo', NULL, 'Reyes', 'Ortiz', '21220512@escuela.mx', '22210512', 2, 6, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220513', 'Marcela', 'Eugenia', 'Acosta', 'Guerrero', '21220513@escuela.mx', '22210513', 3, 8, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220514', 'Nicolás', 'Esteban', 'Navarro', 'Luna', '21220514@escuela.mx', '22210514', 4, 1, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220515', 'Olivia', NULL, 'Salazar', 'Castillo', '21220515@escuela.mx', '22210515', 5, 3, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220516', 'Pablo', 'Francisco', 'Campos', 'Herrera', '21220516@escuela.mx', '22210516', 1, 5, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220517', 'Quetzalli', NULL, 'Vega', 'Mora', '21220517@escuela.mx', '22210517', 2, 7, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220518', 'Ricardo', 'Gerardo', 'Medina', 'Chávez', '21220518@escuela.mx', '22210518', 3, 9, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220519', 'Sofía', 'Guadalupe', 'Guzmán', 'León', '21220519@escuela.mx', '22210519', 4, 2, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220520', 'Tomás', NULL, 'Cabrera', 'Pineda', '21220520@escuela.mx', '22210520', 5, 4, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220521', 'Úrsula', 'Isabel', 'Osorio', 'Rangel', '21220521@escuela.mx', '22210521', 1, 6, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220522', 'Víctor', NULL, 'Delgado', 'Juárez', '21220522@escuela.mx', '22210522', 2, 8, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220523', 'Wendy', 'Julieta', 'Ibarra', 'Domínguez', '21220523@escuela.mx', '22210523', 3, 1, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220524', 'Xavier', 'Kevin', 'Ponce', 'Ríos', '21220524@escuela.mx', '22210524', 4, 3, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220525', 'Yara', NULL, 'Padilla', 'Montes', '21220525@escuela.mx', '22210525', 5, 5, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220526', 'Zacarías', 'Luis', 'Lara', 'Solís', '21220526@escuela.mx', '22210526', 1, 7, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220527', 'Alicia', NULL, 'Meza', 'Cervantes', '21220527@escuela.mx', '22210527', 2, 9, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220528', 'Benjamín', 'Mario', 'Álvarez', 'Figueroa', '21220528@escuela.mx', '22210528', 3, 2, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220529', 'Clara', 'Norma', 'Sandoval', 'Miranda', '21220529@escuela.mx', '22210529', 4, 4, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220530', 'Diego', NULL, 'Valencia', 'Aguilar', '21220530@escuela.mx', '22210530', 5, 6, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220531', 'Estela', 'Ofelia', 'Blanco', 'Benítez', '21220531@escuela.mx', '22210531', 1, 8, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220532', 'Felipe', NULL, 'Estrella', 'Castro', '21220532@escuela.mx', '22210532', 2, 1, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220533', 'Gloria', 'Paula', 'Márquez', 'Rosas', '21220533@escuela.mx', '22210533', 3, 3, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220534', 'Héctor', 'Quintín', 'Cortés', 'Zavala', '21220534@escuela.mx', '22210534', 4, 5, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220535', 'Ismael', NULL, 'Ochoa', 'Paredes', '21220535@escuela.mx', '22210535', 5, 7, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220536', 'Javier', 'Raúl', 'Villalobos', 'Gallardo', '21220536@escuela.mx', '22210536', 1, 9, 1, 1, NULL, '2025-10-29 22:46:36'),
('21220537', 'Lorena', NULL, 'Galindo', 'Bravo', '21220537@escuela.mx', '22210537', 2, 2, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220538', 'Manuel', 'Sergio', 'Roldán', 'Escobar', '21220538@escuela.mx', '22210538', 3, 4, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220539', 'Nancy', 'Teresa', 'Ortega', 'Fuentes', '21220539@escuela.mx', '22210539', 4, 6, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220540', 'Óliver', NULL, 'Vargas', 'Cano', '21220540@escuela.mx', '22210540', 5, 8, 1, 1, NULL, '2025-10-29 22:46:36'),
('21220541', 'Pamela', 'Úrsula', 'Ramos', 'Guerra', '21220541@escuela.mx', '22210541', 1, 1, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220542', 'Ramiro', NULL, 'Zamora', 'Sosa', '21220542@escuela.mx', '22210542', 2, 3, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220543', 'Susana', 'Verónica', 'Abad', 'Orozco', '21220543@escuela.mx', '22210543', 3, 5, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220544', 'Tadeo', 'Walter', 'Báez', 'Peralta', '21220544@escuela.mx', '22210544', 4, 7, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220545', 'Valeria', NULL, 'Cárdenas', 'Quiroz', '21220545@escuela.mx', '22210545', 5, 9, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220546', 'Alfredo', 'Xavier', 'Del Ángel', 'Salcido', '21220546@escuela.mx', '22210546', 1, 2, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220547', 'Blanca', 'Yara', 'Esquivel', 'Téllez', '21220547@escuela.mx', '22210547', 2, 4, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220548', 'Cristian', NULL, 'Fajardo', 'Urbina', '21220548@escuela.mx', '22210548', 3, 6, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220549', 'Dafne', 'Zoe', 'Galicia', 'Varela', '21220549@escuela.mx', '22210549', 4, 8, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
('21220550', 'Efraín', NULL, 'Haro', 'Zepeda', '21220550@escuela.mx', '22210550', 5, 1, 0, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `jefe_area` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `nombre`, `descripcion`, `jefe_area`, `created_at`, `updated_at`) VALUES
(1, 'Ingeniería y Ciencias Exactas', 'Área enfocada en el desarrollo tecnológico y las ciencias fundamentales.', 'Dr. Armando Paredes', '2025-10-29 22:46:35', '2025-10-29 22:46:35'),
(2, 'Ciencias Sociales y Humanidades', 'Área para el estudio de la sociedad, la historia y el arte.', 'Lic. Aquiles Voy', '2025-10-29 22:46:35', '2025-10-29 22:46:35'),
(3, 'Ciencias de la Salud', 'Área dedicada a la medicina, enfermería y nutrición.', 'Dr. Aniceto Pital', '2025-10-29 22:46:35', '2025-10-29 22:46:35'),
(4, 'Ciencias Económico-Administrativas', 'Área de negocios, contaduría y finanzas.', 'Mtro. Bill Gates', '2025-10-29 22:46:35', '2025-10-29 22:46:35'),
(5, 'Artes y Diseño', 'Fomento de la creatividad y la expresión artística.', 'Lic. Vincent Van Gogh', '2025-10-29 22:46:35', '2025-10-29 22:46:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre`, `area_id`, `created_at`, `updated_at`) VALUES
(1, 'Ingeniería en Sistemas Computacionales', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(2, 'Licenciatura en Administración de Empresas', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(3, 'Licenciatura en Derecho', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(4, 'Medicina', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(5, 'Licenciatura en Diseño Gráfico', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL,
  `profesor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`, `materia_id`, `profesor_id`, `created_at`, `updated_at`) VALUES
(1, '101A', 1, 1, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(2, '101B', 2, 6, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(3, '201A', 3, 2, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(4, '301A', 4, 3, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(5, '401A', 5, 4, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(6, '501A', 6, 5, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(7, '102A', 7, 11, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(8, '102B', 8, 16, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(9, '202A', 9, 9, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(10, '302A', 10, 8, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(11, '402A', 11, 13, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(12, '502A', 12, 10, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(13, '103A', 13, 21, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(14, '103B', 14, 26, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(15, '203A', 15, 14, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(16, '303A', 16, 17, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(17, '403A', 17, 18, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(18, '503A', 18, 15, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(19, '104A', 19, 31, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(20, '104B', 20, 36, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(21, '204A', 21, 19, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(22, '304A', 22, 23, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(23, '404A', 23, 28, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(24, '504A', 24, 20, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(25, '105A', 25, 41, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(26, '105B', 26, 46, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(27, '205A', 27, 24, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(28, '305A', 28, 33, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(29, '405A', 29, 38, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(30, '505A', 30, 25, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(31, '106A', 31, 49, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(32, '106B', 32, 32, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(33, '206A', 33, 29, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(34, '306A', 34, 37, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(35, '406A', 35, 43, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(36, '506A', 36, 30, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(37, '107A', 37, 48, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(38, '107B', 38, 27, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(39, '207A', 39, 34, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(40, '307A', 40, 42, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(41, '407A', 41, 48, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(42, '507A', 42, 35, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(43, '108A', 43, 1, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(44, '108B', 44, 6, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(45, '208A', 45, 39, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(46, '308A', 46, 47, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(47, '408A', 47, 22, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(48, '508A', 48, 40, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(49, '109A', 49, 11, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(50, '109B', 50, 16, '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(51, 'acbd', 2, 4, '2025-10-30 06:27:26', '2025-10-30 06:27:26'),
(52, 'asdasd', 19, 16, '2025-10-30 06:34:10', '2025-10-30 06:34:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiales`
--

CREATE TABLE `historiales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumno_matricula` varchar(20) NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL,
  `grupo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `semestre` int(11) DEFAULT NULL,
  `año` int(11) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historiales`
--

INSERT INTO `historiales` (`id`, `alumno_matricula`, `materia_id`, `grupo_id`, `calificacion`, `semestre`, `año`, `tipo`, `created_at`, `updated_at`) VALUES
(1, '21220501', 1, NULL, 5.00, 1, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-30 05:09:54'),
(2, '21220501', 2, NULL, 10.00, 1, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(3, '21220502', 3, NULL, 8.00, 1, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(4, '21220503', 4, NULL, 7.50, 1, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(5, '21220504', 5, NULL, 9.00, 1, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(6, '21220505', 6, NULL, 8.80, 1, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(7, '21220506', 1, NULL, 9.20, 1, 2023, 'Repite', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(8, '21220507', 3, NULL, 10.00, 2, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(9, '21220508', 4, NULL, 6.50, 1, 2021, 'Extraordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(10, '21220509', 5, NULL, 8.50, 2, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(11, '21220510', 6, NULL, 9.70, 2, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(12, '21220511', 7, NULL, 8.10, 2, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(13, '21220512', 9, NULL, 7.90, 2, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(14, '21220513', 10, NULL, 9.40, 2, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(15, '21220514', 11, NULL, 8.60, 2, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(16, '21220515', 12, NULL, 9.90, 2, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(17, '21220516', 7, NULL, 7.00, 3, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(18, '21220517', 9, NULL, 10.00, 3, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(19, '21220518', 10, NULL, 8.30, 3, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(20, '21220519', 11, NULL, 9.00, 3, 2020, 'Repite', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(21, '21220520', 12, NULL, 8.50, 3, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(22, '21220521', 13, NULL, 9.80, 3, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(23, '21220522', 15, NULL, 7.20, 3, 2022, 'Extraordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(24, '21220523', 16, NULL, 8.80, 3, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(25, '21220524', 17, NULL, 9.10, 3, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(26, '21220525', 18, NULL, 8.40, 3, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(27, '21220526', 13, NULL, 9.30, 4, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(28, '21220527', 15, NULL, 9.90, 4, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(29, '21220528', 16, NULL, 7.70, 4, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(30, '21220529', 17, NULL, 8.90, 4, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(31, '21220530', 18, NULL, 9.60, 4, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(32, '21220531', 19, NULL, 8.00, 4, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(33, '21220532', 21, NULL, 7.80, 4, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(34, '21220533', 22, NULL, 9.50, 4, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(35, '21220534', 23, NULL, 8.20, 4, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(36, '21220535', 24, NULL, 8.50, 4, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(37, '21220536', 1, NULL, 10.00, 1, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(38, '21220537', 3, NULL, 10.00, 1, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(39, '21220538', 4, NULL, 9.00, 1, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(40, '21220539', 5, NULL, 9.50, 1, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(41, '21220540', 6, NULL, 8.50, 1, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(42, '21220541', 2, NULL, 7.00, 1, 2024, 'Extraordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(43, '21220542', 9, NULL, 6.00, 2, 2023, 'Repite', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(44, '21220543', 10, NULL, 8.80, 2, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(45, '21220544', 11, NULL, 9.10, 2, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(46, '21220545', 12, NULL, 7.60, 2, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(47, '21220546', 14, NULL, 9.30, 3, 2024, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(48, '21220547', 15, NULL, 8.20, 3, 2023, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(49, '21220548', 16, NULL, 9.90, 3, 2022, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(50, '21220549', 17, NULL, 7.40, 3, 2021, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(51, '21220550', 18, NULL, 8.00, 3, 2020, 'Ordinario', '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(52, '21220502', 5, NULL, 0.00, 2, 2025, 'Extraordinario', '2025-10-30 04:47:55', '2025-10-30 04:47:55'),
(53, '21220502', 1, NULL, 0.00, 2, 2025, 'Ordinario', '2025-10-30 04:59:07', '2025-10-30 04:59:07'),
(54, '21220501', 1, NULL, 4.00, 5, 2025, 'Repite', '2025-10-30 05:10:03', '2025-10-30 05:10:21'),
(55, '21220501', 1, NULL, 5.00, 6, 2025, 'Especial', '2025-10-30 05:10:31', '2025-10-30 05:36:50'),
(56, '21220502', 1, NULL, NULL, 5, 2025, 'Repite', '2025-10-30 06:10:15', '2025-10-30 06:10:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grupo_id` bigint(20) UNSIGNED NOT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `grupo_id`, `dia_semana`, `hora_inicio`, `hora_fin`, `created_at`, `updated_at`) VALUES
(1, 52, 'Martes', '22:37:00', '22:39:00', '2025-10-30 06:34:10', '2025-10-30 06:34:10'),
(2, 52, 'Viernes', '23:38:00', '23:39:00', '2025-10-30 06:34:10', '2025-10-30 06:34:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `creditos` int(11) DEFAULT NULL,
  `semestre_optimo` int(11) DEFAULT NULL,
  `carrera_id` bigint(20) UNSIGNED NOT NULL,
  `prerequisito_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`, `creditos`, `semestre_optimo`, `carrera_id`, `prerequisito_id`, `created_at`, `updated_at`) VALUES
(1, 'Cálculo Diferencial', 8, 1, 1, NULL, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(2, 'Fundamentos de Programación', 8, 1, 1, NULL, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(3, 'Contabilidad Básica', 8, 1, 2, NULL, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(4, 'Introducción al Derecho', 8, 1, 3, NULL, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(5, 'Anatomía Humana I', 10, 1, 4, NULL, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(6, 'Dibujo Arquitectónico', 6, 1, 5, NULL, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(7, 'Cálculo Integral', 8, 2, 1, 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(8, 'Programación Orientada a Objetos', 8, 2, 1, 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(9, 'Contabilidad de Costos', 8, 2, 2, 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(10, 'Derecho Romano', 8, 2, 3, 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(11, 'Anatomía Humana II', 10, 2, 4, 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(12, 'Geometría Descriptiva', 6, 2, 5, 6, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(13, 'Estructuras de Datos', 8, 3, 1, 8, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(14, 'Bases de Datos', 8, 3, 1, 8, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(15, 'Administración Financiera', 8, 3, 2, 9, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(16, 'Derecho Constitucional', 8, 3, 3, 10, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(17, 'Fisiología', 10, 3, 4, 11, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(18, 'Teoría del Diseño', 6, 3, 5, 12, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(19, 'Sistemas Operativos', 8, 4, 1, 13, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(20, 'Redes de Computadoras', 8, 4, 1, 13, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(21, 'Mercadotecnia', 8, 4, 2, 15, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(22, 'Derecho Penal', 8, 4, 3, 16, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(23, 'Farmacología', 10, 4, 4, 17, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(24, 'Diseño Editorial', 6, 4, 5, 18, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(25, 'Ingeniería de Software', 8, 5, 1, 19, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(26, 'Inteligencia Artificial', 8, 5, 1, 19, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(27, 'Recursos Humanos', 8, 5, 2, 21, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(28, 'Derecho Mercantil', 8, 5, 3, 22, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(29, 'Salud Pública', 10, 5, 4, 23, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(30, 'Diseño Web', 6, 5, 5, 24, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(31, 'Desarrollo de Aplicaciones Web', 8, 6, 1, 25, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(32, 'Seguridad Informática', 8, 6, 1, 26, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(33, 'Comercio Internacional', 8, 6, 2, 27, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(34, 'Derecho Fiscal', 8, 6, 3, 28, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(35, 'Pediatría', 10, 6, 4, 29, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(36, 'Animación Digital', 6, 6, 5, 30, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(37, 'Tópicos Avanzados de Programación', 8, 7, 1, 31, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(38, 'Gestión de Proyectos de TI', 8, 7, 1, 32, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(39, 'Simulación de Negocios', 8, 7, 2, 33, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(40, 'Derecho Laboral', 8, 7, 3, 34, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(41, 'Ginecología', 10, 7, 4, 35, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(42, 'Modelado 3D', 6, 7, 5, 36, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(43, 'Residencias Profesionales I', 4, 8, 1, 37, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(44, 'Proyecto de Titulación I', 4, 8, 1, 38, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(45, 'Planeación Estratégica', 8, 8, 2, 39, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(46, 'Amparo', 8, 8, 3, 40, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(47, 'Cirugía', 10, 8, 4, 41, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(48, 'Portafolio Profesional', 6, 8, 5, 42, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(49, 'Residencias Profesionales II', 4, 9, 1, 43, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(50, 'Proyecto de Titulación II', 4, 9, 1, 44, '2025-10-29 22:46:36', '2025-10-29 22:46:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_profesores`
--

CREATE TABLE `materia_profesores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profesor_id` bigint(20) UNSIGNED NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia_profesores`
--

INSERT INTO `materia_profesores` (`id`, `profesor_id`, `materia_id`) VALUES
(1, 1, 1),
(9, 2, 3),
(17, 3, 4),
(25, 4, 5),
(33, 5, 6),
(2, 6, 2),
(18, 8, 10),
(10, 9, 9),
(50, 9, 18),
(34, 10, 12),
(3, 11, 7),
(26, 13, 11),
(19, 13, 16),
(11, 14, 15),
(35, 15, 18),
(4, 16, 8),
(27, 18, 17),
(20, 18, 22),
(36, 20, 24),
(5, 21, 13),
(28, 23, 23),
(21, 23, 28),
(12, 24, 21),
(37, 25, 30),
(6, 26, 14),
(29, 28, 29),
(22, 28, 34),
(13, 29, 27),
(38, 30, 36),
(7, 31, 19),
(30, 33, 35),
(23, 33, 40),
(14, 34, 33),
(39, 35, 42),
(8, 36, 20),
(31, 38, 41),
(24, 38, 46),
(15, 39, 39),
(40, 40, 48),
(41, 41, 25),
(43, 42, 49),
(45, 43, 29),
(32, 43, 47),
(46, 44, 31),
(16, 44, 45),
(47, 45, 32),
(42, 46, 26),
(44, 47, 50),
(48, 48, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Básico de Sistemas 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(2, 'Básico de Sistemas 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(3, 'Básico de Administración 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(4, 'Básico de Administración 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(5, 'Básico de Derecho 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(6, 'Básico de Derecho 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(7, 'Básico de Medicina 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(8, 'Básico de Medicina 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(9, 'Básico de Diseño 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(10, 'Básico de Diseño 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(11, 'Avanzado de Sistemas 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(12, 'Avanzado de Sistemas 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(13, 'Avanzado de Administración 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(14, 'Avanzado de Administración 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(15, 'Avanzado de Derecho 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(16, 'Avanzado de Derecho 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(17, 'Avanzado de Medicina 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(18, 'Avanzado de Medicina 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(19, 'Avanzado de Diseño 1', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(20, 'Avanzado de Diseño 2', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(21, 'Optativas Sistemas A', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(22, 'Optativas Sistemas B', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(23, 'Optativas Administración A', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(24, 'Optativas Administración B', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(25, 'Optativas Derecho A', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(26, 'Optativas Derecho B', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(27, 'Optativas Medicina A', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(28, 'Optativas Medicina B', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(29, 'Optativas Diseño A', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(30, 'Optativas Diseño B', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(31, 'Complementario Humanidades', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(32, 'Complementario Finanzas', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(33, 'Complementario Salud', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(34, 'Complementario Arte', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(35, 'Complementario Programación', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(36, 'Taller de Tesis Sistemas', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(37, 'Taller de Tesis Administración', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(38, 'Taller de Tesis Derecho', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(39, 'Taller de Tesis Medicina', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(40, 'Taller de Tesis Diseño', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(41, 'Introducción a la IA', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(42, 'Desarrollo Frontend', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(43, 'Desarrollo Backend', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(44, 'Marketing Digital', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(45, 'Estrategias de Negocios', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(46, 'Derecho Corporativo', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(47, 'Juicios Orales', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(48, 'Cardiología Básica', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(49, 'Anatomía Avanzada', '2025-10-29 22:46:37', '2025-10-29 22:46:37'),
(50, 'Branding y Publicidad', '2025-10-29 22:46:37', '2025-10-29 22:46:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete_materias`
--

CREATE TABLE `paquete_materias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paquete_id` bigint(20) UNSIGNED NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquete_materias`
--

INSERT INTO `paquete_materias` (`id`, `paquete_id`, `materia_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 7),
(4, 2, 8),
(5, 3, 3),
(6, 3, 9),
(7, 4, 15),
(8, 4, 21),
(9, 5, 4),
(10, 5, 10),
(11, 6, 16),
(12, 6, 22),
(13, 7, 5),
(14, 7, 11),
(15, 8, 17),
(16, 8, 23),
(17, 9, 6),
(18, 9, 12),
(19, 10, 18),
(20, 10, 24),
(21, 11, 13),
(22, 11, 14),
(23, 12, 19),
(24, 12, 20),
(25, 13, 27),
(26, 14, 33),
(27, 15, 28),
(28, 16, 34),
(29, 17, 29),
(30, 18, 35),
(31, 19, 30),
(32, 20, 36),
(33, 21, 31),
(34, 22, 32),
(35, 23, 39),
(36, 24, 45),
(37, 25, 40),
(38, 26, 46),
(39, 27, 41),
(40, 28, 47),
(41, 29, 42),
(42, 30, 48),
(43, 31, 4),
(44, 32, 3),
(45, 33, 5),
(46, 34, 6),
(47, 35, 2),
(48, 36, 44),
(49, 37, 45),
(50, 38, 46),
(51, 39, 47),
(52, 40, 48),
(53, 41, 26),
(54, 42, 25),
(55, 43, 31),
(56, 44, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `telefono`, `area_id`, `created_at`, `updated_at`) VALUES
(1, 'Alberto', 'Gómez', 'Hernández', 'prof1@escuela.edu', '22200001', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(2, 'Beatriz', 'Pérez', 'López', 'prof2@escuela.edu', '22200002', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(3, 'Carlos', 'Martínez', 'García', 'prof3@escuela.edu', '22200003', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(4, 'Diana', 'Ramírez', 'Rodríguez', 'prof4@escuela.edu', '22200004', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(5, 'Ernesto', 'Sánchez', 'Fernández', 'prof5@escuela.edu', '22200005', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(6, 'Fátima', 'González', 'Díaz', 'prof6@escuela.edu', '22200006', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(7, 'Gerardo', 'Cruz', 'Moreno', 'prof7@escuela.edu', '22200007', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(8, 'Hilda', 'Flores', 'Jiménez', 'prof8@escuela.edu', '22200008', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(9, 'Ignacio', 'Vázquez', 'Ruiz', 'prof9@escuela.edu', '22200009', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(10, 'Julieta', 'Mendoza', 'Torres', 'prof10@escuela.edu', '22200010', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(11, 'Kevin', 'Silva', 'Rojas', 'prof11@escuela.edu', '22200011', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(12, 'Laura', 'Ortiz', 'Soto', 'prof12@escuela.edu', '22200012', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(13, 'Mario', 'Guerrero', 'Reyes', 'prof13@escuela.edu', '22200013', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(14, 'Norma', 'Luna', 'Acosta', 'prof14@escuela.edu', '22200014', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(15, 'Óscar', 'Castillo', 'Navarro', 'prof15@escuela.edu', '22200015', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(16, 'Patricia', 'Herrera', 'Salazar', 'prof16@escuela.edu', '22200016', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(17, 'Quintín', 'Mora', 'Campos', 'prof17@escuela.edu', '22200017', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(18, 'Raquel', 'Chávez', 'Vega', 'prof18@escuela.edu', '22200018', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(19, 'Sergio', 'León', 'Medina', 'prof19@escuela.edu', '22200019', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(20, 'Tania', 'Pineda', 'Guzmán', 'prof20@escuela.edu', '22200020', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(21, 'Ulises', 'Rangel', 'Cabrera', 'prof21@escuela.edu', '22200021', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(22, 'Verónica', 'Juárez', 'Osorio', 'prof22@escuela.edu', '22200022', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(23, 'Walter', 'Domínguez', 'Delgado', 'prof23@escuela.edu', '22200023', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(24, 'Ximena', 'Ríos', 'Ibarra', 'prof24@escuela.edu', '22200024', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(25, 'Yael', 'Montes', 'Ponce', 'prof25@escuela.edu', '22200025', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(26, 'Zoe', 'Solís', 'Padilla', 'prof26@escuela.edu', '22200026', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(27, 'Adrián', 'Cervantes', 'Lara', 'prof27@escuela.edu', '22200027', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(28, 'Brenda', 'Figueroa', 'Meza', 'prof28@escuela.edu', '22200028', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(29, 'César', 'Miranda', 'Álvarez', 'prof29@escuela.edu', '22200029', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(30, 'Daniela', 'Aguilar', 'Sandoval', 'prof30@escuela.edu', '22200030', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(31, 'Eduardo', 'Benítez', 'Valencia', 'prof31@escuela.edu', '22200031', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(32, 'Fernanda', 'Castro', 'Blanco', 'prof32@escuela.edu', '22200032', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(33, 'Gustavo', 'Rosas', 'Estrella', 'prof33@escuela.edu', '22200033', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(34, 'Isabel', 'Zavala', 'Márquez', 'prof34@escuela.edu', '22200034', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(35, 'Javier', 'Paredes', 'Cortés', 'prof35@escuela.edu', '22200035', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(36, 'Karla', 'Gallardo', 'Ochoa', 'prof36@escuela.edu', '22200036', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(37, 'Luis', 'Bravo', 'Villalobos', 'prof37@escuela.edu', '22200037', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(38, 'Mónica', 'Escobar', 'Galindo', 'prof38@escuela.edu', '22200038', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(39, 'Natalia', 'Fuentes', 'Roldán', 'prof39@escuela.edu', '22200039', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(40, 'Omar', 'Cano', 'Ortega', 'prof40@escuela.edu', '22200040', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(41, 'Pedro', 'Vargas', 'Solis', 'prof41@escuela.edu', '22200041', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(42, 'Queren', 'Valdez', 'Camacho', 'prof42@escuela.edu', '22200042', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(43, 'Roberto', 'Castañeda', 'Rico', 'prof43@escuela.edu', '22200043', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(44, 'Sandra', 'Núñez', 'Peña', 'prof44@escuela.edu', '22200044', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(45, 'Tomás', 'Salas', 'Franco', 'prof45@escuela.edu', '22200045', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(46, 'Uriel', 'Pacheco', 'Parra', 'prof46@escuela.edu', '22200046', 1, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(47, 'Violeta', 'Corona', 'Serrano', 'prof47@escuela.edu', '22200047', 2, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(48, 'William', 'Barrios', 'Romo', 'prof48@escuela.edu', '22200048', 3, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(49, 'Xochitl', 'Galvan', 'Bautista', 'prof49@escuela.edu', '22200049', 4, '2025-10-29 22:46:36', '2025-10-29 22:46:36'),
(50, 'Yadira', 'Escamilla', 'Celis', 'prof50@escuela.edu', '22200050', 5, '2025-10-29 22:46:36', '2025-10-29 22:46:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('71hYMfowRYvSzsqKqN3W4ap0I055oe9WAPuA10ET', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV0pOa3dlT0JUdEFVNTZwQjU2QzZhMWlmVW9FWnM3NDA4QlNGRzlZSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2hvbWUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2dydXBvcy81MiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1761784592);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ian Balderas Flores', 'bal34471@gmail.com', NULL, '$2y$12$LHLRcrv2uUIddSphNCO9PO/O9b4Ux5iaNqDAdu.s7CEM2kXEJfJ1C', NULL, '2025-10-30 04:47:17', '2025-10-30 04:47:17');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`matricula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_alumnos_carreras` (`carrera_id`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_carreras_areas` (`area_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_grupos_materias` (`materia_id`),
  ADD KEY `fk_grupos_profesores` (`profesor_id`);

--
-- Indices de la tabla `historiales`
--
ALTER TABLE `historiales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_historiales_alumnos` (`alumno_matricula`),
  ADD KEY `fk_historiales_materias` (`materia_id`),
  ADD KEY `fk_historiales_grupos` (`grupo_id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_horarios_grupos` (`grupo_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_materias_carreras` (`carrera_id`),
  ADD KEY `fk_materias_prerequisito` (`prerequisito_id`);

--
-- Indices de la tabla `materia_profesores`
--
ALTER TABLE `materia_profesores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profesor_id` (`profesor_id`,`materia_id`),
  ADD KEY `fk_materia_profesores_materias` (`materia_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paquete_materias`
--
ALTER TABLE `paquete_materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `paquete_id` (`paquete_id`,`materia_id`),
  ADD KEY `fk_paquete_materias_materias` (`materia_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_profesores_areas` (`area_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `historiales`
--
ALTER TABLE `historiales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `materia_profesores`
--
ALTER TABLE `materia_profesores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `paquete_materias`
--
ALTER TABLE `paquete_materias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `fk_alumnos_carreras` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`);

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `fk_carreras_areas` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupos_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`),
  ADD CONSTRAINT `fk_grupos_profesores` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`);

--
-- Filtros para la tabla `historiales`
--
ALTER TABLE `historiales`
  ADD CONSTRAINT `fk_historiales_alumnos` FOREIGN KEY (`alumno_matricula`) REFERENCES `alumnos` (`matricula`),
  ADD CONSTRAINT `fk_historiales_grupos` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `fk_historiales_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_grupos` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `fk_materias_carreras` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `fk_materias_prerequisito` FOREIGN KEY (`prerequisito_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `materia_profesores`
--
ALTER TABLE `materia_profesores`
  ADD CONSTRAINT `fk_materia_profesores_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_materia_profesores_profesores` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `paquete_materias`
--
ALTER TABLE `paquete_materias`
  ADD CONSTRAINT `fk_paquete_materias_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_paquete_materias_paquetes` FOREIGN KEY (`paquete_id`) REFERENCES `paquetes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD CONSTRAINT `fk_profesores_areas` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
