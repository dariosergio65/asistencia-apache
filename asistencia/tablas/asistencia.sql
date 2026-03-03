-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-01-2026 a las 15:10:43
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

CREATE TABLE `accesos` (
  `id` int(11) NOT NULL,
  `fechahora` datetime DEFAULT NULL,
  `idusuario` varchar(30) NOT NULL,
  `accion` varchar(20) DEFAULT NULL,
  `latitud` varchar(255) NOT NULL,
  `longitud` varchar(255) NOT NULL,
  `exactitud` varchar(255) DEFAULT NULL,
  `ip` varchar(60) DEFAULT NULL,
  `requesturi` varchar(80) DEFAULT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`id`, `fechahora`, `idusuario`, `accion`, `latitud`, `longitud`, `exactitud`, `ip`, `requesturi`, `flag`) VALUES
(5, '2021-06-24 21:56:45', 'prueba', 'Salida', '-34.6078602', '-58.38311100000001', '3100', '::1', '/asistencia/compruebalogin.php', 1),
(6, '2021-06-25 19:14:29', 'prueba', 'Posicion', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(7, '2021-06-25 19:25:41', 'prueba', 'Posicion', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(11, '2021-06-25 20:06:12', 'prueba', 'Entrada', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(12, '2021-06-25 20:34:28', 'prueba', 'Posicion', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(13, '2021-06-28 21:14:21', 'pepito', 'Entrada', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(14, '2021-06-28 21:23:29', 'pepito', 'Salida', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(15, '2021-06-28 21:39:47', 'pepito', 'Posicion', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(16, '2021-06-28 21:39:47', 'pepito', 'Posicion', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(17, '2021-06-28 21:42:45', 'pepito', 'Posicion', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(18, '2021-06-28 21:44:32', 'prueba', 'Entrada', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(19, '2021-06-28 21:49:07', 'pepito', 'Entrada', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(20, '2021-06-29 13:46:36', 'prueba', 'Posicion', '-34.5879287', '-58.38311100000001', '2605', '::1', '/asistencia/compruebalogin.php', 1),
(21, '2021-07-01 19:15:34', 'prueba', 'Posicion', '-34.5879287', '-58.38311100000001', '2606', '::1', '/asistencia/compruebalogin.php', 1),
(22, '2021-07-01 19:45:59', 'prueba', 'Posicion', '-34.5879287', '-58.38311100000001', '2606', '::1', '/asistencia/compruebalogin.php', 1),
(23, '2021-07-02 16:59:00', 'prueba', 'Posicion', '-34.5879287', '-58.38311100000001', '2606', '::1', '/asistencia/compruebalogin.php', 1),
(24, '2026-01-20 19:40:53', 'prueba', 'Entrada', '-34.5951', '-58.3789', '1500', '::1', '/asistencia/compruebalogin.php', 1),
(25, '2026-01-20 19:42:59', 'prueba', 'Salida', '-34.5951', '-58.3789', '1500', '::1', '/asistencia/compruebalogin.php', 1),
(26, '2026-01-20 19:45:53', 'prueba', 'Entrada', '-34.5951', '-58.3789', '1500', '::1', '/asistencia/compruebalogin.php', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(5) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'personal'),
(3, 'invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `id` int(11) NOT NULL,
  `Opcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `opciones`
--

INSERT INTO `opciones` (`id`, `Opcion`) VALUES
(1, 'Entrada'),
(2, 'Salida'),
(3, 'Posición');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id` int(5) NOT NULL,
  `Sector` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id`, `Sector`) VALUES
(1, 'Ingenieria'),
(2, 'Produccion'),
(3, 'Gestion de Calidad'),
(4, 'Ventas'),
(5, 'Gerencia'),
(6, 'Despachos'),
(7, 'Facturacion'),
(8, 'Invitados'),
(9, 'Compras'),
(10, 'admin'),
(11, 'Servicios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `User` varchar(30) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `id_categoria` int(5) NOT NULL DEFAULT 2,
  `id_sector` int(5) NOT NULL DEFAULT 1,
  `Clave` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`User`, `Nombre`, `id_categoria`, `id_sector`, `Clave`) VALUES
('admin', 'Dario admin', 1, 10, '$2y$10$yuAC6Igo961P/UDMIUxTKeXiEi2jAFpzwHIcILYiXRuLEvFArsUhO'),
('prueba', 'José Perez', 2, 4, '$2y$10$EhQ8YrgyuDawuSOpMK3PD.5EmVIcdo.e7DWPiRQ7P.ndemTCrMT72');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`User`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesos`
--
ALTER TABLE `accesos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
