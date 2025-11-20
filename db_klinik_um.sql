-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2025 at 04:52 PM
-- Server version: 8.4.0
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_klinik_um`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `schedule_id` bigint UNSIGNED NOT NULL,
  `nomor_antrean` int NOT NULL,
  `status` enum('Menunggu','Selesai','Batal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `keluhan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `schedule_id`, `nomor_antrean`, `status`, `keluhan`, `created_at`, `updated_at`) VALUES
(3, 1, 266, 1, 'Selesai', 'Masalah Pencernaan', '2025-11-19 01:02:48', '2025-11-19 01:03:46'),
(4, 2, 266, 2, 'Selesai', 'sakit tenggorokan', '2025-11-19 08:05:21', '2025-11-19 08:59:22'),
(5, 1, 267, 1, 'Selesai', 'demam', '2025-11-19 09:18:25', '2025-11-19 09:19:44'),
(6, 2, 267, 2, 'Selesai', 'batuk', '2025-11-19 09:20:07', '2025-11-19 09:20:24');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `specialties` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `specialties`, `nip`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dokter Umum', '198001012005011001', '2025-11-13 18:43:57', '2025-11-13 18:43:57'),
(2, 4, 'Dokter Umum', '240533600012', '2025-11-13 22:54:49', '2025-11-13 22:54:49'),
(3, 5, 'Dokter Umum', '240533609185', '2025-11-15 20:36:30', '2025-11-15 20:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_certificates`
--

CREATE TABLE `medical_certificates` (
  `id` bigint UNSIGNED NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `tipe_surat` enum('Sehat','Sakit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tinggi_badan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berat_badan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tensi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buta_warna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan_darah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_hari_istirahat` int DEFAULT NULL,
  `mulai_tanggal` date DEFAULT NULL,
  `sampai_tanggal` date DEFAULT NULL,
  `catatan_tambahan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_certificates`
--

INSERT INTO `medical_certificates` (`id`, `appointment_id`, `tipe_surat`, `tinggi_badan`, `berat_badan`, `tensi`, `buta_warna`, `golongan_darah`, `jumlah_hari_istirahat`, `mulai_tanggal`, `sampai_tanggal`, `catatan_tambahan`, `created_at`, `updated_at`) VALUES
(1, 4, 'Sehat', '12', '77', '259', 'Tidak', 'B', NULL, NULL, NULL, 'Aman', '2025-11-19 08:59:41', '2025-11-19 08:59:41'),
(2, 3, 'Sehat', '12', '77', '259', 'Tidak', 'B', NULL, NULL, NULL, NULL, '2025-11-19 09:13:57', '2025-11-19 09:13:57'),
(3, 6, 'Sehat', '12', '77', '259', 'Tidak', 'B', NULL, NULL, NULL, NULL, '2025-11-19 09:21:14', '2025-11-19 09:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_14_010052_create_roles_tables', 1),
(5, '2025_11_14_010138_create_doctors_table', 1),
(6, '2025_11_14_010230_create_patients_table', 1),
(9, '2025_11_14_015957_create_schedules_table', 2),
(10, '2025_11_14_020003_create_appointments_table', 2),
(11, '2025_11_14_041616_add_avatar_to_users_table', 3),
(12, '2025_11_19_142615_create_payments_and_certificates_tables', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nim_nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `nim_nik`, `tgl_lahir`, `alamat`, `jenis_kelamin`, `created_at`, `updated_at`) VALUES
(1, 3, '220533601234', '2003-05-20', 'Jl. Surabaya No. 6, Malang', 'P', '2025-11-13 18:43:57', '2025-11-13 18:43:57'),
(2, 6, '1234534534554', '2025-11-19', 'Jl. Cakrawala No.5, Sumbersari, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145', NULL, '2025-11-19 08:03:36', '2025-11-19 08:03:36');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `biaya_dokter` decimal(10,2) NOT NULL DEFAULT '0.00',
  `biaya_tindakan` decimal(10,2) NOT NULL DEFAULT '0.00',
  `biaya_obat` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_bayar` decimal(10,2) NOT NULL,
  `status` enum('Belum Lunas','Lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Lunas',
  `metode_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `appointment_id`, `biaya_dokter`, `biaya_tindakan`, `biaya_obat`, `total_bayar`, `status`, `metode_bayar`, `created_at`, `updated_at`) VALUES
(1, 3, '50000.00', '2000.00', '20000.00', '72000.00', 'Lunas', 'Tunai', '2025-11-19 08:02:08', '2025-11-19 08:02:08'),
(2, 4, '50000.00', '0.00', '0.00', '50000.00', 'Lunas', 'Tunai', '2025-11-19 09:01:47', '2025-11-19 09:01:47'),
(3, 5, '50000.00', '2000.00', '20000.00', '72000.00', 'Lunas', 'QRIS', '2025-11-19 09:19:44', '2025-11-19 09:19:44'),
(4, 6, '50000.00', '3000.00', '100000.00', '153000.00', 'Lunas', 'Tunai', '2025-11-19 09:20:24', '2025-11-19 09:31:59');

-- --------------------------------------------------------

--
-- Table structure for table `roles_tables`
--

CREATE TABLE `roles_tables` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_praktek` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota` int NOT NULL,
  `status` enum('Tersedia','Penuh','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `doctor_id`, `title`, `tanggal_praktek`, `jam_mulai`, `jam_selesai`, `kuota`, `status`, `created_at`, `updated_at`) VALUES
(266, 1, 'Sesi Khusus', '2025-11-19', '20:01:00', '21:02:00', 10, 'Tersedia', '2025-11-19 01:02:09', '2025-11-19 08:02:44'),
(267, 2, 'pagi', '2025-11-19', '02:17:00', '07:17:00', 10, 'Tersedia', '2025-11-19 09:18:04', '2025-11-19 09:18:04');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CEmJep0xuHJ05BNTjYwXNkKaCkXmp1pLN8KO3btQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmpScUtzVXNzRDFTbWVBbVNLV05zNElTS1BpYjlMUFM0NlVGYVVCTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1763571092),
('vycHnFpE4UJLW0H4yECPxTt5MPtvoImJixuHokZu', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZXBkczJXQUo3Q3gyY3ZPNjRINVRqakQ2NnBkcWRKejVmMWdaQm82MCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9rbGluaWstcHJhdGFtYS11bS9wcm9maWxlIjtzOjU6InJvdXRlIjtzOjEyOiJwcm9maWxlLmVkaXQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1763567847);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default.png',
  `role` enum('admin','doctor','patient') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'patient',
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `role`, `no_hp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Klinik', 'admin@klinikum.id', NULL, '$2y$12$1IBFkUBgEBJzqxtVkS1b1u8pjVLrB39ZDlQ5YiZD8.QQiYrXoZwcq', '1-1763099735.png', 'admin', '08123456789', NULL, '2025-11-13 18:43:56', '2025-11-13 22:55:35'),
(2, 'Dr. Budi Santoso', 'dokter@klinikum.id', NULL, '$2y$12$hNv3qMvJzPFHLSoFR5wM5us4tFOH1hN/9szSW/mI2xL/HFGplyXe6', '2-1763567883.png', 'doctor', '08129876543', NULL, '2025-11-13 18:43:57', '2025-11-19 08:58:03'),
(3, 'Putri Lestari (Mahasiswa)', 'mahasiswa@um.ac.id', NULL, '$2y$12$.up8WJWA5tH642HYipoQlunXmpWF3ecBperr1nrJF1NdHXuAfRQf6', '3-1763099581.png', 'patient', '08567891234', NULL, '2025-11-13 18:43:57', '2025-11-13 22:53:01'),
(4, 'Muhammad Rayhan Najib', 'rayhan@klinikum.id', NULL, '$2y$12$hNdZMSxPlA7YjQqgGDuVQuu7Wk2261hMg7nR3sbpqLJsYDCCh9TZK', 'default.png', 'doctor', '085755538488', NULL, '2025-11-13 22:54:49', '2025-11-13 22:54:49'),
(5, 'fesma', 'fesma@um.ac.id', NULL, '$2y$12$r6MHAi64t2O0T1m46jsukekSLulGGAAJiDW1ojH2.2.NISQMxLaHK', '5-1763264807.png', 'doctor', '34158132', NULL, '2025-11-15 20:36:30', '2025-11-15 20:46:47'),
(6, 'Muhammad Rayhan Najib', 'user1@gmail.com', NULL, '$2y$12$gEn7xAxrU1CxUDpxu39pjO1RTLy0tfyYJ/AoXfJkMsAbEekrRy.w6', '6-1763567915.png', 'patient', '085755538488', NULL, '2025-11-19 08:03:36', '2025-11-19 08:58:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointments_patient_id_schedule_id_unique` (`patient_id`,`schedule_id`),
  ADD KEY `appointments_schedule_id_foreign` (`schedule_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_certificates`
--
ALTER TABLE `medical_certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_certificates_appointment_id_foreign` (`appointment_id`);

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
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_nim_nik_unique` (`nim_nik`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_appointment_id_foreign` (`appointment_id`);

--
-- Indexes for table `roles_tables`
--
ALTER TABLE `roles_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_certificates`
--
ALTER TABLE `medical_certificates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles_tables`
--
ALTER TABLE `roles_tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_certificates`
--
ALTER TABLE `medical_certificates`
  ADD CONSTRAINT `medical_certificates_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
