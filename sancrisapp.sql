-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2026 a las 01:35:31
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
-- Base de datos: `sancrisapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_user`
--

CREATE TABLE `business_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('propietario','administrador','empleado') NOT NULL DEFAULT 'empleado',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `business_user`
--

INSERT INTO `business_user` (`id`, `user_id`, `business_id`, `role`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'propietario', '2026-04-18 19:33:03', '2026-04-19 02:52:53'),
(6, 2, 2, 'administrador', '2026-04-18 19:57:06', '2026-04-19 02:52:31'),
(7, 2, 3, 'administrador', '2026-04-18 19:57:06', '2026-04-19 02:56:33'),
(8, 2, 4, 'propietario', '2026-04-18 19:57:06', '2026-04-19 02:52:44'),
(9, 2, 5, 'propietario', '2026-04-18 19:57:06', '2026-04-19 02:52:48'),
(10, 3, 2, 'administrador', '2026-04-23 15:26:01', '2026-04-23 15:30:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@test.com|127.0.0.1', 'i:1;', 1776538503),
('laravel-cache-admin@test.com|127.0.0.1:timer', 'i:1776538503;', 1776538503),
('laravel-cache-valebollaylen@gmail.com|127.0.0.1', 'i:2;', 1776553045),
('laravel-cache-valebollaylen@gmail.com|127.0.0.1:timer', 'i:1776553045;', 1776553045);

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
-- Estructura de tabla para la tabla `farmacias_historial`
--

CREATE TABLE `farmacias_historial` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `farmacia_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_turno` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacias_rotacion`
--

CREATE TABLE `farmacias_rotacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `farmacia_id` bigint(20) UNSIGNED NOT NULL,
  `dia_semana` tinyint(1) NOT NULL COMMENT '1=Lunes, 2=Martes, 3=Miércoles, 4=Jueves, 5=Viernes, 6=Sábado, 7=Domingo',
  `semana_mes` tinyint(1) DEFAULT NULL COMMENT '1=Primera semana, 2=Segunda, 3=Tercera, 4=Cuarta, NULL=Todas',
  `fecha_especifica` date DEFAULT NULL COMMENT 'Para turnos en fechas específicas (feriados)',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `farmacias_rotacion`
--

INSERT INTO `farmacias_rotacion` (`id`, `farmacia_id`, `dia_semana`, `semana_mes`, `fecha_especifica`, `activo`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 1, '2026-04-03', 1, '2026-04-23 13:02:32', '2026-04-23 13:02:32'),
(2, 1, 1, NULL, '2026-04-13', 1, '2026-04-23 13:02:32', '2026-04-23 13:02:32'),
(3, 1, 3, NULL, '2026-04-22', 1, '2026-04-23 13:02:32', '2026-04-23 13:02:32'),
(4, 1, 0, NULL, '2026-03-05', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(5, 1, 0, NULL, '2026-03-15', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(6, 1, 0, NULL, '2026-03-25', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(7, 1, 0, NULL, '2026-04-05', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(8, 1, 0, NULL, '2026-04-10', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(9, 1, 0, NULL, '2026-04-26', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(10, 1, 0, NULL, '2026-05-07', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(11, 1, 0, NULL, '2026-05-18', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(12, 1, 0, NULL, '2026-05-27', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(13, 1, 0, NULL, '2026-06-02', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(14, 1, 0, NULL, '2026-06-14', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48'),
(15, 1, 0, NULL, '2026-06-28', 1, '2026-04-23 15:47:48', '2026-04-23 15:47:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `farmacias_turno`
--

CREATE TABLE `farmacias_turno` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `horario_apertura` time DEFAULT NULL,
  `horario_cierre` time DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `farmacias_turno`
--

INSERT INTO `farmacias_turno` (`id`, `nombre`, `direccion`, `telefono`, `latitud`, `longitud`, `horario_apertura`, `horario_cierre`, `descripcion`, `logo`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Dipiazza', 'Alvear 949', '351 123-4567', NULL, NULL, '08:00:00', '22:00:00', 'Farmacia de turno rotativo - Atención las 24 horas en días asignados', NULL, 1, '2026-04-23 13:01:55', '2026-04-23 13:01:55');

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
-- Estructura de tabla para la tabla `negocios`
--

CREATE TABLE `negocios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `horarios` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `negocios`
--

INSERT INTO `negocios` (`id`, `nombre`, `slug`, `direccion`, `telefono`, `descripcion`, `logo`, `horarios`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Ramnelli S.A', 'SI PUEDES PENSARLO PUEDES PROGRAMARLO', 'calle falsa 123', '4532 219039', 'TECNOLOGIA', 'assets/img/logo.png', 'todos los dias ', 1, NULL, NULL),
(2, 'Panadería La Estrella', 'panaderia-la-estrella', 'Av. Trabajadores Ferroviarios 450', '3408421001', 'Las mejores facturas y pan artesanal de San Cristóbal. Tradición familiar desde hace 20 años.', 'logos/panaderia.png', 'Lunes a Sábado: 07:00 - 13:00, 16:30 - 20:30', 1, '2026-04-18 19:53:55', '2026-04-18 19:53:55'),
(3, 'Ferretería El Ferroviario', 'ferreteria-el-ferroviario', 'Caseros 1230', '3408422550', 'Todo lo que necesitas para la construcción y el hogar. Herramientas industriales y pintura.', 'logos/ferreteria.png', 'Lunes a Viernes: 08:00 - 12:00, 15:30 - 19:30', 1, '2026-04-18 19:53:55', '2026-04-18 19:53:55'),
(4, 'Farmacia SanCris', 'farmacia-sancris', 'Alvear 600', '3408425000', 'Atención farmacéutica personalizada, perfumería y envíos a domicilio en toda la ciudad.', 'logos/farmacia.png', 'Abierto 24hs (Turnos según cronograma)', 1, '2026-04-18 19:53:55', '2026-04-18 19:53:55'),
(5, 'Restobar El Encuentro', 'restobar-el-encuentro', 'Pueyrredón 890', '3408429999', 'Especialidad en minutas, pizzas y cervezas artesanales. El punto de reunión de los sancristobalenses.', 'logos/restobar.png', 'Martes a Domingo: 19:00 - 01:00', 1, '2026-04-18 19:53:55', '2026-04-18 19:53:55');

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
-- Estructura de tabla para la tabla `servicios_publicos`
--

CREATE TABLE `servicios_publicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('colectivo','taxi','remis') NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_publicos`
--

INSERT INTO `servicios_publicos` (`id`, `tipo`, `nombre`, `horario`, `telefono`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'colectivo', 'Línea 5 - Centro', '05:00 a 23:00', '0800-555-1234', 'Recorre todo el centro de la ciudad', NULL, NULL),
(2, 'colectivo', 'Línea 8 - Hospital', '06:00 a 22:00', '0800-555-5678', 'Conexión directa al hospital municipal', NULL, NULL),
(3, 'taxi', 'Radio Taxi San Cristóbal', '24 horas', '3514445555', 'Servicio las 24 horas', NULL, NULL),
(4, 'remis', 'Remis del Centro', '06:00 a 02:00', '3516667777', 'Viajes a todo la ciudad', NULL, NULL);

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
('GJ6lkS5bhr9VjliJ7yt05JCk5leKGgeeyiFOtSNg', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiemdHcmRIQWxjc1NPM0psSVNlM1NjMmgxUVdsanhxcEhLRjRRaEtZSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mYXJtYWNpYXMvY3JlYXRlIjtzOjU6InJvdXRlIjtzOjE2OiJmYXJtYWNpYXMuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1776962123);

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
(1, 'Admin Prueba', 'admin@test.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2026-04-18 18:44:00', '2026-04-18 18:44:00'),
(2, 'Tiago Raminelli', 'tiagoraminelli@gmail.com', NULL, '$2y$12$kJiGZFsalkN3OM3KWnNGsuq0eeFFaln91iemxUN4Dcm6I5WVy/CZm', NULL, '2026-04-18 21:54:25', '2026-04-18 21:54:25'),
(3, 'Vale Aylen Boll', 'test@example.us', NULL, '$2y$12$24IifzO7fxfdg/UvnYWGaODCdODS4UDjghF6nqca1ClfQabNkGiHq', NULL, '2026-04-19 01:22:55', '2026-04-19 01:22:55');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `business_user`
--
ALTER TABLE `business_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_business` (`user_id`,`business_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_business_id` (`business_id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `farmacias_historial`
--
ALTER TABLE `farmacias_historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farmacias_historial_farmacia_id_index` (`farmacia_id`),
  ADD KEY `farmacias_historial_fecha_turno_index` (`fecha_turno`);

--
-- Indices de la tabla `farmacias_rotacion`
--
ALTER TABLE `farmacias_rotacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farmacias_rotacion_farmacia_id_index` (`farmacia_id`),
  ADD KEY `farmacias_rotacion_dia_semana_index` (`dia_semana`);

--
-- Indices de la tabla `farmacias_turno`
--
ALTER TABLE `farmacias_turno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farmacias_activo_index` (`activo`);

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
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `negocios`
--
ALTER TABLE `negocios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `negocios_slug_unique` (`slug`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `servicios_publicos`
--
ALTER TABLE `servicios_publicos`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `business_user`
--
ALTER TABLE `business_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `farmacias_historial`
--
ALTER TABLE `farmacias_historial`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `farmacias_rotacion`
--
ALTER TABLE `farmacias_rotacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `farmacias_turno`
--
ALTER TABLE `farmacias_turno`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `negocios`
--
ALTER TABLE `negocios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicios_publicos`
--
ALTER TABLE `servicios_publicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `business_user`
--
ALTER TABLE `business_user`
  ADD CONSTRAINT `fk_business_user_business` FOREIGN KEY (`business_id`) REFERENCES `negocios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_business_user_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `farmacias_historial`
--
ALTER TABLE `farmacias_historial`
  ADD CONSTRAINT `farmacias_historial_farmacia_id_foreign` FOREIGN KEY (`farmacia_id`) REFERENCES `farmacias_turno` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `farmacias_rotacion`
--
ALTER TABLE `farmacias_rotacion`
  ADD CONSTRAINT `farmacias_rotacion_farmacia_id_foreign` FOREIGN KEY (`farmacia_id`) REFERENCES `farmacias_turno` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
