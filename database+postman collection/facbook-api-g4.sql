-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2024 at 07:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facbook-api-g4`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `text`, `post_id`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Facilis aut eius consectetur eos nesciunt omnis possimus.', 9, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(3, 'Ut eligendi et non voluptatem perspiciatis praesentium sit.', 8, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 'Id quia et non dolor cumque in.', 2, 1, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 'Sed non ut ex veritatis dolor veritatis.', 3, 6, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 'Voluptatem impedit non culpa officiis laborum nulla velit.', 4, 8, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(7, 'Ut eum enim suscipit qui ea.', 8, 5, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(8, 'Et sit eius alias eum non neque.', 7, 5, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(9, 'Architecto qui voluptatibus dolores qui.', 6, 9, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(10, 'Sint reiciendis aut repellat vel ipsam quod omnis.', 2, 1, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(11, 'well, ain\'t that amazing', 2, 1, '2024-06-14 02:16:20', '2024-06-14 02:16:20'),
(12, 'well, ain\'t that amazing', 2, 1, '2024-06-14 02:35:22', '2024-06-14 02:35:22'),
(13, 'Hey yo EM is back!!!', 1, 2, '2024-06-14 20:46:18', '2024-06-14 20:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `friend_lists`
--

CREATE TABLE `friend_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_lists`
--

INSERT INTO `friend_lists` (`id`, `user_id`, `friend_id`, `created_at`, `updated_at`) VALUES
(1, 6, 7, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(2, 2, 10, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(3, 7, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 9, 2, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 10, 8, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 5, 6, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(7, 6, 7, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(8, 7, 3, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(9, 3, 3, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(10, 2, 6, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(11, 1, 3, '2024-06-13 02:22:49', '2024-06-13 02:22:49'),
(12, 1, 6, '2024-06-13 17:35:58', '2024-06-13 17:35:58'),
(13, 2, 1, '2024-06-14 20:53:01', '2024-06-14 20:53:01');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_from` bigint(20) UNSIGNED NOT NULL,
  `request_to` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','declined') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `request_from`, `request_to`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 5, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(3, 10, 4, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 2, 10, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 1, 7, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 2, 8, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(7, 1, 1, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(8, 7, 6, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(9, 8, 6, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(10, 5, 9, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(11, 7, 4, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(12, 5, 5, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(13, 4, 10, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(14, 6, 5, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(15, 5, 7, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(16, 8, 7, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(18, 2, 1, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(19, 5, 2, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(20, 5, 5, 'pending', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(21, 1, 5, 'pending', '2024-06-13 17:51:05', '2024-06-13 17:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `post_id`, `image_name`, `created_at`, `updated_at`) VALUES
(1, 8, 'Repudiandae perferendis repudiandae amet est soluta facilis.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(2, 4, 'Dicta animi eum cumque eveniet facere aperiam nulla quia.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(3, 2, 'Libero consectetur minima quis praesentium eos ut et ea.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 5, 'Dolor sit mollitia sed.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 10, 'Et libero non et fugit.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 6, 'Necessitatibus eligendi voluptatibus et.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(7, 8, 'Corporis quaerat ut dolorum magni earum reiciendis veniam.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(8, 6, 'Consequatur quia blanditiis et rerum velit rerum.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(9, 6, 'Iste blanditiis voluptas illo debitis laborum.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(10, 4, 'Modi sit quae est.', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(11, 11, '997612617.png', '2024-06-13 20:27:33', '2024-06-13 20:27:33'),
(12, 12, '888891618.png', '2024-06-15 22:25:22', '2024-06-15 22:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `react_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`, `react_id`, `created_at`, `updated_at`) VALUES
(1, 7, 10, 1, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(2, 8, 2, 3, '2024-06-13 02:11:50', '2024-06-14 21:03:56'),
(3, 8, 3, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 10, 6, 1, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 1, 7, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 1, 1, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(7, 7, 10, 2, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(8, 1, 5, 3, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(9, 4, 4, 2, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(10, 2, 5, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_10_032501_create_posts_table', 1),
(6, '2024_06_10_032502_create_images_table', 1),
(7, '2024_06_10_032522_create_comments_table', 1),
(8, '2024_06_10_032529_create_reacts_table', 1),
(9, '2024_06_10_032530_create_likes_table', 1),
(10, '2024_06_10_032801_create_replies_table', 1),
(11, '2024_06_13_031024_create_friend_lists_table', 1),
(12, '2024_06_13_040155_create_friend_requests_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'token', '617a714c4c06287c2c16fb77bfe0b68d5fc9e4f4f26762b3719f10111be65307', '[\"*\"]', '2024-06-14 20:59:02', NULL, '2024-06-13 02:19:34', '2024-06-14 20:59:02'),
(2, 'App\\Models\\User', 1, 'token', 'eebb2a8058668abcf148226f6db45aaf0d7da0bf098969ff4337194a2085a8df', '[\"*\"]', NULL, NULL, '2024-06-13 18:50:37', '2024-06-13 18:50:37'),
(3, 'App\\Models\\User', 1, 'token', '9b640f57476c0aa0c11d28cfa18681279f85ac56c8d136fcf0aada57a654768f', '[\"*\"]', NULL, NULL, '2024-06-13 18:56:06', '2024-06-13 18:56:06'),
(4, 'App\\Models\\User', 1, 'token', 'eca43d2e93dde81012e307a82b21e1b0c298563df70c253c9b8cc75fb4dba2f3', '[\"*\"]', NULL, NULL, '2024-06-13 19:13:20', '2024-06-13 19:13:20'),
(5, 'App\\Models\\User', 1, 'token', '4d9507edb3809a8f654aeef3cd8dfd6708936a2bbd5d87d4a1d07530676cf0a8', '[\"*\"]', NULL, NULL, '2024-06-13 19:31:44', '2024-06-13 19:31:44'),
(6, 'App\\Models\\User', 1, 'token', 'c6e3807ea79ab3ec4422bf4f65092de2441b772908fb7f87d66c7f90584767a0', '[\"*\"]', '2024-06-14 01:54:00', NULL, '2024-06-13 19:35:55', '2024-06-14 01:54:00'),
(7, 'App\\Models\\User', 1, 'token', '586380b8691b51eb87601771054e4c797648a4e6a2826230b566e1802238dc13', '[\"*\"]', '2024-06-14 01:54:45', NULL, '2024-06-14 01:50:49', '2024-06-14 01:54:45'),
(8, 'App\\Models\\User', 2, 'token', '1b09aa42e43c408a3869b4701debfc563dbad4cf71e88cb2d433f82d384cf938', '[\"*\"]', '2024-06-14 21:04:05', NULL, '2024-06-14 20:41:48', '2024-06-14 21:04:05'),
(9, 'App\\Models\\User', 1, 'token', '6c03a2f969b32054abf20ee0fa0746af84cfbf6ae0f137cd90cb2f6a940dbf13', '[\"*\"]', '2024-06-15 22:25:22', NULL, '2024-06-15 22:22:17', '2024-06-15 22:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `text`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Saepe esse sed perferendis vero molestias.', 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(2, 'Molestiae ea molestiae corrupti quis occaecati magnam vero a.', 7, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(3, 'Explicabo praesentium optio ex occaecati eum.', 2, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 'Voluptas ut explicabo in dolor.', 10, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 'Quia maiores quam officia saepe rerum quas perspiciatis.', 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 'Sed quia repellat ipsam dolor id aliquam a.', 2, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(7, 'Sint voluptas vitae at placeat aut.', 1, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(8, 'Est et id quidem quis saepe ducimus odit.', 3, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(9, 'Vero nobis dolores nam quo molestiae.', 9, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(10, 'Sed molestiae eos a labore.', 1, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(11, 'Hi', 1, '2024-06-13 20:27:33', '2024-06-13 20:27:33'),
(12, 'Hey', 1, '2024-06-15 22:25:22', '2024-06-15 22:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `reacts`
--

CREATE TABLE `reacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `react_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reacts`
--

INSERT INTO `reacts` (`id`, `react_name`, `created_at`, `updated_at`) VALUES
(1, 'Like', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(2, 'Love', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(3, 'Haha', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 'Wow', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 'Sad', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 'Angry', '2024-06-13 02:11:50', '2024-06-13 02:11:50');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `text`, `comment_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Et architecto voluptas sit atque eum.', 2, 9, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(2, 'Vero quidem suscipit consequatur esse consequuntur.', 10, 10, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(3, 'Nisi assumenda asperiores molestiae nam quas ratione rem culpa.', 6, 5, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 'Inventore accusamus eveniet aut reprehenderit corrupti culpa.', 10, 10, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 'Unde voluptas atque neque qui nostrum veritatis dolores.', 3, 8, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 'Officia voluptatem quis impedit rerum soluta id.', 5, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(7, 'Ab tempore quam corporis deserunt similique maiores nulla.', 2, 3, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(8, 'Id velit accusamus fugiat neque eum sapiente.', 4, 4, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(9, 'Qui in ea nulla nemo.', 10, 9, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(10, 'Quis unde sit eos explicabo doloremque amet.', 2, 2, '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(11, 'Yeah', 12, 1, '2024-06-14 02:35:56', '2024-06-14 02:35:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Yadira Mertz', NULL, 'maymie82@example.com', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', 'V17W0jgP7C', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(2, 'Maritza Mueller', NULL, 'hstamm@example.com', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', 'lm22vNJDjz', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(3, 'Josiah Mante', NULL, 'mhoppe@example.org', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', '9UrJjYmrc5', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(4, 'Charlene O\'Kon', NULL, 'trunolfsdottir@example.org', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', 'RXyK6Wx1CB', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(5, 'Tyrese Wuckert', NULL, 'lemke.veronica@example.net', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', 'XuyDigTVp2', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(6, 'Marie Rodriguez', NULL, 'amina.schultz@example.com', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', '8nVXEZ2mcT', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(7, 'Mr. Silas Funk III', NULL, 'jackson.feest@example.net', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', 'R7wBjWi94P', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(8, 'Katlynn Herzog', NULL, 'zulauf.sydni@example.org', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', 'vwN9qEUURe', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(9, 'Camylle Lakin', NULL, 'lilliana54@example.net', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', 'NZst7BN3Tc', '2024-06-13 02:11:50', '2024-06-13 02:11:50'),
(10, 'Miss Lily Toy II', NULL, 'katlynn40@example.com', '2024-06-13 02:11:50', '$2y$12$17RqUriXJrIvjRUYxC0CdeKvikqk7SBYp0Jkx/CPEWwFe0t1GdW22', 'E19cQcMXWO', '2024-06-13 02:11:50', '2024-06-13 02:11:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `friend_lists`
--
ALTER TABLE `friend_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friend_lists_user_id_foreign` (`user_id`),
  ADD KEY `friend_lists_friend_id_foreign` (`friend_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friend_requests_request_from_foreign` (`request_from`),
  ADD KEY `friend_requests_request_to_foreign` (`request_to`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_post_id_foreign` (`post_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_post_id_foreign` (`post_id`),
  ADD KEY `likes_user_id_foreign` (`user_id`),
  ADD KEY `likes_react_id_foreign` (`react_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `reacts`
--
ALTER TABLE `reacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replies_comment_id_foreign` (`comment_id`),
  ADD KEY `replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend_lists`
--
ALTER TABLE `friend_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reacts`
--
ALTER TABLE `reacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_lists`
--
ALTER TABLE `friend_lists`
  ADD CONSTRAINT `friend_lists_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `friend_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_request_from_foreign` FOREIGN KEY (`request_from`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_request_to_foreign` FOREIGN KEY (`request_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_react_id_foreign` FOREIGN KEY (`react_id`) REFERENCES `reacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
