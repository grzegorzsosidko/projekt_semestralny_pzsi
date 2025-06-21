CREATE DATABASE  IF NOT EXISTS `projekt_semestralny_pzsi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projekt_semestralny_pzsi`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: projekt_semestralny_pzsi
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_foreign` (`post_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (9,5,1,NULL,'Łaaaaał - świetna inicjatywa Panie Prezesie!!!!','2025-06-21 13:35:54','2025-06-21 13:35:54'),(10,5,1,9,'Wiem ...','2025-06-21 13:36:01','2025-06-21 13:36:01');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_categories`
--

DROP TABLE IF EXISTS `contact_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_categories`
--

LOCK TABLES `contact_categories` WRITE;
/*!40000 ALTER TABLE `contact_categories` DISABLE KEYS */;
INSERT INTO `contact_categories` VALUES (1,'Urlopy i nieobecności','2025-06-20 18:55:20','2025-06-20 18:55:20'),(2,'Wynagrodzenia i paski płacowe','2025-06-20 18:55:20','2025-06-20 18:55:20'),(3,'Szkolenia i rozwój','2025-06-20 18:55:20','2025-06-20 18:55:20'),(4,'Benefity (karta sportowa, opieka medyczna)','2025-06-20 18:55:20','2025-06-20 18:55:20'),(5,'Sprawy administracyjne (zaświadczenia)','2025-06-20 18:55:20','2025-06-20 18:55:20'),(6,'Problemy ze sprzętem IT','2025-06-20 18:55:20','2025-06-20 18:55:20'),(7,'Dostęp do systemów','2025-06-20 18:55:20','2025-06-20 18:55:20'),(8,'Awarie oprogramowania','2025-06-20 18:55:20','2025-06-20 18:55:20'),(9,'Wnioski o nowy sprzęt/oprogramowanie','2025-06-20 18:55:20','2025-06-20 18:55:20'),(10,'Bezpieczeństwo IT (incydenty)','2025-06-20 18:55:20','2025-06-20 18:55:20'),(11,'Rekrutacja wewnętrzna','2025-06-20 18:55:20','2025-06-20 18:55:20'),(12,'Proces onboardingu nowego pracownika','2025-06-20 18:55:20','2025-06-20 18:55:20'),(13,'Proces offboardingu','2025-06-20 18:55:20','2025-06-20 18:55:20'),(14,'Ocena pracownicza','2025-06-20 18:55:20','2025-06-20 18:55:20'),(15,'Zarządzanie celami i wynikami','2025-06-20 18:55:20','2025-06-20 18:55:20'),(16,'Kultura organizacyjna i wartości','2025-06-20 18:55:20','2025-06-20 18:55:20'),(17,'Konflikty w zespole','2025-06-20 18:55:20','2025-06-20 18:55:20'),(18,'Zgłoszenie naruszenia/nieprawidłowości','2025-06-20 18:55:20','2025-06-20 18:55:20'),(19,'Pomysły i sugestie (innowacje)','2025-06-20 18:55:20','2025-06-20 18:55:20'),(20,'Organizacja podróży służbowej','2025-06-20 18:55:20','2025-06-20 18:55:20'),(21,'Rozliczenie delegacji','2025-06-20 18:55:20','2025-06-20 18:55:20'),(22,'Marketing i komunikacja wewnętrzna','2025-06-20 18:55:20','2025-06-20 18:55:20'),(23,'Organizacja eventów firmowych','2025-06-20 18:55:20','2025-06-20 18:55:20'),(24,'Sprawy prawne i umowy','2025-06-20 18:55:20','2025-06-20 18:55:20'),(25,'Inne','2025-06-20 18:55:20','2025-06-20 18:55:20');
/*!40000 ALTER TABLE `contact_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doc_categories`
--

DROP TABLE IF EXISTS `doc_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doc_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doc_categories`
--

LOCK TABLES `doc_categories` WRITE;
/*!40000 ALTER TABLE `doc_categories` DISABLE KEYS */;
INSERT INTO `doc_categories` VALUES (1,'BHP','2025-06-20 18:55:20','2025-06-20 18:55:20'),(2,'Instrukcja','2025-06-20 18:55:20','2025-06-20 18:55:20'),(3,'Procedura','2025-06-20 18:55:20','2025-06-20 18:55:20'),(4,'Regulamin','2025-06-20 18:55:20','2025-06-20 18:55:20');
/*!40000 ALTER TABLE `doc_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_files`
--

DROP TABLE IF EXISTS `document_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `document_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `document_id` bigint unsigned NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stored_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_files_document_id_foreign` (`document_id`),
  CONSTRAINT `document_files_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_files`
--

LOCK TABLES `document_files` WRITE;
/*!40000 ALTER TABLE `document_files` DISABLE KEYS */;
INSERT INTO `document_files` VALUES (1,1,'23-FAISFEZ-010806.pdf','w-pelni-interaktywny_7rlpE.pdf','documents/w-pelni-interaktywny_7rlpE.pdf','2025-06-20 20:48:45','2025-06-20 20:48:45'),(2,1,'25_FAAPTR_008585_3587016135.PDF','w-pelni-interaktywny_qZ1S7.pdf','documents/w-pelni-interaktywny_qZ1S7.pdf','2025-06-20 20:48:45','2025-06-20 20:48:45'),(3,2,'[compressed] (long) Heatux CWU - karta prodktu.pdf','w-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywny_y36x9.pdf','documents/w-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywny_y36x9.pdf','2025-06-20 20:49:29','2025-06-20 20:49:29'),(4,2,'[compressed] (short B) Heatux CWU - karta prodktu.pdf','w-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywny_ULowh.pdf','documents/w-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywny_ULowh.pdf','2025-06-20 20:49:29','2025-06-20 20:49:29'),(5,2,'[compressed] techniczna (short B) Heatux CWU - karta prodktu.pdf','w-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywny_5lJiA.pdf','documents/w-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywnyw-pelni-interaktywny_5lJiA.pdf','2025-06-20 20:49:29','2025-06-20 20:49:29'),(6,3,'Dokument_1.pdf','polityka-korzystania-z-mediow-spolecznosciowych_iaoAY.pdf','documents/polityka-korzystania-z-mediow-spolecznosciowych_iaoAY.pdf','2025-06-21 13:20:02','2025-06-21 13:20:02'),(7,3,'Dokument_2.pdf','polityka-korzystania-z-mediow-spolecznosciowych_qxQrb.pdf','documents/polityka-korzystania-z-mediow-spolecznosciowych_qxQrb.pdf','2025-06-21 13:20:02','2025-06-21 13:20:02'),(8,3,'Dokument_3.pdf','polityka-korzystania-z-mediow-spolecznosciowych_lT43J.pdf','documents/polityka-korzystania-z-mediow-spolecznosciowych_lT43J.pdf','2025-06-21 13:20:02','2025-06-21 13:20:02'),(9,4,'Dokument_5.pdf','przewodnik-powitalny-dla-nowych-pracownikow_xYKOG.pdf','documents/przewodnik-powitalny-dla-nowych-pracownikow_xYKOG.pdf','2025-06-21 13:21:56','2025-06-21 13:21:56'),(10,5,'Dokument_1.pdf','kalendarz-wydarzen-firmowych-i-szkolen_cL4qy.pdf','documents/kalendarz-wydarzen-firmowych-i-szkolen_cL4qy.pdf','2025-06-21 13:22:15','2025-06-21 13:22:15'),(11,5,'Dokument_2.pdf','kalendarz-wydarzen-firmowych-i-szkolen_VCyKo.pdf','documents/kalendarz-wydarzen-firmowych-i-szkolen_VCyKo.pdf','2025-06-21 13:22:15','2025-06-21 13:22:15'),(12,5,'Dokument_3.pdf','kalendarz-wydarzen-firmowych-i-szkolen_3kZ7i.pdf','documents/kalendarz-wydarzen-firmowych-i-szkolen_3kZ7i.pdf','2025-06-21 13:22:15','2025-06-21 13:22:15'),(13,5,'Dokument_4.pdf','kalendarz-wydarzen-firmowych-i-szkolen_RsJuF.pdf','documents/kalendarz-wydarzen-firmowych-i-szkolen_RsJuF.pdf','2025-06-21 13:22:15','2025-06-21 13:22:15'),(14,5,'Dokument_5.pdf','kalendarz-wydarzen-firmowych-i-szkolen_asAzj.pdf','documents/kalendarz-wydarzen-firmowych-i-szkolen_asAzj.pdf','2025-06-21 13:22:15','2025-06-21 13:22:15');
/*!40000 ALTER TABLE `document_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `doc_category_id` bigint unsigned NOT NULL,
  `status` enum('published','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_user_id_foreign` (`user_id`),
  KEY `documents_doc_category_id_foreign` (`doc_category_id`),
  CONSTRAINT `documents_doc_category_id_foreign` FOREIGN KEY (`doc_category_id`) REFERENCES `doc_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,'W pełni Interaktywny','sadasd W pełni InteraktywnyW pełni InteraktywnyW pełni Interaktywny',1,3,'published','2025-06-21 13:09:49','2025-06-20 20:48:45','2025-06-21 13:09:49'),(2,'W pełni InteraktywnyW pełni InteraktywnyW pełni InteraktywnyW pełni InteraktywnyW pełni Interaktywny','W pełni InteraktywnyW pełni InteraktywnyW pełni Interaktywny',1,4,'published','2025-06-21 13:09:45','2025-06-20 20:49:29','2025-06-21 13:09:45'),(3,'Polityka Korzystania z Mediów Społecznościowych','Ten dokument szczegółowo określa zasady i wytyczne dotyczące korzystania z mediów społecznościowych przez pracowników firmy, zarówno w celach służbowych, jak i prywatnych, gdy w jakikolwiek sposób wiąże się to z wizerunkiem firmy. Znajdziesz tu informacje na temat odpowiedzialnego zachowania w sieci, ochrony danych poufnych, unikania konfliktów interesów oraz dbania o reputację firmy online. Celem jest zapewnienie spójnego i profesjonalnego wizerunku firmy, a także ochrona interesów zarówno pracowników, jak i organizacji. Zapoznanie się z tym dokumentem jest obowiązkowe dla każdego pracownika.',1,2,'published',NULL,'2025-06-21 13:20:02','2025-06-21 13:20:02'),(4,'Przewodnik Powitalny dla Nowych Pracowników','Ten przewodnik został stworzony, aby ułatwić nowym członkom zespołu szybką i płynną adaptację w naszej firmie. Znajdziesz w nim wszystkie kluczowe informacje, od podstawowych procedur administracyjnych (np. składanie wniosków o urlop, zasady rozliczania podróży służbowych), przez strukturę organizacyjną firmy, dane kontaktowe do kluczowych działów i osób, po informacje o dostępnych benefitach pracowniczych i kulturze organizacyjnej. Jest to Twoje pierwsze źródło informacji, które pomoże Ci poczuć się pewnie i komfortowo od samego początku pracy.',1,3,'published',NULL,'2025-06-21 13:21:56','2025-06-21 13:21:56'),(5,'Kalendarz Wydarzeń Firmowych i Szkoleń','Tutaj znajdziesz aktualny harmonogram wszystkich nadchodzących wydarzeń firmowych – od spotkań integracyjnych, poprzez ważne ogólnofirmowe zebrania, po dni otwarte czy akcje charytatywne. Dodatkowo, w tym dokumencie regularnie aktualizujemy listę dostępnych szkoleń wewnętrznych i zewnętrznych, warsztatów oraz webinarów, które wspierają rozwój zawodowy. Sprawdzaj ten kalendarz regularnie, aby być na bieżąco z życiem firmy i nie przegapić żadnej okazji do rozwoju lub wspólnej zabawy!',1,1,'published',NULL,'2025-06-21 13:22:15','2025-06-21 13:22:15');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_user_id_foreign` (`user_id`),
  CONSTRAINT `faqs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (1,NULL,'Czym jest intranet i do czego służy?','Intranet to wewnętrzna sieć komunikacyjna dostępna tylko dla pracowników firmy. Służy do szybkiego dostępu do ważnych informacji firmowych, dokumentów, narzędzi pracy, a także do ułatwiania komunikacji i współpracy między zespołami. Możesz myśleć o nim jak o prywatnej wersji internetu, stworzonej specjalnie dla nas.',0,'2025-06-21 13:14:56','2025-06-21 13:14:56'),(2,NULL,'Jak mogę uzyskać dostęp do intranetu?','Dostęp do intranetu jest możliwy z każdego komputera podłączonego do sieci firmowej, a także zdalnie poprzez VPN (Virtual Private Network). Po zalogowaniu się na swoje konto służbowe, znajdziesz ikonę lub link do intranetu na pulpicie lub w przeglądarce internetowej. Jeśli masz problem z dostępem, skontaktuj się z działem IT.',0,'2025-06-21 13:15:06','2025-06-21 13:15:06'),(3,NULL,'Czy mogę spersonalizować swój widok intranetu?','Tak, w pewnym zakresie możesz spersonalizować swój pulpit w intranecie. Na przykład, możesz dodawać skróty do najczęściej używanych aplikacji lub dokumentów, subskrybować powiadomienia z konkretnych działów, a także zmieniać układ niektórych widżetów, aby lepiej odpowiadały Twoim potrzebom. Szczegółowe instrukcje dotyczące personalizacji znajdziesz w sekcji \"Pomoc\".',1,'2025-06-21 13:15:14','2025-06-21 13:17:47');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_user_id_foreign` (`user_id`),
  CONSTRAINT `galleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (2,'Nasze Biuro – Praca i Współpraca','Witajcie w naszej wirtualnej wycieczce po biurze! Ta galeria to zbiór zdjęć, które pokazują, jak wygląda nasza codzienna praca, gdzie tworzymy innowacje i budujemy silne relacje. Zobaczycie tu zarówno tętniące życiem przestrzenie wspólne, gdzie rodzą się nowe pomysły, jak i ciche zakątki idealne do skupienia. Chcemy pokazać Wam atmosferę, jaka panuje w naszych progach – ducha współpracy, kreatywności i wzajemnego wsparcia. Przekonajcie się, że biuro to nie tylko miejsce pracy, ale i przestrzeń, w której czujemy się dobrze!',1,0,'2025-06-21 13:25:05','2025-06-21 13:25:05'),(3,'Firmowe Wydarzenia – Wspomnienia i Integracja','Zapraszamy do obejrzenia galerii poświęconej naszym firmowym wydarzeniom! Znajdziecie tu zdjęcia z niezapomnianych spotkań integracyjnych, świątecznych przyjęć, wspólnych akcji charytatywnych i innych okazji, które łączą nas poza codziennymi obowiązkami. To dowód na to, że potrafimy nie tylko ciężko pracować, ale i świetnie się bawić. Te chwile umacniają nasze więzi, budują zespół i tworzą wspomnienia, do których chętnie wracamy. Zobaczcie, jak czerpiemy radość z bycia częścią społeczności!',1,0,'2025-06-21 13:30:35','2025-06-21 13:30:35');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_images_gallery_id_foreign` (`gallery_id`),
  CONSTRAINT `gallery_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_images`
--

LOCK TABLES `gallery_images` WRITE;
/*!40000 ALTER TABLE `gallery_images` DISABLE KEYS */;
INSERT INTO `gallery_images` VALUES (21,2,'gallery/TjyE3CoQ5ZIY6CcBlTcF_1750519505.webp','gallery/thumbnails/TjyE3CoQ5ZIY6CcBlTcF_1750519505.webp','2025-06-21 13:25:06','2025-06-21 13:25:06'),(22,2,'gallery/lhf57peFZWu0WsWFW95L_1750519506.webp','gallery/thumbnails/lhf57peFZWu0WsWFW95L_1750519506.webp','2025-06-21 13:25:06','2025-06-21 13:25:06'),(23,2,'gallery/do71qVEj7l0cGNIXSmEM_1750519506.webp','gallery/thumbnails/do71qVEj7l0cGNIXSmEM_1750519506.webp','2025-06-21 13:25:07','2025-06-21 13:25:07'),(24,2,'gallery/frbMQgt2LQoxRYy8l1qB_1750519507.webp','gallery/thumbnails/frbMQgt2LQoxRYy8l1qB_1750519507.webp','2025-06-21 13:25:08','2025-06-21 13:25:08'),(25,2,'gallery/eRHVrlKGMP7Ng5QCyxnC_1750519508.webp','gallery/thumbnails/eRHVrlKGMP7Ng5QCyxnC_1750519508.webp','2025-06-21 13:25:08','2025-06-21 13:25:08'),(26,2,'gallery/1uQxPS3BHylLCsHReqeJ_1750519508.webp','gallery/thumbnails/1uQxPS3BHylLCsHReqeJ_1750519508.webp','2025-06-21 13:25:09','2025-06-21 13:25:09'),(27,3,'gallery/xp0qO5u4YwrkzVRSkkon_1750519835.webp','gallery/thumbnails/xp0qO5u4YwrkzVRSkkon_1750519835.webp','2025-06-21 13:30:36','2025-06-21 13:30:36'),(28,3,'gallery/h1T97qk25FRZ3i2uAuft_1750519837.webp','gallery/thumbnails/h1T97qk25FRZ3i2uAuft_1750519837.webp','2025-06-21 13:30:38','2025-06-21 13:30:38'),(29,3,'gallery/xf7OyvVJ921VQjaW9ZlF_1750519838.webp','gallery/thumbnails/xf7OyvVJ921VQjaW9ZlF_1750519838.webp','2025-06-21 13:30:40','2025-06-21 13:30:40'),(30,3,'gallery/cxni9hwrVnoPYZGfGOiS_1750519840.webp','gallery/thumbnails/cxni9hwrVnoPYZGfGOiS_1750519840.webp','2025-06-21 13:30:42','2025-06-21 13:30:42');
/*!40000 ALTER TABLE `gallery_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_06_19_140150_add_role_to_users_table',1),(5,'2025_06_19_161856_add_profile_fields_to_users_table',1),(6,'2025_06_19_200426_add_blocked_at_to_users_table',1),(7,'2025_06_19_201338_add_username_to_users_table',1),(8,'2025_06_19_214108_create_doc_categories_table',1),(9,'2025_06_19_214246_create_documents_table',1),(10,'2025_06_19_214307_create_document_files_table',1),(11,'2025_06_19_225623_create_contact_categories_table',1),(12,'2025_06_19_230759_create_faqs_table',1),(13,'2025_06_19_231706_add_user_id_to_faqs_table',1),(14,'2025_06_20_000718_create_galleries_table',1),(15,'2025_06_20_000737_create_gallery_images_table',1),(16,'2025_06_20_192310_create_posts_and_comments_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `title` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subheading` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_1` text COLLATE utf8mb4_unicode_ci,
  `image_1_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_2` text COLLATE utf8mb4_unicode_ci,
  `image_2_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_3` text COLLATE utf8mb4_unicode_ci,
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `views_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (5,1,'Nadchodzą Dni Innowacji 2025!','jasne-oto-trzy-hipotetyczne-teksty-artykulow-do-sekcji-aktualno','Przygotujcie się na najbardziej wyczekiwane wydarzenie roku w naszej firmie! Z przyjemnością ogłaszamy, że Dni Innowacji 2025 odbędą się w dniach 15-17 października! To wyjątkowa okazja, aby zaprezentować swoje kreatywne pomysły, które mogą zrewolucjonizować nasze produkty, procesy lub usługi. Szukamy świeżego spojrzenia i odważnych koncepcji, które pomogą nam kształtować przyszłość.','W tym roku skupiamy się na trzech kluczowych obszarach:\r\n\r\n    Zrównoważony rozwój: Jak możemy działać bardziej ekologicznie?\r\n    Optymalizacja procesów: Co możemy usprawnić, aby pracować efektywniej?\r\n    Nowe technologie: Jak możemy wykorzystać AI, IoT lub inne innowacje w naszej branży?','news/tXSCt7Qxsal_21062025_cover.jpg','Nie ważne, czy jesteś w zespole produkcyjnym, marketingu, czy administracji – każdy pomysł ma znaczenie! Stwórz zespół lub zgłoś się indywidualnie. Szczegółowe informacje o harmonogramie, kryteriach oceny i sposobie zgłaszania projektów znajdziesz w sekcji \"Dni Innowacji\" na intranecie. Termin zgłaszania pomysłów upływa 31 sierpnia. Nie przegap tej szansy na realny wpływ na przyszłość firmy i zdobycie atrakcyjnych nagród!',NULL,NULL,NULL,NULL,0,4,'2025-06-21 13:33:50','2025-06-21 13:36:01'),(6,1,'Wdrażamy Nowy System Zarządzania Projektami – Szkolenia Już Wkrót','wdrazamy-nowy-system-zarzadzania-projektami-szkolenia-juz-wkrot','Mamy ekscytujące wieści dla wszystkich zespołów projektowych! W trosce o jeszcze lepszą koordynację i efektywność pracy, z dniem 1 września 2025 wprowadzamy nowy, intuicyjny system zarządzania projektami – \"ProManager+\". Zastąpi on dotychczas używane narzędzia, integrując w jednym miejscu planowanie, śledzenie postępów, zarządzanie zasobami i komunikację.','Główne korzyści z wdrożenia ProManager+:\r\n\r\n    Centralizacja informacji: Wszystkie dane projektowe w jednym miejscu.\r\n    Usprawniona komunikacja: Wbudowane narzędzia do współpracy w czasie rzeczywistym.\r\n    Lepsza widoczność: Przejrzyste dashboardy i raporty dotyczące statusu projektów.\r\n    Automatyzacja zadań: Oszczędność czasu dzięki automatycznym powiadomieniom i przypomnieniom.','news/NJUgOJ1ctMM_21062025_cover.webp','Aby ułatwić Wam płynne przejście na nowy system, przygotowaliśmy serię obowiązkowych szkoleń. Szkolenia odbędą się w sierpniu, a ich harmonogram oraz linki do zapisów znajdziecie w sekcji \"Szkolenia\" w intranecie. Zachęcamy do aktywnego udziału, aby w pełni wykorzystać potencjał ProManagera+!','news/xYAgSKnhgXE_21062025_img1.jpg',NULL,'news/DLHju4N39dv_21062025_img2.jpg',NULL,0,1,'2025-06-21 13:36:51','2025-06-21 13:36:56'),(7,1,'Raport Roczny ESG 2024: Nasze Zaangażowanie w Zrównoważony Rozwój','raport-roczny-esg-2024-nasze-zaangazowanie-w-zrownowazony-rozwoj','Z dumą prezentujemy Roczny Raport ESG za rok 2024','Z dumą prezentujemy Roczny Raport ESG za rok 2024, podsumowujący nasze osiągnięcia w obszarze środowiskowym, społecznym i zarządczym. Wierzymy, że odpowiedzialne prowadzenie biznesu to podstawa długoterminowego sukcesu i pozytywnego wpływu na otoczenie. Dzięki wspólnemu zaangażowaniu każdego z Was, zrealizowaliśmy wiele ambitnych celów!','news/nBN9tlq8hDF_21062025_cover.jpg','W raporcie znajdziecie m.in. informacje na temat:\r\n\r\n    Redukcji emisji CO2 w naszych operacjach.\r\n    Programów wspierających społeczności lokalne.\r\n    Inwestycji w odnawialne źródła energii.\r\n    Działań na rzecz różnorodności i integracji w miejscu pracy.\r\n    Wzmocnienia ładu korporacyjnego i etycznych praktyk.',NULL,'Pełny raport jest dostępny w zakładce \"Odpowiedzialność Społeczna Biznesu\" na naszej stronie intranetowej. Zachęcamy do zapoznania się z nim, aby zobaczyć, jak wspólnie przyczyniamy się do budowania lepszej przyszłości. Dziękujemy za Wasz wkład w te ważne inicjatywy!','news/CqiXa6uO1d0_21062025_img2.jpg','Pełny raport jest dostępny w zakładce \"Odpowiedzialność Społeczna Biznesu\" na naszej stronie intranetowej. Zachęcamy do zapoznania się z nim, aby zobaczyć, jak wspólnie przyczyniamy się do budowania lepszej przyszłości. Dziękujemy za Wasz wkład w te ważne inicjatywy!',0,0,'2025-06-21 13:38:01','2025-06-21 13:38:01');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('KH1BWG4JOmyfwpuDvbDkfxeJHMZu4SJ9y1XQa7Sx',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOE5QeTFtSXVIVEp3V2FIbU1lRmphOXlQdEt0djJRTVg2ZFpwR2UydyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1750522467);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `interests` text COLLATE utf8mb4_unicode_ci,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` json DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Grzegorz Sosidko','admin','Broniący projektu z PZSI','admin@example.com','+48 737 793 708','Chciałbym zaliczyć ten przedmiot i cieszyć się wakacjami! :)','Jestem chodzącym paradoksem. Interesuję się wszystkim i niczym, co w praktyce wygląda dość… problematycznie.','avatars/A5O36f6EsxBYwcA85OPxgoPu2.jpg','covers/QKlknFyYmwcQkb1u75VOfMhgh.png','{\"facebook\": \"https://www.facebook.com/grzegorz.sosidko\", \"linkedin\": \"https://www.linkedin.com/in/grzegorz-sosidko/\", \"instagram\": null}',NULL,'$2y$12$HMQHjL1xoqvVlV0GHEqmzOAYxPkTm6SxHMwFC3enwALmL4x2QzIiK',NULL,NULL,'2025-06-20 18:55:20','2025-06-21 14:00:03','administrator'),(2,'Sosidko Grzegorz','user','Użytkownik bez uprawnień','user@example.com','+48 538 140 590',NULL,NULL,'avatars/AIFbmnQBnXDN1eSgELi84aYn5.jpg',NULL,NULL,NULL,'$2y$12$XpPh6oL.W0wtqphVCGLpue4xOxvwP/usopKuCUmFa9nXjL4as27k2',NULL,NULL,'2025-06-20 18:55:20','2025-06-21 13:09:28','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-21 18:22:43
