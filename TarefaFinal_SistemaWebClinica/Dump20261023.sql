CREATE DATABASE  IF NOT EXISTS `clinica` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `clinica`;
-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: clinica
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `convenio`
--

DROP TABLE IF EXISTS `convenio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `convenio` (
  `id_convenio` int NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `percentual_desconto` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_convenio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `convenio`
--

LOCK TABLES `convenio` WRITE;
/*!40000 ALTER TABLE `convenio` DISABLE KEYS */;
/*!40000 ALTER TABLE `convenio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exame`
--

DROP TABLE IF EXISTS `exame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exame` (
  `id_exame` int NOT NULL,
  `id_consulta` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_solicitacao` date NOT NULL,
  `data_realizacao` date DEFAULT NULL,
  `resultado` varchar(500) DEFAULT NULL,
  `statusExame` varchar(30) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_exame`),
  KEY `id_consulta` (`id_consulta`),
  CONSTRAINT `exame_ibfk_1` FOREIGN KEY (`id_consulta`) REFERENCES `fazconsulta` (`id_consulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exame`
--

LOCK TABLES `exame` WRITE;
/*!40000 ALTER TABLE `exame` DISABLE KEYS */;
/*!40000 ALTER TABLE `exame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fazconsulta`
--

DROP TABLE IF EXISTS `fazconsulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fazconsulta` (
  `id_consulta` int NOT NULL,
  `id_paciente` int DEFAULT NULL,
  `id_medico` int DEFAULT NULL,
  `data_consulta` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `observacoes` varchar(500) DEFAULT NULL,
  `statusConsulta` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_consulta`),
  KEY `id_paciente` (`id_paciente`),
  KEY `id_medico` (`id_medico`),
  CONSTRAINT `fazconsulta_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`),
  CONSTRAINT `fazconsulta_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fazconsulta`
--

LOCK TABLES `fazconsulta` WRITE;
/*!40000 ALTER TABLE `fazconsulta` DISABLE KEYS */;
INSERT INTO `fazconsulta` VALUES (2,1,2,'2026-10-12','09:15:00','Dores no joelho direito após esforço físico','Solicitado exame de ressonância magnética','Realizada'),(3,1,3,'2026-10-14','10:00:00','Avaliação de manchas recentes na pele','Coletada amostra para biópsia superficial','Realizada'),(5,3,2,'2026-10-22','14:00:00','Suspeita de entorse no tornozelo','Comparecer com exames de raio-X anteriores se houver','Agendada'),(6,4,3,'2026-10-25','15:45:00','Tratamento de dermatite de contato','Retorno programado para ajuste de medicação','Agendada'),(8,5,2,'2026-10-08','17:00:00','Revisão de dor lombar crônica','Paciente não compareceu e não justificou ausência','Cancelada');
/*!40000 ALTER TABLE `fazconsulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medico`
--

DROP TABLE IF EXISTS `medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medico` (
  `id_medico` int NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `crm` varchar(20) DEFAULT NULL,
  `especialidade` varchar(80) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `valor_consulta` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico`
--

LOCK TABLES `medico` WRITE;
/*!40000 ALTER TABLE `medico` DISABLE KEYS */;
INSERT INTO `medico` VALUES (2,'Dr. Fernando Augusto Ribeiro','CRM/MG 72914','Ortopedia','(31) 98456-7890','fernando.ribeiro@clinicaexemplo.com',280.00),(3,'Dra. Juliana Prado Vasconcelos','CRM/RJ 958213','Dermatologia','(21) 99345-6789','juliana.vasconcelos@clinicaexemplo.com',320.00);
/*!40000 ALTER TABLE `medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente` (
  `id_paciente` int NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `cidade` varchar(80) DEFAULT NULL,
  `id_convenio` int DEFAULT NULL,
  PRIMARY KEY (`id_paciente`),
  KEY `id_convenio` (`id_convenio`),
  CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`id_convenio`) REFERENCES `convenio` (`id_convenio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (1,'Lucas Gabriel Ferreira','284.915.630-41','1988-03-14','(11) 98452-1134','lucas.ferreira@exemplo.com','Rua das Flores, 142, Apto 302 - Jd. Paulista','São Paulo - SP',NULL),(2,'Mariana Souza Albuquerque','492.381.705-18','1995-08-27','(31) 99124-7762','mariana.albuquerque@exemplo.com','Av. Afonso Pena, 1500 - Funcionários','Belo Horizonte - MG',NULL),(3,'Roberto Carlos Mendonça','815.064.293-87','1972-11-05','(21) 97341-8902','roberto.mendonca@exemplo.com','Rua Barão da Torre, 340 - Ipanema','Rio de Janeiro - RJ',NULL),(4,'Beatriz Helena Castro','639.182.470-52','2001-01-19','(41) 98855-3419','beatriz.castro@exemplo.com','Rua Marechal Deodoro, 820 - Centro','Curitiba - PR',NULL),(5,'Thiago Henrique Duarte','350.728.914-63','1984-06-09','(71) 99233-6581','thiago.duarte@exemplo.com','Av. Oceânica, 412, Bloco B - Barra','Salvador - BA',NULL),(9999,'Renan',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-23 20:01:14
