-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: gestao_hospitalar
-- ------------------------------------------------------
-- Server version	8.0.35

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
-- Table structure for table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agenda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `cancelado` tinyint(1) NOT NULL DEFAULT '0',
  `data` datetime NOT NULL,
  `duracao_minutos` int NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agenda_id_usuario_user_id_idx` (`id_usuario`),
  CONSTRAINT `agenda_id_usuario_user_id` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `consulta`
--

DROP TABLE IF EXISTS `consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consulta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario_cadastro` int NOT NULL,
  `id_usuario_atendimento` int DEFAULT NULL,
  `id_especialidade` int NOT NULL,
  `teleconsulta` tinyint(1) NOT NULL DEFAULT '0',
  `id_paciente` int NOT NULL,
  `data` datetime NOT NULL,
  `duracao_minutos` int NOT NULL,
  `notas_cadastro` text,
  `notas_atendimento` text,
  PRIMARY KEY (`id`),
  KEY `consulta_id_usuario_cadastro_usuario_id_idx` (`id_usuario_cadastro`),
  KEY `consulta_id_usuario_atendimento_usuario_id_idx` (`id_usuario_atendimento`),
  CONSTRAINT `consulta_id_usuario_atendimento_usuario_id` FOREIGN KEY (`id_usuario_atendimento`) REFERENCES `user` (`id`),
  CONSTRAINT `consulta_id_usuario_cadastro_usuario_id` FOREIGN KEY (`id_usuario_cadastro`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) NOT NULL,
  `mime` varchar(45) DEFAULT NULL,
  `path` varchar(100) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `size` int NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `cep` varchar(20) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `paciente_exame`
--

DROP TABLE IF EXISTS `paciente_exame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente_exame` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `id_exame` int NOT NULL,
  `data` datetime NOT NULL,
  `notas` text,
  PRIMARY KEY (`id`),
  KEY `paciente_exame_id_usuario_usuario_id_idx` (`id_usuario`),
  KEY `paciente_exame_id_paciente_paciente_id_idx` (`id_paciente`),
  CONSTRAINT `paciente_exame_id_paciente_paciente_id` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id`),
  CONSTRAINT `paciente_exame_id_usuario_usuario_id` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prescricao`
--

DROP TABLE IF EXISTS `prescricao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prescricao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_paciente` int NOT NULL,
  `data` datetime NOT NULL,
  `notas` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prescricao_id_usuario_usuario_id_idx` (`id_usuario`),
  KEY `prescricao_id_paciente_paciente_id_idx` (`id_paciente`),
  CONSTRAINT `prescricao_id_paciente_paciente_id` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id`),
  CONSTRAINT `prescricao_id_usuario_usuario_id` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prontuario`
--

DROP TABLE IF EXISTS `prontuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prontuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `id_usuario` int NOT NULL,
  `data` datetime NOT NULL,
  `notas` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `refresh_token`
--

DROP TABLE IF EXISTS `refresh_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `refresh_token` (
  `token` char(36) NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `id_cargo` int DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `roles` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `idx_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario_especialidade`
--

DROP TABLE IF EXISTS `usuario_especialidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_especialidade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_especialidade` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-01 14:25:53
