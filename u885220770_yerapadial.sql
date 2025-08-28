-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-07-2025 a las 00:09:54
-- Versión del servidor: 10.11.10-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u885220770_yerapadial`
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

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_codigo_49113947t', 'i:214149;', 1753024024);

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
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `tipo`, `descripcion`, `created_at`, `updated_at`) VALUES
(7, 'Pesas', 'Pesas patrocinadas Finalgym', '2025-06-08 14:32:52', '2025-06-08 14:32:52'),
(8, 'Accesorios', 'Ayudas para entrenar', '2025-06-08 14:34:57', '2025-06-08 14:35:40'),
(9, 'Botellas', 'Botellas para entrenar', '2025-06-08 14:35:24', '2025-06-08 14:35:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `tipo_cuota` bigint(20) UNSIGNED NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `telefono`, `dni`, `email`, `fecha_inicio`, `fecha_caducidad`, `tipo_cuota`, `foto`, `created_at`, `updated_at`) VALUES
(94, 'Ana', 'Padial Leire', '644881848', '49555947T', 'yeraydanko@gmail.com', '2025-06-07', '2025-07-07', 3, 'clientes/IFIy6eorWRRHuJ1RBLrKM72rRtDBMZFlTC8XJ1ac.jpg', '2025-06-07 20:45:35', '2025-07-20 14:16:34'),
(95, 'Diego', 'Mora Dominguez', '680233333', '22235322w', 'rlyerayrocket@gmail.com', '2025-06-08', '2025-08-09', 8, 'clientes/wi35MFFaABaymowBqYjFCP95FjEulxX7kwfPpA3e.jpg', '2025-06-08 13:57:48', '2025-07-20 14:16:11'),
(96, 'Migue', 'Padial Borrero', '123131232', '54654654Q', 'paadyery@gmail.com', '2025-06-08', '2025-07-08', 3, 'clientes/DFkL2uREV0f1ZZBfBObfRB6hRJX8aTaXGinEoLLF.jpg', '2025-06-08 13:59:57', '2025-07-20 14:15:56'),
(97, 'Pepa', 'Jimena Cano', '644881848', '54224654Q', 'paadyery@gmail.com', '2025-06-08', '2025-07-08', 3, 'clientes/o52hNgLSzd42lGT78glb1pGvLhrAfsj4ScAxAOaM.jpg', '2025-06-08 14:00:57', '2025-07-20 14:12:59'),
(98, 'Sara', 'Lore lora', '64488333', '49115547T', 'paadyery@gmail.com', '2025-06-08', '2025-07-08', 3, 'clientes/78VP1LXLHDoAJ0S7V0AesLSWuuLPmT6XuXUlBWPy.jpg', '2025-06-08 14:02:44', '2025-07-20 14:12:44'),
(99, 'Lara', 'Jim Cano', '64488100', '46781557T', 'paadyery@gmail.com', '2025-06-08', '2025-07-08', 3, 'clientes/AYIEbVgQIPuzj2ZdWKuUQLcjl7nfrv9ZrBoTsPfU.jpg', '2025-06-08 14:03:33', '2025-07-20 14:11:53'),
(100, 'Toni', 'Jina Co', '642131848', '49110957T', 'paadyery@gmail.com', '2025-06-19', '2025-07-19', 3, 'clientes/fMwsdinf688FvcTZmTy1NbdpuLbY7Q8RQ6kAwUYx.jpg', '2025-06-08 14:05:57', '2025-07-20 14:11:35'),
(101, 'Juan', 'Quintana Rocio', '756881848', '42210957T', 'paadyery@gmail.com', '2025-06-08', '2025-07-08', 3, 'clientes/4uE9GlD9ppeNAta6TB2bM8JOqQgeHamdzOjLfBlN.jpg', '2025-06-08 14:10:53', '2025-07-20 14:11:21'),
(102, 'Tona', 'Jin Cona', '366881848', '42245957T', 'paadyery@gmail.com', '2025-06-08', '2025-07-08', 3, 'clientes/wAcPfDdqKLUYogVXU5uz3pHFT0wpkUInYvil1gBq.jpg', '2025-06-08 14:12:14', '2025-07-20 14:11:05'),
(103, 'Jordan', 'Merino Rade', '677881148', '49176547T', 'paadyery@gmail.com', '2025-06-08', '2025-06-30', 3, 'clientes/rrR6ZIrRDgEiw7okqwDFH3lSf8APfKcxVtAiuEkb.jpg', '2025-06-08 14:14:33', '2025-07-20 14:10:50'),
(104, 'Carlos', 'Muñoz Dominguez', '644881012', '49888247T', 'yeraydanko@gmail.com', '2025-06-08', '2025-07-08', 3, 'clientes/8m2HGSeIYGHyvxjM5reHlEFxZVs7tv3ywqKdlNMw.jpg', '2025-06-08 14:17:57', '2025-07-20 14:10:20'),
(105, 'Alberto', 'Toscano Dominguez', '644881848', '49880047T', 'yeraydanko@gmail.com', '2025-06-08', '2025-07-08', 3, 'clientes/rcrGuYv1tnkdGUVWgUjgvrcZhpcpYMqqXrhKOyYV.jpg', '2025-06-08 14:19:30', '2025-07-20 14:09:30'),
(106, 'Yeray', 'Padial', '644881847', '49113947t', 'yeraydanko@gmail.com', '2025-06-11', '2025-07-11', 3, 'clientes/QG2QGpFD5oEF93X4JpV6KarA6WbN0InjtfeY0uiS.jpg', '2025-06-11 00:02:16', '2025-07-20 14:05:21'),
(107, 'Prueba', 'de app', '12345678', '12345678r', 'rlyerayinsider@gmail.com', '2025-07-22', '2025-08-22', 7, 'clientes/su3wFL5O6xE7HIWdW5994YCLL0f56gzkttPwEm7R.jpg', '2025-07-22 00:05:26', '2025-07-22 00:05:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `tipo`, `precio`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Vip junior', 20.00, 'menores de 18 vip', '2025-03-23 18:22:35', '2025-04-05 15:07:07'),
(2, 'Vip adultos', 25.00, 'Mayores de 18 vip', '2025-03-23 18:40:53', '2025-04-05 15:06:54'),
(3, 'Sin cuota', 0.00, 'Cuota caducada o pendiente de pago', '2025-03-23 19:57:03', '2025-03-23 19:57:59'),
(7, 'Junior', 15.00, 'Para menores de edad', '2025-04-05 15:07:33', '2025-06-08 13:37:37'),
(8, 'Adulto', 18.00, 'Mayores de edad', '2025-04-05 15:08:12', '2025-06-08 13:39:39');

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
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_categoria` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `existencias` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inventarios`
--

INSERT INTO `inventarios` (`id`, `tipo_categoria`, `nombre`, `precio`, `existencias`, `descripcion`, `foto`, `created_at`, `updated_at`) VALUES
(14, 9, 'Botella  térmica', 14.99, 8, 'Botella para entrenar en invierno', 'Articulos/2AEsF6QaKSwFhP6R39IHXGn45vnBqO1VM2BpzvZQ.jpg', '2025-06-08 14:37:28', '2025-07-20 14:32:29'),
(15, 9, 'Botella plástico', 5.00, 100, 'Botella para entrenamiento diario', 'Articulos/w7CmiYbeyG6HMukvMq3240KV32S5ZOQT9xYMqprl.jpg', '2025-06-08 14:39:38', '2025-07-20 14:32:13'),
(16, 7, 'Pesas decoración', 25.00, 1000, 'Pesas patrocinadas Finalgym que sirven de decoracion', 'Articulos/BlTx25fBtCd2hyl6ShrLmMHV6xJ8gkeyF3muhKoH.jpg', '2025-06-08 14:40:58', '2025-07-20 14:28:50'),
(17, 7, 'Mancuernas biceps', 48.87, 1000, 'Pesas patrocinadas Finalgym que sirven para biceps', 'Articulos/YeYf41UyIXLhX5OpsBhshfxi9DodPAySDnA4sMb8.jpg', '2025-06-08 14:42:06', '2025-07-20 14:29:18'),
(18, 7, 'Mancuerna sentadilla', 8.99, 1000, 'Pesas patrocinadas Finalgym que sirven para piernas', 'Articulos/4MLZ8eyqVMdAUBjlEhPVB1DebI8inIicYtDqoOVw.jpg', '2025-06-08 14:42:57', '2025-07-20 14:26:21'),
(19, 8, 'Cinta deportiva', 1.00, 1000, 'Cinta personalizada para el pelo', 'Articulos/ArAY1c4uiQSv4h0w1pxP5IDDrer8SyxE7sVKmxb1.jpg', '2025-06-08 14:43:44', '2025-07-20 14:25:59'),
(20, 8, 'Guantes deportivos', 0.99, 1000, 'Guantes paraentrenar y mejorar el agarre', 'Articulos/FsI7BK7KlxxKvVarK7jdbWoAwEWqqndCulwSO5H5.jpg', '2025-06-08 14:45:34', '2025-07-20 14:25:05'),
(21, 8, 'Straps', 3.00, 1000, 'straps para mejorar agarre en el gym', 'Articulos/xbr0usLM0dMheuUxddZkhL9oHymqcKBDIWzAFB8T.jpg', '2025-06-08 14:48:14', '2025-07-20 14:24:28'),
(22, 8, 'Esterilla', 70.00, 1000, 'Alfombra para hacer abdominales', 'Articulos/7eOf9U7DZUak8RvLSker3o5xfi77zk6T2aXwrbUb.jpg', '2025-06-08 14:49:03', '2025-07-20 14:20:07'),
(23, 8, 'Comba', 5.00, 1000, 'Comba para entrenar', 'Articulos/9jXfbPeB5dx2qZXum3J9CJXSALFhOIlhCw5aPyYb.jpg', '2025-06-08 14:50:04', '2025-07-20 14:19:47'),
(24, 8, 'Balon', 30.00, 0, 'Balon para embarazadas', 'Articulos/TbCMH9mENclTU5CF9PnxYNg2JDv6Cn1PnshBQMVe.jpg', '2025-06-08 14:51:51', '2025-07-20 14:19:34'),
(25, 7, 'Rueda abdominal', 6.50, 2, 'Rueda para mejorar el abdomen', 'Articulos/UgWK3ggMWDFQkOAAURAKukcWGUJxOxSFW8hBpC5E.jpg', '2025-06-08 14:54:06', '2025-07-20 14:19:06'),
(26, 8, 'Caja Jump', 150.00, 2, 'Cajas para entrenar pierna', 'Articulos/BJ3eltBwiUwxm7njwYF6yiD6S5AEsrCfkZ3aeY1a.jpg', '2025-06-08 14:55:27', '2025-07-20 14:18:25'),
(27, 8, 'Bascula', 1002.43, 4, 'Bascula de oro', 'Articulos/wsDKq4R9jEqewaf99Vbxc2DIzLFycmA09f8vRP9r.jpg', '2025-06-08 14:56:19', '2025-07-20 14:18:05');

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
-- Estructura de tabla para la tabla `machines`
--

CREATE TABLE `machines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `machines`
--

INSERT INTO `machines` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'banco metal', '21x20', '2025-03-16 13:39:54', '2025-03-16 13:39:54'),
(2, 'multipower', 'metal grandee', '2025-03-16 13:41:37', '2025-03-22 20:19:12'),
(4, 'a', 'a', '2025-03-29 22:05:14', '2025-03-29 22:05:14');

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
(4, '2020_10_04_115514_create_moonshine_roles_table', 2),
(5, '2020_10_05_173148_create_moonshine_tables', 2),
(6, '2025_03_16_105555_create_notifications_table', 2),
(7, '2025_03_16_122920_create_machines_table', 3),
(8, '2025_03_18_170747_create_cuotas_table', 4),
(9, '2025_03_18_171503_create_clientes_table', 5),
(10, '2025_03_23_171503_create_clientes_table', 6),
(11, '2025_03_23_170747_create_cuotas_table', 7),
(12, '2025_03_23_171504_create_clientes_table', 8),
(13, '2025_03_23_171747_create_cuotas_table', 9),
(14, '2025_03_23_141504_create_clientes_table', 10),
(15, '2025_03_25_221507_add_foto_to_clientes_table', 11),
(16, '2025_03_29_094703_create_categorias_table', 12),
(17, '2025_03_29_100144_create_inventarios_table', 13),
(19, '2025_05_02_124549_add_admin_to_moonshine_users_table', 14),
(20, '2025_05_16_131255_create_orders_table', 15),
(21, '2025_05_16_132344_create_order_items_table', 16),
(23, '2025_05_16_201810_alter_orders_nullable_shipping_fields', 17),
(24, '2025_05_23_105826_add_email_to_clientes_table', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moonshine_users`
--

CREATE TABLE `moonshine_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `moonshine_user_role_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `moonshine_users`
--

INSERT INTO `moonshine_users` (`id`, `moonshine_user_role_id`, `email`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin@gmail.com', '$2y$12$ClIhdAvBCfsXoMBA0lB2qOWuwJaf9QWfRXWikW.oFXmr7Gd8nrrPO', 'admin', 'moonshine_users/ZLMD7eR10boW7tB8Puv715ddMUJwppEfQkEpKNEI.jpg', '5Y0imbk94YDxXExoTtKlJLPL7yJcGG38vfFoAHwVBMDXMsBeL2cvEie5OUx2', '2025-03-15 00:00:00', '2025-07-20 13:58:46'),
(2, 6, 'yera@gmail.com', '$2y$12$JwAeqQ.4bRp2.6v6pYtTZOwsIogjp83apj5yaYjZFqDZlAQX3qvkm', 'yera', 'moonshine_users/NwbPHvLHk4vbNYo4vznpA8vCI2qSVtQJ08MxW1rU.png', NULL, '2025-03-15 00:00:00', '2025-06-11 08:06:36'),
(54, 4, 'pepe@gmail.com', '$2y$12$oMhTKr11.cQK6kKZFvPcPeUK6Y2jZlBq3DpHZEhSN7rpvgXf4nlTq', 'pepe', 'moonshine_users/0mwp4YHfpxpL6oojUaxAeysbLgye1fligebhMikm.jpg', NULL, '2025-06-08 00:00:00', '2025-07-20 14:07:25'),
(55, 7, 'prueba@gmail.com', '$2y$12$B97FaF4G0Mzl/4nvB8FGWOFTmKQg/Z92ZZDBoNQzAha.1PE.Kc0cO', 'Admin prueba', 'moonshine_users/B6DynGlpMelX1nbHZLbVIsh4lG7eRg4XZ86Bx3sL.jpg', NULL, '2025-07-22 00:00:00', '2025-07-22 00:03:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moonshine_user_roles`
--

CREATE TABLE `moonshine_user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `moonshine_user_roles`
--

INSERT INTO `moonshine_user_roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2025-03-16 09:56:42', '2025-03-16 09:56:42'),
(4, 'Admin H01', '2025-06-08 11:54:11', '2025-06-08 11:54:11'),
(6, 'Admin S01', '2025-06-08 11:57:00', '2025-06-08 11:57:00'),
(7, 'Admin de prueba', '2025-07-22 00:02:17', '2025-07-22 00:02:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('01fcfcc8-8bdb-4e58-940f-63bfe5686bcd', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-a29ccf7a-3d9b-4c67-b8cc-e047bd7eb07a.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-29 10:17:09', '2025-03-29 10:16:59', '2025-03-29 10:17:09'),
('0608c7d1-02d2-4e46-bd93-a8d3be880841', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-7e32237d-00f1-4973-8095-475d4a8f5192.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-29 10:17:09', '2025-03-29 10:16:48', '2025-03-29 10:17:09'),
('0b7c0e1a-9f50-4f81-acd9-9d7236d8eed5', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-103a7372-10c9-4ad4-af52-27120231c05f.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-27 20:45:31', '2025-03-26 20:48:54', '2025-03-27 20:45:31'),
('0d98fdbc-c725-498e-8a9c-651659588be9', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-29240036-c040-4383-ae9e-c6c4db90f3c3.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-06-02 12:03:40', '2025-06-02 12:03:40'),
('12897f86-e881-4efd-b6aa-d2d6af300a3e', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-bca99788-ffd6-4818-9754-94564e505bd6.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-27 20:45:11', '2025-03-27 20:45:11'),
('16b883a0-ca4e-4662-8d93-5b388e44a769', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-103a7372-10c9-4ad4-af52-27120231c05f.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-26 20:48:54', '2025-03-26 20:48:54'),
('267ced81-c5b2-402b-b8f6-a75e5cf217da', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-1ee7868c-b2b0-41dd-8f70-d124498b1d06.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-26 20:10:41', '2025-03-26 20:00:09', '2025-03-26 20:10:41'),
('26cacc19-63c7-45f0-b8ee-adab29300c3d', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"https:\\/\\/ieslamarisma.net\\/proyectos\\/2025\\/yeraipadial\\/gymfinal\\/storage\\/clientes-resource-ea570294-4f94-45f5-887f-380b702ac7ab.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-06-08 13:53:44', '2025-06-08 13:41:28', '2025-06-08 13:53:44'),
('2c78007b-6431-41f8-951f-f5c5ec7cf231', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-38ad3d6f-8f48-4798-86bb-b968f04ea668.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-29 10:15:44', '2025-03-29 10:15:44'),
('313be71a-1870-4ea2-8a11-0d2a0db19c8d', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-4751197f-7cb7-4ad3-9f9e-4f4da1fc943b.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-29 10:18:05', '2025-03-29 10:18:05'),
('364109ec-78b8-48db-99c5-76752506bda0', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-1ee7868c-b2b0-41dd-8f70-d124498b1d06.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-26 20:00:09', '2025-03-26 20:00:09'),
('3b69b419-d98e-4ff9-9a74-ef4fc4aa0bc0', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-a4bb7ea0-fbe4-4281-8f38-12b79d4df7cc.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-27 20:45:34', '2025-03-27 19:31:08', '2025-03-27 20:45:34'),
('54c3dbb1-58e5-43eb-bc1e-c6f104639f80', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-29240036-c040-4383-ae9e-c6c4db90f3c3.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-06-02 12:04:35', '2025-06-02 12:03:40', '2025-06-02 12:04:35'),
('5574c55c-ed03-4301-877b-58b7671f0a1d', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-885d40cf-a71b-4844-9fe4-86578a58c617.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-05-02 17:40:32', '2025-04-09 15:23:34', '2025-05-02 17:40:32'),
('59487de3-beeb-4532-aa2b-7b7e4ff183b0', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-9a68d1fb-6961-40e7-9b9c-30b0f9ef2c1a.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-26 20:39:52', '2025-03-26 20:39:52'),
('5cd69eee-579f-4c40-900b-ba243e33bdf0', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 4, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-e4844a7f-3742-490f-a15d-d84988cc6957.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-06-02 12:05:01', '2025-06-02 12:05:01'),
('5e75b673-4105-4be7-b95b-cee3a45dc024', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-7f8570c6-2286-475c-afff-ff2c9afff328.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-29 09:58:20', '2025-03-29 09:58:20'),
('63d7e0b5-0fc6-445f-b204-e79bf3ca4acc', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-88bd848c-021e-4f54-a1a0-5802701cc278.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-04-04 05:46:23', '2025-04-04 05:46:23'),
('6eefcc07-1b22-4463-ad4d-783bfcb9b64e', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-885d40cf-a71b-4844-9fe4-86578a58c617.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-04-09 15:23:34', '2025-04-09 15:23:34'),
('70c01e04-1e15-4a12-99c5-0207c9b0c7a0', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-a29ccf7a-3d9b-4c67-b8cc-e047bd7eb07a.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-29 10:16:59', '2025-03-29 10:16:59'),
('7662d61d-200c-401a-bb1c-4a0c48512929', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 54, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"https:\\/\\/ieslamarisma.net\\/proyectos\\/2025\\/yeraipadial\\/gymfinal\\/storage\\/clientes-resource-ea570294-4f94-45f5-887f-380b702ac7ab.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-06-08 13:41:28', '2025-06-08 13:41:28'),
('83f48334-ce89-41d1-bda1-066f30acccf4', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 53, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-e4844a7f-3742-490f-a15d-d84988cc6957.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-06-02 12:05:01', '2025-06-02 12:05:01'),
('8d67f9cb-9c09-4117-a896-7833f2dccd9a', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-38ad3d6f-8f48-4798-86bb-b968f04ea668.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-29 10:17:09', '2025-03-29 10:15:44', '2025-03-29 10:17:09'),
('9081ffd0-a69d-4873-b68e-2e4c905851a9', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 4, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-885d40cf-a71b-4844-9fe4-86578a58c617.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-04-09 15:23:34', '2025-04-09 15:23:34'),
('90e431c0-76fb-4ea7-aa83-1070e98d0666', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 53, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-29240036-c040-4383-ae9e-c6c4db90f3c3.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-06-02 12:03:40', '2025-06-02 12:03:40'),
('b122f9b4-afea-4ea1-9c72-1817e15b4dfb', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-7f8570c6-2286-475c-afff-ff2c9afff328.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-29 10:15:43', '2025-03-29 09:58:20', '2025-03-29 10:15:43'),
('b5d67eb5-0c12-4159-9801-000dc495d0c5', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 4, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-88bd848c-021e-4f54-a1a0-5802701cc278.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-04-04 05:46:23', '2025-04-04 05:46:23'),
('b93008c6-be7b-4a32-b5b3-b587fe197e6e', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-4751197f-7cb7-4ad3-9f9e-4f4da1fc943b.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-29 11:16:01', '2025-03-29 10:18:05', '2025-03-29 11:16:01'),
('bf413150-aa1b-4f2c-ae2e-329573394654', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-88bd848c-021e-4f54-a1a0-5802701cc278.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-04-04 05:51:21', '2025-04-04 05:46:23', '2025-04-04 05:51:21'),
('cb3d5dbb-853b-4d50-8068-4ed3769365f4', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 4, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-29240036-c040-4383-ae9e-c6c4db90f3c3.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-06-02 12:03:40', '2025-06-02 12:03:40'),
('cdf05bb6-8a2b-44b2-aaca-63f588a4b24f', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-bca99788-ffd6-4818-9754-94564e505bd6.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-27 20:45:38', '2025-03-27 20:45:11', '2025-03-27 20:45:38'),
('d0e2a294-1a39-4f08-9be9-7970882aa81a', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/inventario-resource-7e32237d-00f1-4973-8095-475d4a8f5192.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-29 10:16:48', '2025-03-29 10:16:48'),
('d9502a86-0ca1-4cdd-9fcd-ad37392be402', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-26c2548c-3952-4d83-bf1b-1c234f4e42a6.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-27 22:05:34', '2025-03-27 22:03:18', '2025-03-27 22:05:34'),
('da420df1-0f48-4715-a0ec-3436ffb87c3e', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-a4bb7ea0-fbe4-4281-8f38-12b79d4df7cc.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-27 19:31:08', '2025-03-27 19:31:08'),
('da95a3e2-e0d9-43f3-93f3-21adef561d37', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-e4844a7f-3742-490f-a15d-d84988cc6957.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-06-06 13:05:10', '2025-06-02 12:05:01', '2025-06-06 13:05:10'),
('e13dbcc4-140f-41b0-90ec-e4340c3ef855', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-26c2548c-3952-4d83-bf1b-1c234f4e42a6.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-03-27 22:03:18', '2025-03-27 22:03:18'),
('e1579ddf-df9a-4e04-ad63-850881f9a5b4', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-e4844a7f-3742-490f-a15d-d84988cc6957.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-06-02 12:05:01', '2025-06-02 12:05:01'),
('ea4ea4ad-1f91-44ff-af84-5f46ad204db4', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 2, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"https:\\/\\/ieslamarisma.net\\/proyectos\\/2025\\/yeraipadial\\/gymfinal\\/storage\\/clientes-resource-ea570294-4f94-45f5-887f-380b702ac7ab.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', NULL, '2025-06-08 13:41:28', '2025-06-08 13:41:28'),
('f2217455-9e97-464c-95da-c899847feab1', 'MoonShine\\Laravel\\Notifications\\DatabaseNotification', 'MoonShine\\Laravel\\Models\\MoonshineUser', 1, '{\"message\":\"Archivo exportado\",\"button\":{\"label\":\"Descargar\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/clientes-resource-9a68d1fb-6961-40e7-9b9c-30b0f9ef2c1a.xlsx\",\"attributes\":[]},\"color\":null,\"icon\":null}', '2025-03-26 20:40:05', '2025-03-26 20:39:52', '2025-03-26 20:40:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `street_number` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `ordered_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `status` enum('pendiente','procesando','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `shipping_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `reference`, `name`, `email`, `dni`, `phone`, `country`, `province`, `municipality`, `postal_code`, `street`, `street_number`, `total_price`, `ordered_at`, `shipped_at`, `status`, `shipping_method`, `created_at`, `updated_at`) VALUES
(1, '54353535', 'yera', 'yeraydanko@gmail.com', '49113947', '644881848', 'España', 'Jaén', 'huelva', '21005', 'cale el rocio', '9', 78.00, '2025-05-14 22:00:00', NULL, 'entregado', 'recogida en tienda', '2025-05-16 16:37:12', '2025-06-11 00:03:15'),
(2, '43543535', 'seba', 'yeraydanko@gmail.com', '34244342e', '644881848', NULL, NULL, NULL, NULL, NULL, NULL, 23.00, '2025-04-08 22:00:00', NULL, 'entregado', 'Recogida en tienda', '2025-05-16 18:19:13', '2025-05-21 07:15:09'),
(3, '7e2243ba-6d84-49fe-a1a2-02d41f86b869', 'pepe', 'yeraydanko@gmail.com', '45353534r', '453535355', NULL, NULL, NULL, NULL, NULL, NULL, 234.00, '2025-05-20 06:55:56', NULL, 'procesando', 'recogida', '2025-05-20 06:55:56', '2025-05-21 19:18:51'),
(4, '7b791871-6528-4bdc-9f71-dbb07e6d9fdd', 'yera', 'yeraydanko@gmail.com', '49113947t', '644881847', 'españa', 'huelva', 'huelva', '21610', 'calle huerta', '9', 825.00, '2025-05-20 07:05:33', NULL, 'procesando', 'envio', '2025-05-20 07:05:33', '2025-05-21 18:13:08'),
(5, 'd724cc22-daf4-4c7b-bee1-dabbba6cda1c', 'lola', 'yeraydanko@gmail.com', '35435355t', '453534555', NULL, NULL, NULL, NULL, NULL, NULL, 234.00, '2025-05-20 07:40:24', NULL, 'pendiente', 'recogida', '2025-05-20 07:40:24', '2025-05-20 07:40:24'),
(6, 'e956419b-d8d9-48fb-ad44-882d5c41b7c7', 'pepe', 'yeraydanko@gmail.com', '32332323q', '231313323', NULL, NULL, NULL, NULL, NULL, NULL, 234.00, '2025-05-20 09:43:51', NULL, 'procesando', 'recogida', '2025-05-20 09:43:51', '2025-05-20 18:46:15'),
(7, '33a891fc-aef8-41ef-bbd6-70de3afce755', 'Yeray', 'yeraydanko@gmail.com', '49113947T', '644881847', NULL, NULL, NULL, NULL, NULL, NULL, 7.00, '2025-05-20 18:59:22', NULL, 'procesando', 'recogida', '2025-05-20 18:59:22', '2025-05-20 19:00:21'),
(8, '7db70a05-bc3d-4f75-a576-8d41581267bd', 'susana', 'yerypad53@gmail.com', '23131312r', '123123132', NULL, NULL, NULL, NULL, NULL, NULL, 7.00, '2025-05-20 19:30:51', NULL, 'enviado', 'recogida', '2025-05-20 19:30:51', '2025-06-08 11:12:13'),
(9, 'ee35bf14-6786-42e9-9638-bf445b816e1d', 'pepe', 'paadyery@gmail.com', '32424234r', '423424234', NULL, NULL, NULL, NULL, NULL, NULL, 377.00, '2025-05-20 20:00:16', NULL, 'entregado', 'recogida', '2025-05-20 20:00:16', '2025-06-08 11:06:53'),
(11, 'd9adee2d-04c1-4328-8053-3f4d66902ed3', 'padi', 'yerypad53@gmail.com', '23424432t', '432424244', NULL, NULL, NULL, NULL, NULL, NULL, 27.00, '2025-05-20 20:13:26', NULL, 'pendiente', 'recogida', '2025-05-20 20:13:26', '2025-05-21 06:50:41'),
(12, 'b84ef739-bc3e-4f57-a926-58fe62903095', 'yera', 'yerypad53@gmail.com', '32424234t', '232432433', NULL, NULL, NULL, NULL, NULL, NULL, 234.00, '2025-05-20 20:16:23', NULL, 'entregado', 'recogida', '2025-05-20 20:16:23', '2025-05-21 07:01:02'),
(13, 'feab845b-04d7-4374-8290-3ff75bfdbc1f', 'yera', 'yeraydanko@gmail.com', '13213131r', '121132132', NULL, NULL, NULL, NULL, NULL, NULL, 10.00, '2025-05-21 09:38:57', NULL, 'pendiente', 'recogida', '2025-05-21 09:38:57', '2025-06-07 20:40:50'),
(14, 'bdd5385e-28ab-421e-a459-b7b7701c7cb9', 'maria', 'rlyerayrocket@gmail.com', '23233133t', '676567522', NULL, NULL, NULL, NULL, NULL, NULL, 5.00, '2025-05-21 09:45:33', NULL, 'pendiente', 'recogida', '2025-05-21 09:45:33', '2025-06-07 16:15:19'),
(15, 'f2599ee3-1928-468b-9dc5-3afc027cb28a', 'lurdes', 'rlyerayrocket@gmail.com', '23131313t', '123131332', NULL, NULL, NULL, NULL, NULL, NULL, 27.00, '2025-05-21 09:57:31', NULL, 'pendiente', 'recogida', '2025-05-21 09:57:31', '2025-06-07 16:13:09'),
(16, 'f21e783f-358c-4f67-91b4-cc1103c5387e', 'julio', 'yeraydanko@gmail.com', '34524353t', '345535344', NULL, NULL, NULL, NULL, NULL, NULL, 30.00, '2025-05-21 18:41:44', NULL, 'pendiente', 'recogida', '2025-05-21 18:41:44', '2025-05-21 18:45:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(3, 1, NULL, 'Santiago libro', 7.00, 2, 14.00, '2025-05-16 19:34:38', '2025-05-16 19:34:38'),
(4, 3, NULL, 'rewr', 234.00, 1, 234.00, '2025-05-20 06:55:56', '2025-05-20 06:55:56'),
(5, 4, NULL, 'rewr', 234.00, 3, 702.00, '2025-05-20 07:05:33', '2025-05-20 07:05:33'),
(6, 4, NULL, 'IIIIE', 123.00, 1, 123.00, '2025-05-20 07:05:33', '2025-05-20 07:05:33'),
(7, 5, NULL, 'rewr', 234.00, 1, 234.00, '2025-05-20 07:40:24', '2025-05-20 07:40:24'),
(8, 6, NULL, 'rewr', 234.00, 1, 234.00, '2025-05-20 09:43:51', '2025-05-20 09:43:51'),
(9, 7, NULL, 'Santiago libro', 7.00, 1, 7.00, '2025-05-20 18:59:22', '2025-05-20 18:59:22'),
(10, 8, NULL, 'Santiago libro', 7.00, 1, 7.00, '2025-05-20 19:30:51', '2025-05-20 19:30:51'),
(11, 9, NULL, 'Gorra', 10.00, 2, 20.00, '2025-05-20 20:00:16', '2025-05-20 20:00:16'),
(12, 9, NULL, 'rewr', 234.00, 1, 234.00, '2025-05-20 20:00:16', '2025-05-20 20:00:16'),
(13, 9, NULL, 'IIIIE', 123.00, 1, 123.00, '2025-05-20 20:00:16', '2025-05-20 20:00:16'),
(16, 11, NULL, 'Gorra', 10.00, 2, 20.00, '2025-05-20 20:13:26', '2025-05-20 20:13:26'),
(17, 11, NULL, 'Santiago libro', 7.00, 1, 7.00, '2025-05-20 20:13:26', '2025-05-20 20:13:26'),
(18, 12, NULL, 'rewr', 234.00, 1, 234.00, '2025-05-20 20:16:23', '2025-05-20 20:16:23'),
(19, 13, NULL, 'Gorra', 10.00, 1, 10.00, '2025-05-21 09:38:57', '2025-05-21 09:38:57'),
(20, 14, NULL, 'maria', 1.00, 5, 5.00, '2025-05-21 09:45:33', '2025-05-21 09:45:33'),
(21, 15, NULL, 'Gorra', 10.00, 2, 20.00, '2025-05-21 09:57:31', '2025-05-21 09:57:31'),
(22, 15, NULL, 'Santiago libro', 7.00, 1, 7.00, '2025-05-21 09:57:31', '2025-05-21 09:57:31'),
(23, 16, NULL, 'Gorra', 10.00, 3, 30.00, '2025-05-21 18:41:44', '2025-05-21 18:41:44');

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
('hY6hmCecw9DEF6HbdbT8cufbSmST5mvB3vLglJ3X', 55, '193.31.49.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNDRlaHBCOTE2TDFNZ01abjVFQnc3M1VjY0EyRXR1NzJsZEVnUzBLViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODI6Imh0dHBzOi8vcGFkaXllcmEuY29tL2JhY2tlbmQvcHVibGljL2FkbWluL3Jlc291cmNlL2NsaWVudGVzLXJlc291cmNlL2Zvcm0tcGFnZS8xMDciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU2OiJsb2dpbl9tb29uc2hpbmVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1NTtzOjIzOiJwYXNzd29yZF9oYXNoX21vb25zaGluZSI7czo2MDoiJDJ5JDEyJEI5N0ZhRjRHME16bC80bnZCOEZHV09GVG1LUWcvWjkyWlpEQm9OUXpBaGEuMVBFLktjMGNPIjt9', 1753142727);

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
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_dni_unique` (`dni`),
  ADD KEY `clientes_tipo_cuota_foreign` (`tipo_cuota`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventarios_tipo_categoria_foreign` (`tipo_categoria`);

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
-- Indices de la tabla `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `moonshine_users`
--
ALTER TABLE `moonshine_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `moonshine_users_email_unique` (`email`),
  ADD KEY `moonshine_users_moonshine_user_role_id_foreign` (`moonshine_user_role_id`);

--
-- Indices de la tabla `moonshine_user_roles`
--
ALTER TABLE `moonshine_user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_reference_unique` (`reference`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `machines`
--
ALTER TABLE `machines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `moonshine_users`
--
ALTER TABLE `moonshine_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `moonshine_user_roles`
--
ALTER TABLE `moonshine_user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_tipo_cuota_foreign` FOREIGN KEY (`tipo_cuota`) REFERENCES `cuotas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `inventarios_tipo_categoria_foreign` FOREIGN KEY (`tipo_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `moonshine_users`
--
ALTER TABLE `moonshine_users`
  ADD CONSTRAINT `moonshine_users_moonshine_user_role_id_foreign` FOREIGN KEY (`moonshine_user_role_id`) REFERENCES `moonshine_user_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `inventarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
