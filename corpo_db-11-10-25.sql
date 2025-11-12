-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-11-2025 a las 20:55:00
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `corpo_db`
--

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
-- Estructura de tabla para la tabla `corpo_activities`
--

CREATE TABLE `corpo_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `corpo_activities`
--

INSERT INTO `corpo_activities` (`id`, `name`, `description`, `active`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`) VALUES
(1, 'Musculación', 'Entrenamiento con pesas.', 1, '2025-11-10 02:16:04', '2025-11-10 02:16:04', 1, NULL, NULL),
(2, 'Pilates', 'Ejercicios de flexibilidad y fuerza.', 1, '2025-11-10 02:16:04', '2025-11-10 02:16:04', 1, NULL, NULL),
(3, 'Funcional', 'Entrenamiento funcional.aaaaaaaa', 1, '2025-11-10 02:16:04', '2025-11-10 20:45:28', 1, 1, NULL),
(4, 'yoga', 'Entrenamiento yoga.', 1, '2025-11-10 02:16:04', '2025-11-10 02:16:04', 1, NULL, NULL),
(5, 'boxeo', 'Entrenamiento boxeo.', 1, '2025-11-10 02:16:04', '2025-11-10 02:16:04', 1, NULL, NULL),
(6, 'karate', 'Entrenamiento karate.', 1, '2025-11-10 02:16:04', '2025-11-10 20:45:33', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_checkins`
--

CREATE TABLE `corpo_checkins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `checked_in_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `checked_out_at` timestamp NULL DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_contacts`
--

CREATE TABLE `corpo_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_exercises`
--

CREATE TABLE `corpo_exercises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `muscle_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `exercise_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `corpo_exercises`
--

INSERT INTO `corpo_exercises` (`id`, `muscle_group_id`, `exercise_category_id`, `name`, `description`, `video_url`, `video_file`, `active`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`) VALUES
(1, 1, 1, 'Press de banca', NULL, 'https://www.youtube.com/watch?v=gRVjAtPip0Y', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(2, 3, 1, 'Sentadillas', NULL, 'https://www.youtube.com/watch?v=aclHkVaku9U', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(3, 2, 1, 'Remo con barra', NULL, 'https://www.youtube.com/watch?v=vT2GjY_Umpw', NULL, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_exercise_categories`
--

CREATE TABLE `corpo_exercise_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `corpo_exercise_categories`
--

INSERT INTO `corpo_exercise_categories` (`id`, `name`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fuerza', 1, NULL, NULL, NULL),
(2, 'Cardio', 1, NULL, NULL, NULL),
(3, 'Estiramiento', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_financial_reports`
--

CREATE TABLE `corpo_financial_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year_month` varchar(255) NOT NULL,
  `total_memberships_paid` int(11) NOT NULL DEFAULT 0,
  `total_memberships_pending` int(11) NOT NULL DEFAULT 0,
  `total_income` decimal(15,2) NOT NULL DEFAULT 0.00,
  `auto_generated` tinyint(1) NOT NULL DEFAULT 0,
  `income_by_activity` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`income_by_activity`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `corpo_financial_reports`
--

INSERT INTO `corpo_financial_reports` (`id`, `year_month`, `total_memberships_paid`, `total_memberships_pending`, `total_income`, `auto_generated`, `income_by_activity`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`) VALUES
(1, '2025-01', 120, 10, 185000.00, 0, '{\"Musculaci\\u00f3n\":90000,\"Pilates\":50000,\"Funcional\":45000}', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_health_records`
--

CREATE TABLE `corpo_health_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `blood_type` varchar(10) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `injuries` text DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `medications` text DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_members`
--

CREATE TABLE `corpo_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `status` enum('activo','inactivo','suspendido') NOT NULL DEFAULT 'activo',
  `joined_at` date DEFAULT NULL,
  `membership_expires_at` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `corpo_members`
--

INSERT INTO `corpo_members` (`id`, `first_name`, `last_name`, `dni`, `birth_date`, `address`, `phone`, `email`, `observations`, `status`, `joined_at`, `membership_expires_at`, `user_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`) VALUES
(1, 'Juan', 'Pérez', '30123456', '1990-05-14', 'Av. Corrientes 1234', '1123456789', 'juan.perez@example.com', 'Miembro activo desde 2022. Participa en clases de spinning.', 'activo', '2022-01-10', '2025-12-31', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(2, 'María', 'González', '28999888', '1988-03-22', 'San Martín 550', '1134567890', 'maria.gonzalez@example.com', 'Prefiere entrenar por la mañana.', 'activo', '2023-05-12', '2026-05-12', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(3, 'Carlos', 'Fernández', '31555999', '1995-07-09', 'Rivadavia 8000', '1167894321', 'carlos.fernandez@example.com', 'Suspendido temporalmente por falta de pago.', 'suspendido', '2021-09-01', '2025-09-01', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(4, 'Laura', 'Torres', '33456789', '1992-10-10', 'Av. Belgrano 1500', '1176543210', 'laura.torres@example.com', NULL, 'activo', '2022-11-15', '2026-11-15', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(5, 'Diego', 'Ramírez', '29888888', '1987-01-05', 'Mitre 2330', '1187654321', 'diego.ramirez@example.com', 'Entrenamiento personalizado 3 veces por semana.', 'activo', '2023-04-01', '2026-04-01', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(6, 'Lucía', 'Martínez', '31222333', '1998-09-18', 'Calle 9 N°120', '1198765432', 'lucia.martinez@example.com', 'Miembro inactivo desde julio 2024.', 'inactivo', '2020-06-10', '2024-06-10', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(7, 'Fernando', 'Suárez', '32222111', '1991-12-02', 'Av. Cabildo 2500', '1101122233', 'fernando.suarez@example.com', 'Se destaca en musculación.', 'activo', '2022-08-18', '2025-08-18', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(8, 'Valeria', 'Castro', '27666555', '1985-06-30', 'Roca 180', '1144445555', 'valeria.castro@example.com', NULL, 'activo', '2021-12-20', '2025-12-20', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(9, 'Andrés', 'Molina', '30333333', '1990-11-11', '9 de Julio 999', '1177778888', 'andres.molina@example.com', 'Prefiere horario nocturno.', 'activo', '2023-03-15', '2026-03-15', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(10, 'Paula', 'Rojas', '29900123', '1996-02-25', 'Hipólito Yrigoyen 4550', '1122233344', 'paula.rojas@example.com', 'Ha participado en torneos internos.', 'activo', '2021-07-01', '2025-07-01', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(11, 'Ricardo', 'Domínguez', '27889900', '1983-08-05', 'Catamarca 1220', '1100099988', 'ricardo.dominguez@example.com', 'Suspendido temporalmente por lesión.', 'suspendido', '2022-10-10', '2025-10-10', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL),
(12, 'Ana', 'Sánchez', '30111999', '1994-04-04', 'Av. La Plata 330', '1133344455', 'ana.sanchez@example.com', 'Miembro nueva, sin historial médico aún.', 'activo', '2025-11-10', '2026-11-10', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_memberships`
--

CREATE TABLE `corpo_memberships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `membership_price_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active' COMMENT 'e.g., active, expired, pending',
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_membership_combinations`
--

CREATE TABLE `corpo_membership_combinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `membership_price_id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `times_per_week` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `corpo_membership_combinations`
--

INSERT INTO `corpo_membership_combinations` (`id`, `membership_price_id`, `activity_id`, `times_per_week`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 1, '2025-11-10 04:44:07', '2025-11-10 05:16:29'),
(3, 2, 4, 2, '2025-11-10 04:44:07', '2025-11-10 05:16:29'),
(6, 3, 5, 1, '2025-11-10 05:19:12', '2025-11-10 05:31:40'),
(7, 1, 2, 5, '2025-11-10 05:20:08', '2025-11-10 05:31:58'),
(8, 1, 5, 1, '2025-11-10 05:20:20', '2025-11-10 05:31:58'),
(9, 3, 6, 2, '2025-11-10 05:21:29', '2025-11-10 05:31:40'),
(10, 1, 3, 3, '2025-11-10 05:24:23', '2025-11-10 05:31:58'),
(12, 5, 3, 1, '2025-11-10 19:46:22', '2025-11-10 19:48:27'),
(13, 5, 4, 2, '2025-11-10 19:47:40', '2025-11-10 19:48:27'),
(14, 6, 2, 1, '2025-11-11 04:24:32', '2025-11-11 04:24:51'),
(16, 7, 1, 1, '2025-11-11 19:17:36', '2025-11-11 19:17:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_membership_prices`
--

CREATE TABLE `corpo_membership_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plan_type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `corpo_membership_prices`
--

INSERT INTO `corpo_membership_prices` (`id`, `activity_id`, `plan_type`, `price`, `valid_from`, `valid_to`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, NULL, NULL, 18000.00, '2025-11-10', NULL, 1, '2025-11-10 04:43:48', '2025-11-10 05:27:08', NULL, 1, NULL),
(2, NULL, NULL, 30000.00, '2025-11-09', '2025-11-10', 1, '2025-11-10 04:44:07', '2025-11-10 05:16:29', NULL, 1, NULL),
(3, NULL, NULL, 350000.00, '2025-11-10', NULL, 1, '2025-11-10 05:19:12', '2025-11-10 05:25:15', NULL, 1, NULL),
(4, NULL, NULL, 5.00, '2025-11-10', NULL, 1, '2025-11-10 05:33:00', '2025-11-10 19:29:23', '2025-11-10 19:29:23', 1, NULL),
(5, NULL, NULL, 400000.00, '2025-11-09', '2025-11-10', 1, '2025-11-10 19:46:22', '2025-11-10 19:48:27', NULL, 1, NULL),
(6, NULL, NULL, 35000.00, '2025-11-11', NULL, 1, '2025-11-11 04:24:32', '2025-11-11 04:24:32', NULL, 1, NULL),
(7, NULL, NULL, 50000.00, '2025-11-11', NULL, 1, '2025-11-11 19:17:36', '2025-11-11 19:17:36', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_member_activity`
--

CREATE TABLE `corpo_member_activity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `membership_price_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_muscle_groups`
--

CREATE TABLE `corpo_muscle_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `corpo_muscle_groups`
--

INSERT INTO `corpo_muscle_groups` (`id`, `name`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pecho', 1, NULL, NULL, NULL),
(2, 'Espalda', 1, NULL, NULL, NULL),
(3, 'Piernas', 1, NULL, NULL, NULL),
(4, 'Hombros', 1, NULL, NULL, NULL),
(5, 'Bíceps', 1, NULL, NULL, NULL),
(6, 'Tríceps', 1, NULL, NULL, NULL),
(7, 'Abdominales', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_payments`
--

CREATE TABLE `corpo_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `membership_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `expires_at` date DEFAULT NULL,
  `status` enum('cobrado','pendiente','anulado') NOT NULL DEFAULT 'cobrado',
  `payment_method` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_routines`
--

CREATE TABLE `corpo_routines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `trainer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `assigned_at` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_routine_days`
--

CREATE TABLE `corpo_routine_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `routine_id` bigint(20) UNSIGNED NOT NULL,
  `day` tinyint(4) NOT NULL,
  `muscle_focus` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_routine_day_exercises`
--

CREATE TABLE `corpo_routine_day_exercises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `routine_day_id` bigint(20) UNSIGNED NOT NULL,
  `exercise_id` bigint(20) UNSIGNED NOT NULL,
  `series` int(11) DEFAULT NULL,
  `repetitions` int(11) DEFAULT NULL,
  `weight` decimal(6,2) DEFAULT NULL,
  `rest_seconds` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_standard_routines`
--

CREATE TABLE `corpo_standard_routines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_type` enum('ninos','adolescentes','adultos','mayores') NOT NULL,
  `goal` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_standard_routine_exercises`
--

CREATE TABLE `corpo_standard_routine_exercises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `standard_routine_id` bigint(20) UNSIGNED NOT NULL,
  `exercise_id` bigint(20) UNSIGNED NOT NULL,
  `series` int(11) DEFAULT NULL,
  `repetitions` int(11) DEFAULT NULL,
  `rest_seconds` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_trainers`
--

CREATE TABLE `corpo_trainers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `certification` varchar(255) DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_training_plans`
--

CREATE TABLE `corpo_training_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trainer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `user_type` enum('ninos','adolescentes','adultos','mayores') DEFAULT NULL,
  `goal` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_template` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corpo_training_plan_exercises`
--

CREATE TABLE `corpo_training_plan_exercises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `training_plan_id` bigint(20) UNSIGNED NOT NULL,
  `exercise_id` bigint(20) UNSIGNED DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `exercise_name` varchar(255) DEFAULT NULL,
  `series` int(11) DEFAULT NULL,
  `repetitions` int(11) DEFAULT NULL,
  `weight` decimal(6,2) DEFAULT NULL,
  `rest_seconds` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
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
-- Estructura de tabla para la tabla `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '0002_01_01_000001_create_corpo_activities_table', 1),
(5, '0002_01_01_000002_create_corpo_members_table', 1),
(6, '0002_01_01_000003_create_corpo_contacts_table', 1),
(7, '0002_01_01_000004_create_corpo_membership_prices_table', 1),
(8, '0002_01_01_000005_create_corpo_member_activity_table', 1),
(9, '0002_01_01_000006_create_corpo_muscle_groups_table', 1),
(10, '0002_01_01_000007_create_corpo_exercise_categories_table', 1),
(11, '0002_01_01_000008_create_corpo_exercises_table', 1),
(12, '0002_01_01_000009_create_corpo_trainers_table', 1),
(13, '0002_01_01_000010_create_corpo_training_plans_table', 1),
(14, '0002_01_01_000011_create_corpo_training_plan_exercises_table', 1),
(15, '0002_01_01_000012_create_corpo_routines_table', 1),
(16, '0002_01_01_000013_create_corpo_routine_days_table', 1),
(17, '0002_01_01_000014_create_corpo_routine_day_exercises_table', 1),
(18, '0002_01_01_000015_create_corpo_standard_routines_table', 1),
(19, '0002_01_01_000016_create_corpo_standard_routine_exercises_table', 1),
(20, '0002_01_01_000017_create_corpo_health_records_table', 1),
(21, '0002_01_01_000018_create_corpo_memberships_table', 1),
(22, '0002_01_01_000019_create_corpo_payments_table', 1),
(23, '0002_01_01_000020_create_corpo_checkins_table', 1),
(24, '0002_01_01_000021_create_corpo_financial_reports_table', 1),
(25, '0002_01_01_000022_create_corpo_membership_combinations_table', 1),
(26, '2025_10_29_142725_create_permission_tables', 1),
(27, '2025_11_01_144735_create_members_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3);

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
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ver usuarios', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(2, 'crear usuarios', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(3, 'editar usuarios', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(4, 'eliminar usuarios', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(5, 'ver miembros', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(6, 'crear miembros', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(7, 'editar miembros', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(8, 'eliminar miembros', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(9, 'ver rutinas', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(10, 'crear rutinas', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(11, 'editar rutinas', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(12, 'eliminar rutinas', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(13, 'ver pagos', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(14, 'crear pagos', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(15, 'editar pagos', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(16, 'eliminar pagos', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(17, 'ver reportes', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(18, 'exportar reportes', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(19, 'ver roles', 'web', '2025-11-10 04:43:01', '2025-11-10 04:43:01'),
(20, 'crear roles', 'web', '2025-11-10 04:43:02', '2025-11-10 04:43:02'),
(21, 'editar roles', 'web', '2025-11-10 04:43:02', '2025-11-10 04:43:02'),
(22, 'eliminar roles', 'web', '2025-11-10 04:43:02', '2025-11-10 04:43:02'),
(23, 'ver permisos', 'web', '2025-11-10 04:43:02', '2025-11-10 04:43:02'),
(24, 'crear permisos', 'web', '2025-11-10 04:43:02', '2025-11-10 04:43:02'),
(25, 'editar permisos', 'web', '2025-11-10 04:43:02', '2025-11-10 04:43:02'),
(26, 'eliminar permisos', 'web', '2025-11-10 04:43:02', '2025-11-10 04:43:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(2, 'profesor', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(3, 'entrenador', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(4, 'recepcionista', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00'),
(5, 'miembro', 'web', '2025-11-10 04:43:00', '2025-11-10 04:43:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(6, 1),
(6, 4),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(9, 1),
(9, 2),
(9, 3),
(9, 5),
(10, 1),
(10, 2),
(10, 3),
(11, 1),
(11, 2),
(11, 3),
(12, 1),
(13, 1),
(13, 4),
(13, 5),
(14, 1),
(14, 4),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1);

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
('4of8pBEZTzqGruEvtGyp240c25uwJsCqWxN45fur', 1, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibEN4aDJGaE9jdDh5WG04Wld1Q01qRHY0eElWeUh5emd3ME14ZDFIVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjUyOiJodHRwOi8vbG9jYWxob3N0L2NvcnBvL3B1YmxpYy9tZW1iZXItYWN0aXZpdHkvY3JlYXRlIjtzOjU6InJvdXRlIjtzOjIyOiJtZW1iZXJfYWN0aXZpdHkuY3JlYXRlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1762865040),
('ZmPTtEkGfeX5EhkVIxjcRZdjK4GHLj7tAlg1Lfhc', 1, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNW1XWUM5ejBBMFdoQUxlSk1xTXN3dEJQUFhoZTQzbWl2ZTlHaGxkcyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjUyOiJodHRwOi8vbG9jYWxob3N0L2NvcnBvL3B1YmxpYy9tZW1iZXItYWN0aXZpdHkvY3JlYXRlIjtzOjU6InJvdXRlIjtzOjIyOiJtZW1iZXJfYWN0aXZpdHkuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1762893529);

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
(1, 'Administrador', 'admin@corpo.test', NULL, '$2y$12$kP1htmNiB4LI1CKZ01RaI.KhX//s3otzIupMeqbjyF0NlAFseBoEK', NULL, '2025-11-10 04:43:01', '2025-11-10 04:43:01'),
(2, 'Entrenador Demo', 'trainer@corpo.test', NULL, '$2y$12$LFW01qFG9Ad0pJST.Q.T/OUt/dODLL/UqunW3DltCWOdmOdz48zWK', NULL, '2025-11-10 04:43:01', '2025-11-10 04:43:01'),
(3, 'Recepcionista Demo', 'recepcion@corpo.test', NULL, '$2y$12$N9ACjpRVr6qYH0YFFGMaLuNkZper4hPWGf4ZWBRagYwGj7r2AK4P6', NULL, '2025-11-10 04:43:01', '2025-11-10 04:43:01'),
(4, 'Administrador General', 'admin@corpo.com', NULL, '$2y$12$XyiDucgOpT3B64SyNr6AI.zIINveBnkR8.zMpKbHNqg5KaO09ZyN.', NULL, '2025-11-10 04:43:02', '2025-11-10 04:43:02');

--
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `corpo_activities`
--
ALTER TABLE `corpo_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_activities_created_by_foreign` (`created_by`),
  ADD KEY `corpo_activities_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_checkins`
--
ALTER TABLE `corpo_checkins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_checkins_member_id_foreign` (`member_id`),
  ADD KEY `corpo_checkins_user_id_foreign` (`user_id`),
  ADD KEY `corpo_checkins_created_by_foreign` (`created_by`),
  ADD KEY `corpo_checkins_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_contacts`
--
ALTER TABLE `corpo_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_contacts_member_id_foreign` (`member_id`),
  ADD KEY `corpo_contacts_created_by_foreign` (`created_by`),
  ADD KEY `corpo_contacts_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_exercises`
--
ALTER TABLE `corpo_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_exercises_muscle_group_id_foreign` (`muscle_group_id`),
  ADD KEY `corpo_exercises_exercise_category_id_foreign` (`exercise_category_id`),
  ADD KEY `corpo_exercises_created_by_foreign` (`created_by`),
  ADD KEY `corpo_exercises_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_exercise_categories`
--
ALTER TABLE `corpo_exercise_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `corpo_financial_reports`
--
ALTER TABLE `corpo_financial_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_financial_reports_created_by_foreign` (`created_by`),
  ADD KEY `corpo_financial_reports_updated_by_foreign` (`updated_by`),
  ADD KEY `corpo_financial_reports_year_month_index` (`year_month`);

--
-- Indices de la tabla `corpo_health_records`
--
ALTER TABLE `corpo_health_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_health_records_member_id_foreign` (`member_id`),
  ADD KEY `corpo_health_records_created_by_foreign` (`created_by`),
  ADD KEY `corpo_health_records_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_members`
--
ALTER TABLE `corpo_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `corpo_members_dni_unique` (`dni`),
  ADD KEY `corpo_members_user_id_foreign` (`user_id`),
  ADD KEY `corpo_members_created_by_foreign` (`created_by`),
  ADD KEY `corpo_members_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_memberships`
--
ALTER TABLE `corpo_memberships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `corpo_memberships_member_id_start_date_unique` (`member_id`,`start_date`),
  ADD KEY `corpo_memberships_membership_price_id_foreign` (`membership_price_id`),
  ADD KEY `corpo_memberships_created_by_foreign` (`created_by`),
  ADD KEY `corpo_memberships_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_membership_combinations`
--
ALTER TABLE `corpo_membership_combinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_membership_combinations_membership_price_id_foreign` (`membership_price_id`),
  ADD KEY `corpo_membership_combinations_activity_id_foreign` (`activity_id`);

--
-- Indices de la tabla `corpo_membership_prices`
--
ALTER TABLE `corpo_membership_prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `corpo_membership_prices_activity_id_valid_from_unique` (`activity_id`,`valid_from`),
  ADD KEY `corpo_membership_prices_created_by_foreign` (`created_by`),
  ADD KEY `corpo_membership_prices_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_member_activity`
--
ALTER TABLE `corpo_member_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_member_activity_member_id_foreign` (`member_id`),
  ADD KEY `corpo_member_activity_activity_id_foreign` (`activity_id`),
  ADD KEY `corpo_member_activity_membership_price_id_foreign` (`membership_price_id`),
  ADD KEY `corpo_member_activity_created_by_foreign` (`created_by`),
  ADD KEY `corpo_member_activity_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_muscle_groups`
--
ALTER TABLE `corpo_muscle_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `corpo_payments`
--
ALTER TABLE `corpo_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_payments_member_id_foreign` (`member_id`),
  ADD KEY `corpo_payments_membership_id_foreign` (`membership_id`),
  ADD KEY `corpo_payments_created_by_foreign` (`created_by`),
  ADD KEY `corpo_payments_updated_by_foreign` (`updated_by`),
  ADD KEY `corpo_payments_payment_date_index` (`payment_date`),
  ADD KEY `corpo_payments_expires_at_index` (`expires_at`);

--
-- Indices de la tabla `corpo_routines`
--
ALTER TABLE `corpo_routines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_routines_member_id_foreign` (`member_id`),
  ADD KEY `corpo_routines_trainer_id_foreign` (`trainer_id`),
  ADD KEY `corpo_routines_created_by_foreign` (`created_by`),
  ADD KEY `corpo_routines_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_routine_days`
--
ALTER TABLE `corpo_routine_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_routine_days_routine_id_foreign` (`routine_id`),
  ADD KEY `corpo_routine_days_created_by_foreign` (`created_by`),
  ADD KEY `corpo_routine_days_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_routine_day_exercises`
--
ALTER TABLE `corpo_routine_day_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_routine_day_exercises_routine_day_id_foreign` (`routine_day_id`),
  ADD KEY `corpo_routine_day_exercises_exercise_id_foreign` (`exercise_id`),
  ADD KEY `corpo_routine_day_exercises_created_by_foreign` (`created_by`),
  ADD KEY `corpo_routine_day_exercises_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_standard_routines`
--
ALTER TABLE `corpo_standard_routines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_standard_routines_created_by_foreign` (`created_by`),
  ADD KEY `corpo_standard_routines_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_standard_routine_exercises`
--
ALTER TABLE `corpo_standard_routine_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_standard_routine_exercises_standard_routine_id_foreign` (`standard_routine_id`),
  ADD KEY `corpo_standard_routine_exercises_exercise_id_foreign` (`exercise_id`),
  ADD KEY `corpo_standard_routine_exercises_created_by_foreign` (`created_by`),
  ADD KEY `corpo_standard_routine_exercises_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_trainers`
--
ALTER TABLE `corpo_trainers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `corpo_trainers_user_id_unique` (`user_id`),
  ADD KEY `corpo_trainers_created_by_foreign` (`created_by`),
  ADD KEY `corpo_trainers_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_training_plans`
--
ALTER TABLE `corpo_training_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_training_plans_member_id_foreign` (`member_id`),
  ADD KEY `corpo_training_plans_trainer_id_foreign` (`trainer_id`),
  ADD KEY `corpo_training_plans_created_by_foreign` (`created_by`),
  ADD KEY `corpo_training_plans_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `corpo_training_plan_exercises`
--
ALTER TABLE `corpo_training_plan_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corpo_training_plan_exercises_training_plan_id_foreign` (`training_plan_id`),
  ADD KEY `corpo_training_plan_exercises_exercise_id_foreign` (`exercise_id`),
  ADD KEY `corpo_training_plan_exercises_created_by_foreign` (`created_by`),
  ADD KEY `corpo_training_plan_exercises_updated_by_foreign` (`updated_by`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indices de la tabla `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
-- AUTO_INCREMENT de la tabla `corpo_activities`
--
ALTER TABLE `corpo_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `corpo_checkins`
--
ALTER TABLE `corpo_checkins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_contacts`
--
ALTER TABLE `corpo_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_exercises`
--
ALTER TABLE `corpo_exercises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `corpo_exercise_categories`
--
ALTER TABLE `corpo_exercise_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `corpo_financial_reports`
--
ALTER TABLE `corpo_financial_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `corpo_health_records`
--
ALTER TABLE `corpo_health_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_members`
--
ALTER TABLE `corpo_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `corpo_memberships`
--
ALTER TABLE `corpo_memberships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_membership_combinations`
--
ALTER TABLE `corpo_membership_combinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `corpo_membership_prices`
--
ALTER TABLE `corpo_membership_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `corpo_member_activity`
--
ALTER TABLE `corpo_member_activity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_muscle_groups`
--
ALTER TABLE `corpo_muscle_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `corpo_payments`
--
ALTER TABLE `corpo_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_routines`
--
ALTER TABLE `corpo_routines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_routine_days`
--
ALTER TABLE `corpo_routine_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_routine_day_exercises`
--
ALTER TABLE `corpo_routine_day_exercises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_standard_routines`
--
ALTER TABLE `corpo_standard_routines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_standard_routine_exercises`
--
ALTER TABLE `corpo_standard_routine_exercises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_trainers`
--
ALTER TABLE `corpo_trainers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_training_plans`
--
ALTER TABLE `corpo_training_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corpo_training_plan_exercises`
--
ALTER TABLE `corpo_training_plan_exercises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `corpo_activities`
--
ALTER TABLE `corpo_activities`
  ADD CONSTRAINT `corpo_activities_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_activities_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_checkins`
--
ALTER TABLE `corpo_checkins`
  ADD CONSTRAINT `corpo_checkins_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_checkins_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `corpo_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_checkins_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_checkins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `corpo_contacts`
--
ALTER TABLE `corpo_contacts`
  ADD CONSTRAINT `corpo_contacts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_contacts_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `corpo_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_contacts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_exercises`
--
ALTER TABLE `corpo_exercises`
  ADD CONSTRAINT `corpo_exercises_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_exercises_exercise_category_id_foreign` FOREIGN KEY (`exercise_category_id`) REFERENCES `corpo_exercise_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_exercises_muscle_group_id_foreign` FOREIGN KEY (`muscle_group_id`) REFERENCES `corpo_muscle_groups` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_exercises_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_financial_reports`
--
ALTER TABLE `corpo_financial_reports`
  ADD CONSTRAINT `corpo_financial_reports_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_financial_reports_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_health_records`
--
ALTER TABLE `corpo_health_records`
  ADD CONSTRAINT `corpo_health_records_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_health_records_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `corpo_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_health_records_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_members`
--
ALTER TABLE `corpo_members`
  ADD CONSTRAINT `corpo_members_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_members_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `corpo_memberships`
--
ALTER TABLE `corpo_memberships`
  ADD CONSTRAINT `corpo_memberships_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_memberships_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `corpo_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_memberships_membership_price_id_foreign` FOREIGN KEY (`membership_price_id`) REFERENCES `corpo_membership_prices` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_memberships_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_membership_combinations`
--
ALTER TABLE `corpo_membership_combinations`
  ADD CONSTRAINT `corpo_membership_combinations_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `corpo_activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_membership_combinations_membership_price_id_foreign` FOREIGN KEY (`membership_price_id`) REFERENCES `corpo_membership_prices` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `corpo_membership_prices`
--
ALTER TABLE `corpo_membership_prices`
  ADD CONSTRAINT `corpo_membership_prices_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `corpo_activities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_membership_prices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_membership_prices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_member_activity`
--
ALTER TABLE `corpo_member_activity`
  ADD CONSTRAINT `corpo_member_activity_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `corpo_activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_member_activity_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_member_activity_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `corpo_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_member_activity_membership_price_id_foreign` FOREIGN KEY (`membership_price_id`) REFERENCES `corpo_membership_prices` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_member_activity_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_payments`
--
ALTER TABLE `corpo_payments`
  ADD CONSTRAINT `corpo_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_payments_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `corpo_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_payments_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `corpo_memberships` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_routines`
--
ALTER TABLE `corpo_routines`
  ADD CONSTRAINT `corpo_routines_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_routines_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `corpo_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_routines_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_routines_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_routine_days`
--
ALTER TABLE `corpo_routine_days`
  ADD CONSTRAINT `corpo_routine_days_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_routine_days_routine_id_foreign` FOREIGN KEY (`routine_id`) REFERENCES `corpo_routines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_routine_days_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_routine_day_exercises`
--
ALTER TABLE `corpo_routine_day_exercises`
  ADD CONSTRAINT `corpo_routine_day_exercises_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_routine_day_exercises_exercise_id_foreign` FOREIGN KEY (`exercise_id`) REFERENCES `corpo_exercises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_routine_day_exercises_routine_day_id_foreign` FOREIGN KEY (`routine_day_id`) REFERENCES `corpo_routine_days` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_routine_day_exercises_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_standard_routines`
--
ALTER TABLE `corpo_standard_routines`
  ADD CONSTRAINT `corpo_standard_routines_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_standard_routines_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_standard_routine_exercises`
--
ALTER TABLE `corpo_standard_routine_exercises`
  ADD CONSTRAINT `corpo_standard_routine_exercises_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_standard_routine_exercises_exercise_id_foreign` FOREIGN KEY (`exercise_id`) REFERENCES `corpo_exercises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_standard_routine_exercises_standard_routine_id_foreign` FOREIGN KEY (`standard_routine_id`) REFERENCES `corpo_standard_routines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_standard_routine_exercises_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_trainers`
--
ALTER TABLE `corpo_trainers`
  ADD CONSTRAINT `corpo_trainers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_trainers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_trainers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `corpo_training_plans`
--
ALTER TABLE `corpo_training_plans`
  ADD CONSTRAINT `corpo_training_plans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_training_plans_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `corpo_members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_training_plans_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_training_plans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `corpo_training_plan_exercises`
--
ALTER TABLE `corpo_training_plan_exercises`
  ADD CONSTRAINT `corpo_training_plan_exercises_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `corpo_training_plan_exercises_exercise_id_foreign` FOREIGN KEY (`exercise_id`) REFERENCES `corpo_exercises` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `corpo_training_plan_exercises_training_plan_id_foreign` FOREIGN KEY (`training_plan_id`) REFERENCES `corpo_training_plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corpo_training_plan_exercises_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
