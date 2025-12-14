-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2025 a las 06:24:53
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
-- Base de datos: `utp_proyecto_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `relase_at_library` timestamp NOT NULL DEFAULT current_timestamp(),
  `release_date` timestamp NULL DEFAULT NULL,
  `aviable` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `relase_at_library`, `release_date`, `aviable`) VALUES
(1, 'El Libro Verde', 'Juan Verdades Listillo', 'Comedia', '2025-12-11 22:46:54', '2004-10-01 22:47:47', 0),
(2, 'La metamirfosis', 'Franz Kafka', 'Relato', '2025-12-13 23:12:14', '0000-00-00 00:00:00', 1),
(3, 'El plomero y la estrella', 'Rosa Linades', 'Ficción', '2025-12-14 03:28:17', '2006-11-08 05:00:00', 1),
(4, 'La Luz de la luna', 'Ana Sofía de Versalles', 'Novela', '2025-12-14 04:34:34', '2023-02-15 05:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fines`
--

CREATE TABLE `fines` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `fine_amount` decimal(8,2) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `imposed_date` date DEFAULT curdate(),
  `due_date` date DEFAULT NULL,
  `is_paid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `lend_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `book_id`, `lend_date`, `due_date`, `return_date`) VALUES
(1, 3, 1, '2025-12-13', '2025-12-20', NULL),
(2, 3, 4, '2025-12-13', '2025-12-20', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(255) DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `applied_at`) VALUES
(1, '001_create_tasks_table.sql', '2025-10-28 00:16:31'),
(2, '002_add_description_to_tasks.sql', '2025-10-28 00:16:31'),
(3, '003_create_users_table.sql', '2025-10-30 02:00:16'),
(4, '004_create_projects_table.sql', '2025-10-30 02:02:13'),
(5, '101_create_books_table.sql', '2025-10-30 02:06:21'),
(6, '102_create_ticket_table.sql', '2025-10-30 02:07:52'),
(7, '103_create_reserve_table.sql', '2025-10-30 02:14:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `reservation_date` datetime NOT NULL,
  `status` enum('Pendiente','Aprovado','Cancelado') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `book_id`, `reservation_date`, `status`) VALUES
(10, 3, 1, '2025-12-13 23:08:44', 'Aprovado'),
(11, 6, 1, '2025-12-13 23:29:07', ''),
(12, 3, 4, '2025-12-13 23:42:45', 'Aprovado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `is_completed`, `created_at`) VALUES
(3, 'Segunda Tarea Parte 1', NULL, 0, '2025-10-28 00:54:17'),
(4, 'Segunda Tarea Parte 2 ', 'Continuando', 0, '2025-10-28 00:59:54'),
(5, 'Tarea de Jardín', 'Cuida el jardín', 0, '2025-10-28 01:12:48'),
(6, 'Libros Altos', 'Probando los Libros', 0, '2025-11-20 01:33:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `book_id` int(100) NOT NULL,
  `time_since_borrow` timestamp NOT NULL DEFAULT current_timestamp(),
  `borrow_until` date DEFAULT NULL,
  `recharge` tinyint(1) DEFAULT 0,
  `price_recharge` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `password`, `email`, `first_name`, `last_name`, `role`, `created_at`, `update_at`) VALUES
(1, 'Robert98*89', 'robert9889@gmail.com', 'Roberto', 'Salinas', 1, '2025-12-10 20:12:51', NULL),
(3, '$2y$10$9mHVoODGOdCyjHKBZo7MwOloJmpfGm5xIEk1Ee4sLaQ75LX7G/kn2', 'willow6@gmail.com', 'Willow', 'Fernandez', 1, '2025-12-13 00:37:09', NULL),
(4, '$2y$10$grtWFp7uzCvIcNouoFMAouZBgpjvLmEYsftkDmhLYyKjDd/wgmgf2', 'dahlia5@gmail.com', 'Dahlia', 'de García', 2, '2025-12-13 04:02:26', NULL),
(6, '$2y$10$PWykngtiB.JBLzAc5Wa27OxRRzu7wn/.JiI9TOfVe2enn9BmHZlJe', 'edgar2550@gmail.com', 'Edgar', 'Gomez', 1, '2025-12-14 04:26:32', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fine_user` (`user_id`),
  ADD KEY `fk_fine_loan` (`loan_id`);

--
-- Indices de la tabla `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_loan_user` (`user_id`),
  ADD KEY `fk_loan_book` (`book_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_res_user` (`user_id`),
  ADD KEY `fk_res_book` (`book_id`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `fines`
--
ALTER TABLE `fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fines`
--
ALTER TABLE `fines`
  ADD CONSTRAINT `fk_fine_loan` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fine_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `fk_loan_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_loan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_res_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_res_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
