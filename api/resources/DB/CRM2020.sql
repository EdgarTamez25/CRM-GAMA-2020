-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: crm2020
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.11-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carteras`
--

DROP TABLE IF EXISTS `carteras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carteras` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carteras`
--

LOCK TABLES `carteras` WRITE;
/*!40000 ALTER TABLE `carteras` DISABLE KEYS */;
INSERT INTO `carteras` VALUES (1,'CARTERA 2',1,'2020-03-12 09:29:02','2020-03-12 09:29:02'),(2,'CARTERA 3',1,'2020-03-12 09:33:48','2020-03-12 09:33:48'),(3,'CORTANA',1,'2020-03-27 21:11:18','2020-03-27 21:11:18');
/*!40000 ALTER TABLE `carteras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Cita',1,NULL,NULL),(2,'Reunion',1,NULL,NULL),(3,'Prospecto',1,NULL,NULL),(4,'Asunto Interno',1,NULL,NULL),(5,'Cierre de Proyecto ',1,NULL,NULL),(6,'Quejas y Aclaraciones',1,NULL,NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciudades`
--

DROP TABLE IF EXISTS `ciudades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciudades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2476 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciudades`
--

LOCK TABLES `ciudades` WRITE;
/*!40000 ALTER TABLE `ciudades` DISABLE KEYS */;
INSERT INTO `ciudades` VALUES (1,'Aguascalientes',1,1,1,NULL,NULL),(2,'Asientos',1,1,1,NULL,NULL),(3,'Calvillo',1,1,1,NULL,NULL),(4,'CosÃ­o',1,1,1,NULL,NULL),(5,'Jesus Maria',1,1,1,NULL,NULL),(6,'Pabellon de Arteaga',1,1,1,NULL,NULL),(7,'RincÃ³n de Romos',1,1,1,NULL,NULL),(8,'San JosÃ© de Gracia',1,1,1,NULL,NULL),(9,'Tepezalá',1,1,1,NULL,NULL),(10,'El Llano',1,1,1,NULL,NULL),(11,'San Francisco de los Romo',1,1,1,NULL,NULL),(12,'Ensenada',1,2,1,NULL,NULL),(13,'Mexicali',1,2,1,NULL,NULL),(14,'Tecate',1,2,1,NULL,NULL),(15,'Tijuana',1,2,1,NULL,NULL),(16,'Playas de Rosarito',1,2,1,NULL,NULL),(17,'Comondú',1,3,1,NULL,NULL),(18,'Mulegé',1,3,1,NULL,NULL),(19,'La Paz',1,3,1,NULL,NULL),(20,'Los Cabos',1,3,1,NULL,NULL),(21,'Loreto',1,3,1,NULL,NULL),(22,'Calkiní',1,4,1,NULL,NULL),(23,'Campeche',1,4,1,NULL,NULL),(24,'Carmen',1,4,1,NULL,NULL),(25,'Champotón',1,4,1,NULL,NULL),(26,'Hecelchakán',1,4,1,NULL,NULL),(27,'Hopelchén',1,4,1,NULL,NULL),(28,'Palizada',1,4,1,NULL,NULL),(29,'Tenabo',1,4,1,NULL,NULL),(30,'Escárcega',1,4,1,NULL,NULL),(31,'Calakmul',1,4,1,NULL,NULL),(32,'Candelaria',1,4,1,NULL,NULL),(33,'Abasolo',1,5,1,NULL,NULL),(34,'Acuña',1,5,1,NULL,NULL),(35,'Allende',1,5,1,NULL,NULL),(36,'Arteaga',1,5,1,NULL,NULL),(37,'Candela',1,5,1,NULL,NULL),(38,'Castaños',1,5,1,NULL,NULL),(39,'Cuatro Ciénegas',1,5,1,NULL,NULL),(40,'Escobedo',1,5,1,NULL,NULL),(41,'Francisco I. Madero',1,5,1,NULL,NULL),(42,'Frontera',1,5,1,NULL,NULL),(43,'General Cepeda',1,5,1,NULL,NULL),(44,'Guerrero',1,5,1,NULL,NULL),(45,'Hidalgo',1,5,1,NULL,NULL),(46,'Jiménez',1,5,1,NULL,NULL),(47,'Juárez',1,5,1,NULL,NULL),(48,'Lamadrid',1,5,1,NULL,NULL),(49,'Matamoros',1,5,1,NULL,NULL),(50,'Monclova',1,5,1,NULL,NULL),(51,'Morelos',1,5,1,NULL,NULL),(52,'Múzquiz',1,5,1,NULL,NULL),(53,'Nadadores',1,5,1,NULL,NULL),(54,'Nava',1,5,1,NULL,NULL),(55,'Ocampo',1,5,1,NULL,NULL),(56,'Parras',1,5,1,NULL,NULL),(57,'Piedras Negras',1,5,1,NULL,NULL),(58,'Progreso',1,5,1,NULL,NULL),(59,'Ramos Arizpe',1,5,1,NULL,NULL),(60,'Sabinas',1,5,1,NULL,NULL),(61,'Sacramento',1,5,1,NULL,NULL),(62,'Saltillo',1,5,1,NULL,NULL),(63,'San Buenaventura',1,5,1,NULL,NULL),(64,'San Juan de Sabinas',1,5,1,NULL,NULL),(65,'San Pedro',1,5,1,NULL,NULL),(66,'Sierra Mojada',1,5,1,NULL,NULL),(67,'Torreón',1,5,1,NULL,NULL),(68,'Viesca',1,5,1,NULL,NULL),(69,'Villa Unión',1,5,1,NULL,NULL),(70,'Zaragoza',1,5,1,NULL,NULL),(71,'Armería',1,6,1,NULL,NULL),(72,'Colima',1,6,1,NULL,NULL),(73,'Comala',1,6,1,NULL,NULL),(74,'Coquimatlán',1,6,1,NULL,NULL),(75,'Cuauhtémoc',1,6,1,NULL,NULL),(76,'Ixtlahuacán',1,6,1,NULL,NULL),(77,'Manzanillo',1,6,1,NULL,NULL),(78,'Minatitlán',1,6,1,NULL,NULL),(79,'Tecomán',1,6,1,NULL,NULL),(80,'Villa de Álvarez',1,6,1,NULL,NULL),(81,'Acacoyagua',1,7,1,NULL,NULL),(82,'Acala',1,7,1,NULL,NULL),(83,'Acapetahua',1,7,1,NULL,NULL),(84,'Altamirano',1,7,1,NULL,NULL),(85,'Amatán',1,7,1,NULL,NULL),(86,'Amatenango de la Frontera',1,7,1,NULL,NULL),(87,'Amatenango del Valle',1,7,1,NULL,NULL),(88,'Angel Albino Corzo',1,7,1,NULL,NULL),(89,'Arriaga',1,7,1,NULL,NULL),(90,'Bejucal de Ocampo',1,7,1,NULL,NULL),(91,'Bella Vista',1,7,1,NULL,NULL),(92,'Berriozábal',1,7,1,NULL,NULL),(93,'Bochil',1,7,1,NULL,NULL),(94,'El Bosque',1,7,1,NULL,NULL),(95,'Cacahoatán',1,7,1,NULL,NULL),(96,'Catazajá',1,7,1,NULL,NULL),(97,'Cintalapa',1,7,1,NULL,NULL),(98,'Coapilla',1,7,1,NULL,NULL),(99,'Comitán de Domínguez',1,7,1,NULL,NULL),(100,'La Concordia',1,7,1,NULL,NULL),(101,'Copainalá',1,7,1,NULL,NULL),(102,'Chalchihuitán',1,7,1,NULL,NULL),(103,'Chamula',1,7,1,NULL,NULL),(104,'Chanal',1,7,1,NULL,NULL),(105,'Chapultenango',1,7,1,NULL,NULL),(106,'Chenalhó',1,7,1,NULL,NULL),(107,'Chiapa de Corzo',1,7,1,NULL,NULL),(108,'Chiapilla',1,7,1,NULL,NULL),(109,'Chicoasén',1,7,1,NULL,NULL),(110,'Chicomuselo',1,7,1,NULL,NULL),(111,'Chilón',1,7,1,NULL,NULL),(112,'Escuintla',1,7,1,NULL,NULL),(113,'Francisco León',1,7,1,NULL,NULL),(114,'Frontera Comalapa',1,7,1,NULL,NULL),(115,'Frontera Hidalgo',1,7,1,NULL,NULL),(116,'La Grandeza',1,7,1,NULL,NULL),(117,'Huehuetán',1,7,1,NULL,NULL),(118,'Huixtán',1,7,1,NULL,NULL),(119,'Huitiupán',1,7,1,NULL,NULL),(120,'Huixtla',1,7,1,NULL,NULL),(121,'La Independencia',1,7,1,NULL,NULL),(122,'Ixhuatán',1,7,1,NULL,NULL),(123,'Ixtacomitán',1,7,1,NULL,NULL),(124,'Ixtapa',1,7,1,NULL,NULL),(125,'Ixtapangajoya',1,7,1,NULL,NULL),(126,'Jiquipilas',1,7,1,NULL,NULL),(127,'Jitotol',1,7,1,NULL,NULL),(128,'Juárez',1,7,1,NULL,NULL),(129,'Larráinzar',1,7,1,NULL,NULL),(130,'La Libertad',1,7,1,NULL,NULL),(131,'Mapastepec',1,7,1,NULL,NULL),(132,'Las Margaritas',1,7,1,NULL,NULL),(133,'Mazapa de Madero',1,7,1,NULL,NULL),(134,'Mazatán',1,7,1,NULL,NULL),(135,'Metapa',1,7,1,NULL,NULL),(136,'Mitontic',1,7,1,NULL,NULL),(137,'Motozintla',1,7,1,NULL,NULL),(138,'Nicolás Ruíz',1,7,1,NULL,NULL),(139,'Ocosingo',1,7,1,NULL,NULL),(140,'Ocotepec',1,7,1,NULL,NULL),(141,'Ocozocoautla de Espinosa',1,7,1,NULL,NULL),(142,'Ostuacán',1,7,1,NULL,NULL),(143,'Osumacinta',1,7,1,NULL,NULL),(144,'Oxchuc',1,7,1,NULL,NULL),(145,'Palenque',1,7,1,NULL,NULL),(146,'Pantelhó',1,7,1,NULL,NULL),(147,'Pantepec',1,7,1,NULL,NULL),(148,'Pichucalco',1,7,1,NULL,NULL),(149,'Pijijiapan',1,7,1,NULL,NULL),(150,'El Porvenir',1,7,1,NULL,NULL),(151,'Villa Comaltitlán',1,7,1,NULL,NULL),(152,'Pueblo Nuevo Solistahuacán',1,7,1,NULL,NULL),(153,'Rayón',1,7,1,NULL,NULL),(154,'Reforma',1,7,1,NULL,NULL),(155,'Las Rosas',1,7,1,NULL,NULL),(156,'Sabanilla',1,7,1,NULL,NULL),(157,'Salto de Agua',1,7,1,NULL,NULL),(158,'San Cristóbal de las Casas',1,7,1,NULL,NULL),(159,'San Fernando',1,7,1,NULL,NULL),(160,'Siltepec',1,7,1,NULL,NULL),(161,'Simojovel',1,7,1,NULL,NULL),(162,'Sitalá',1,7,1,NULL,NULL),(163,'Socoltenango',1,7,1,NULL,NULL),(164,'Solosuchiapa',1,7,1,NULL,NULL),(165,'Soyaló',1,7,1,NULL,NULL),(166,'Suchiapa',1,7,1,NULL,NULL),(167,'Suchiate',1,7,1,NULL,NULL),(168,'Sunuapa',1,7,1,NULL,NULL),(169,'Tapachula',1,7,1,NULL,NULL),(170,'Tapalapa',1,7,1,NULL,NULL),(171,'Tapilula',1,7,1,NULL,NULL),(172,'Tecpatán',1,7,1,NULL,NULL),(173,'Tenejapa',1,7,1,NULL,NULL),(174,'Teopisca',1,7,1,NULL,NULL),(175,'Tila',1,7,1,NULL,NULL),(176,'Tonalá',1,7,1,NULL,NULL),(177,'Totolapa',1,7,1,NULL,NULL),(178,'La Trinitaria',1,7,1,NULL,NULL),(179,'Tumbalá',1,7,1,NULL,NULL),(180,'Tuxtla Gutiérrez',1,7,1,NULL,NULL),(181,'Tuxtla Chico',1,7,1,NULL,NULL),(182,'Tuzantán',1,7,1,NULL,NULL),(183,'Tzimol',1,7,1,NULL,NULL),(184,'Unión Juárez',1,7,1,NULL,NULL),(185,'Venustiano Carranza',1,7,1,NULL,NULL),(186,'Villa Corzo',1,7,1,NULL,NULL),(187,'Villaflores',1,7,1,NULL,NULL),(188,'Yajalón',1,7,1,NULL,NULL),(189,'San Lucas',1,7,1,NULL,NULL),(190,'Zinacantán',1,7,1,NULL,NULL),(191,'San Juan Cancuc',1,7,1,NULL,NULL),(192,'Aldama',1,7,1,NULL,NULL),(193,'Benemérito de las Américas',1,7,1,NULL,NULL),(194,'Maravilla Tenejapa',1,7,1,NULL,NULL),(195,'Marqués de Comillas',1,7,1,NULL,NULL),(196,'Montecristo de Guerrero',1,7,1,NULL,NULL),(197,'San Andrés Duraznal',1,7,1,NULL,NULL),(198,'Santiago el Pinar',1,7,1,NULL,NULL),(199,'Ahumada',1,8,1,NULL,NULL),(200,'Aldama',1,8,1,NULL,NULL),(201,'Allende',1,8,1,NULL,NULL),(202,'Aquiles Serdán',1,8,1,NULL,NULL),(203,'Ascensión',1,8,1,NULL,NULL),(204,'Bachíniva',1,8,1,NULL,NULL),(205,'Balleza',1,8,1,NULL,NULL),(206,'Batopilas',1,8,1,NULL,NULL),(207,'Bocoyna',1,8,1,NULL,NULL),(208,'Buenaventura',1,8,1,NULL,NULL),(209,'Camargo',1,8,1,NULL,NULL),(210,'Carichí',1,8,1,NULL,NULL),(211,'Casas Grandes',1,8,1,NULL,NULL),(212,'Coronado',1,8,1,NULL,NULL),(213,'Coyame del Sotol',1,8,1,NULL,NULL),(214,'La Cruz',1,8,1,NULL,NULL),(215,'Cuauhtémoc',1,8,1,NULL,NULL),(216,'Cusihuiriachi',1,8,1,NULL,NULL),(217,'Chihuahua',1,8,1,NULL,NULL),(218,'Chínipas',1,8,1,NULL,NULL),(219,'Delicias',1,8,1,NULL,NULL),(220,'Dr. Belisario Domínguez',1,8,1,NULL,NULL),(221,'Galeana',1,8,1,NULL,NULL),(222,'Santa Isabel',1,8,1,NULL,NULL),(223,'Gómez Farías',1,8,1,NULL,NULL),(224,'Gran Morelos',1,8,1,NULL,NULL),(225,'Guachochi',1,8,1,NULL,NULL),(226,'Guadalupe',1,8,1,NULL,NULL),(227,'Guadalupe y Calvo',1,8,1,NULL,NULL),(228,'Guazapares',1,8,1,NULL,NULL),(229,'Guerrero',1,8,1,NULL,NULL),(230,'Hidalgo del Parral',1,8,1,NULL,NULL),(231,'Huejotitán',1,8,1,NULL,NULL),(232,'Ignacio Zaragoza',1,8,1,NULL,NULL),(233,'Janos',1,8,1,NULL,NULL),(234,'Jiménez',1,8,1,NULL,NULL),(235,'Juárez',1,8,1,NULL,NULL),(236,'Julimes',1,8,1,NULL,NULL),(237,'López',1,8,1,NULL,NULL),(238,'Madera',1,8,1,NULL,NULL),(239,'Maguarichi',1,8,1,NULL,NULL),(240,'Manuel Benavides',1,8,1,NULL,NULL),(241,'Matachí',1,8,1,NULL,NULL),(242,'Matamoros',1,8,1,NULL,NULL),(243,'Meoqui',1,8,1,NULL,NULL),(244,'Morelos',1,8,1,NULL,NULL),(245,'Moris',1,8,1,NULL,NULL),(246,'Namiquipa',1,8,1,NULL,NULL),(247,'Nonoava',1,8,1,NULL,NULL),(248,'Nuevo Casas Grandes',1,8,1,NULL,NULL),(249,'Ocampo',1,8,1,NULL,NULL),(250,'Ojinaga',1,8,1,NULL,NULL),(251,'Praxedis G. Guerrero',1,8,1,NULL,NULL),(252,'Riva Palacio',1,8,1,NULL,NULL),(253,'Rosales',1,8,1,NULL,NULL),(254,'Rosario',1,8,1,NULL,NULL),(255,'San Francisco de Borja',1,8,1,NULL,NULL),(256,'San Francisco de Conchos',1,8,1,NULL,NULL),(257,'San Francisco del Oro',1,8,1,NULL,NULL),(258,'Santa Bárbara',1,8,1,NULL,NULL),(259,'Satevó',1,8,1,NULL,NULL),(260,'Saucillo',1,8,1,NULL,NULL),(261,'Temósachic',1,8,1,NULL,NULL),(262,'El Tule',1,8,1,NULL,NULL),(263,'Urique',1,8,1,NULL,NULL),(264,'Uruachi',1,8,1,NULL,NULL),(265,'Valle de Zaragoza',1,8,1,NULL,NULL),(266,'Azcapotzalco',1,9,1,NULL,NULL),(267,'Coyoacán',1,9,1,NULL,NULL),(268,'Cuajimalpa de Morelos',1,9,1,NULL,NULL),(269,'Gustavo A. Madero',1,9,1,NULL,NULL),(270,'Iztacalco',1,9,1,NULL,NULL),(271,'Iztapalapa',1,9,1,NULL,NULL),(272,'La Magdalena Contreras',1,9,1,NULL,NULL),(273,'Milpa Alta',1,9,1,NULL,NULL),(274,'Álvaro Obregón',1,9,1,NULL,NULL),(275,'Tláhuac',1,9,1,NULL,NULL),(276,'Tlalpan',1,9,1,NULL,NULL),(277,'Xochimilco',1,9,1,NULL,NULL),(278,'Benito Juárez',1,9,1,NULL,NULL),(279,'Cuauhtémoc',1,9,1,NULL,NULL),(280,'Miguel Hidalgo',1,9,1,NULL,NULL),(281,'Venustiano Carranza',1,9,1,NULL,NULL),(282,'Canatlán',1,10,1,NULL,NULL),(283,'Canelas',1,10,1,NULL,NULL),(284,'Coneto de Comonfort',1,10,1,NULL,NULL),(285,'Cuencamé',1,10,1,NULL,NULL),(286,'Durango',1,10,1,NULL,NULL),(287,'General Simón Bolívar',1,10,1,NULL,NULL),(288,'Gómez Palacio',1,10,1,NULL,NULL),(289,'Guadalupe Victoria',1,10,1,NULL,NULL),(290,'Guanaceví',1,10,1,NULL,NULL),(291,'Hidalgo',1,10,1,NULL,NULL),(292,'Indé',1,10,1,NULL,NULL),(293,'Lerdo',1,10,1,NULL,NULL),(294,'Mapimí',1,10,1,NULL,NULL),(295,'Mezquital',1,10,1,NULL,NULL),(296,'Nazas',1,10,1,NULL,NULL),(297,'Nombre de Dios',1,10,1,NULL,NULL),(298,'Ocampo',1,10,1,NULL,NULL),(299,'El Oro',1,10,1,NULL,NULL),(300,'Otáez',1,10,1,NULL,NULL),(302,'Pánuco de Coronado',1,10,1,NULL,NULL),(303,'Peñón Blanco',1,10,1,NULL,NULL),(304,'Poanas',1,10,1,NULL,NULL),(305,'Pueblo Nuevo',1,10,1,NULL,NULL),(306,'Rodeo',1,10,1,NULL,NULL),(307,'San Bernardo',1,10,1,NULL,NULL),(308,'San Dimas',1,10,1,NULL,NULL),(309,'San Juan de Guadalupe',1,10,1,NULL,NULL),(310,'San Juan del Río',1,10,1,NULL,NULL),(311,'San Luis del Cordero',1,10,1,NULL,NULL),(312,'San Pedro del Gallo',1,10,1,NULL,NULL),(313,'Santa Clara',1,10,1,NULL,NULL),(314,'Santiago Papasquiaro',1,10,1,NULL,NULL),(315,'Súchil',1,10,1,NULL,NULL),(316,'Tamazula',1,10,1,NULL,NULL),(317,'Tepehuanes',1,10,1,NULL,NULL),(318,'Tlahualilo',1,10,1,NULL,NULL),(319,'Topia',1,10,1,NULL,NULL),(320,'Vicente Guerrero',1,10,1,NULL,NULL),(321,'Nuevo Ideal',1,10,1,NULL,NULL),(322,'Abasolo',1,11,1,NULL,NULL),(323,'Acámbaro',1,11,1,NULL,NULL),(324,'San Miguel de Allende',1,11,1,NULL,NULL),(325,'Apaseo el Alto',1,11,1,NULL,NULL),(326,'Apaseo el Grande',1,11,1,NULL,NULL),(327,'Atarjea',1,11,1,NULL,NULL),(328,'Celaya',1,11,1,NULL,NULL),(329,'Manuel Doblado',1,11,1,NULL,NULL),(330,'Comonfort',1,11,1,NULL,NULL),(331,'Coroneo',1,11,1,NULL,NULL),(332,'Cortazar',1,11,1,NULL,NULL),(333,'Cuerámaro',1,11,1,NULL,NULL),(334,'Doctor Mora',1,11,1,NULL,NULL),(335,'Dolores Hidalgo Cuna de la Independencia Nacional',1,11,1,NULL,NULL),(336,'Guanajuato',1,11,1,NULL,NULL),(337,'Huanímaro',1,11,1,NULL,NULL),(338,'Irapuato',1,11,1,NULL,NULL),(339,'Jaral del Progreso',1,11,1,NULL,NULL),(340,'Jerécuaro',1,11,1,NULL,NULL),(341,'León',1,11,1,NULL,NULL),(342,'Moroleón',1,11,1,NULL,NULL),(343,'Ocampo',1,11,1,NULL,NULL),(344,'Pénjamo',1,11,1,NULL,NULL),(345,'Pueblo Nuevo',1,11,1,NULL,NULL),(346,'Purísima del Rincón',1,11,1,NULL,NULL),(347,'Romita',1,11,1,NULL,NULL),(348,'Salamanca',1,11,1,NULL,NULL),(349,'Salvatierra',1,11,1,NULL,NULL),(350,'San Diego de la Unión',1,11,1,NULL,NULL),(351,'San Felipe',1,11,1,NULL,NULL),(352,'San Francisco del Rincón',1,11,1,NULL,NULL),(353,'San José Iturbide',1,11,1,NULL,NULL),(354,'San Luis de la Paz',1,11,1,NULL,NULL),(355,'Santa Catarina',1,11,1,NULL,NULL),(356,'Santa Cruz de Juventino Rosas',1,11,1,NULL,NULL),(357,'Santiago Maravatío',1,11,1,NULL,NULL),(358,'Silao de la Victoria',1,11,1,NULL,NULL),(359,'Tarandacuao',1,11,1,NULL,NULL),(360,'Tarimoro',1,11,1,NULL,NULL),(361,'Tierra Blanca',1,11,1,NULL,NULL),(362,'Uriangato',1,11,1,NULL,NULL),(363,'Valle de Santiago',1,11,1,NULL,NULL),(364,'Victoria',1,11,1,NULL,NULL),(365,'Villagrán',1,11,1,NULL,NULL),(366,'Xichú',1,11,1,NULL,NULL),(367,'Yuriria',1,11,1,NULL,NULL),(368,'Acapulco de Juárez',1,12,1,NULL,NULL),(369,'Ahuacuotzingo',1,12,1,NULL,NULL),(370,'Ajuchitlán del Progreso',1,12,1,NULL,NULL),(371,'Alcozauca de Guerrero',1,12,1,NULL,NULL),(372,'Alpoyeca',1,12,1,NULL,NULL),(373,'Apaxtla',1,12,1,NULL,NULL),(374,'Arcelia',1,12,1,NULL,NULL),(375,'Atenango del Río',1,12,1,NULL,NULL),(376,'Atlamajalcingo del Monte',1,12,1,NULL,NULL),(377,'Atlixtac',1,12,1,NULL,NULL),(378,'Atoyac de Álvarez',1,12,1,NULL,NULL),(379,'Ayutla de los Libres',1,12,1,NULL,NULL),(380,'Azoyú',1,12,1,NULL,NULL),(381,'Benito Juárez',1,12,1,NULL,NULL),(382,'Buenavista de Cuéllar',1,12,1,NULL,NULL),(383,'Coahuayutla de José María Izazaga',1,12,1,NULL,NULL),(384,'Cocula',1,12,1,NULL,NULL),(385,'Copala',1,12,1,NULL,NULL),(386,'Copalillo',1,12,1,NULL,NULL),(387,'Copanatoyac',1,12,1,NULL,NULL),(388,'Coyuca de Benítez',1,12,1,NULL,NULL),(389,'Coyuca de Catalán',1,12,1,NULL,NULL),(390,'Cuajinicuilapa',1,12,1,NULL,NULL),(391,'Cualác',1,12,1,NULL,NULL),(392,'Cuautepec',1,12,1,NULL,NULL),(393,'Cuetzala del Progreso',1,12,1,NULL,NULL),(394,'Cutzamala de Pinzón',1,12,1,NULL,NULL),(395,'Chilapa de Álvarez',1,12,1,NULL,NULL),(396,'Chilpancingo de los Bravo',1,12,1,NULL,NULL),(397,'Florencio Villarreal',1,12,1,NULL,NULL),(398,'General Canuto A. Neri',1,12,1,NULL,NULL),(399,'General Heliodoro Castillo',1,12,1,NULL,NULL),(400,'Huamuxtitlán',1,12,1,NULL,NULL),(401,'Huitzuco de los Figueroa',1,12,1,NULL,NULL),(403,'Iguala de la Independencia',1,12,1,NULL,NULL),(404,'Igualapa',1,12,1,NULL,NULL),(405,'Ixcateopan de Cuauhtémoc',1,12,1,NULL,NULL),(406,'Zihuatanejo de Azueta',1,12,1,NULL,NULL),(407,'Juan R. Escudero',1,12,1,NULL,NULL),(408,'Leonardo Bravo',1,12,1,NULL,NULL),(409,'Malinaltepec',1,12,1,NULL,NULL),(410,'Mártir de Cuilapan',1,12,1,NULL,NULL),(411,'Metlatónoc',1,12,1,NULL,NULL),(412,'Mochitlán',1,12,1,NULL,NULL),(413,'Olinalá',1,12,1,NULL,NULL),(414,'Ometepec',1,12,1,NULL,NULL),(415,'Pedro Ascencio Alquisiras',1,12,1,NULL,NULL),(416,'Petatlán',1,12,1,NULL,NULL),(417,'Pilcaya',1,12,1,NULL,NULL),(418,'Pungarabato',1,12,1,NULL,NULL),(419,'Quechultenango',1,12,1,NULL,NULL),(420,'San Luis Acatlán',1,12,1,NULL,NULL),(421,'San Marcos',1,12,1,NULL,NULL),(422,'San Miguel Totolapan',1,12,1,NULL,NULL),(423,'Taxco de Alarcón',1,12,1,NULL,NULL),(424,'Tecoanapa',1,12,1,NULL,NULL),(425,'Técpan de Galeana',1,12,1,NULL,NULL),(426,'Teloloapan',1,12,1,NULL,NULL),(427,'Tepecoacuilco de Trujano',1,12,1,NULL,NULL),(428,'Tetipac',1,12,1,NULL,NULL),(429,'Tixtla de Guerrero',1,12,1,NULL,NULL),(430,'Tlacoachistlahuaca',1,12,1,NULL,NULL),(431,'Tlacoapa',1,12,1,NULL,NULL),(432,'Tlalchapa',1,12,1,NULL,NULL),(433,'Tlalixtaquilla de Maldonado',1,12,1,NULL,NULL),(434,'Tlapa de Comonfort',1,12,1,NULL,NULL),(435,'Tlapehuala',1,12,1,NULL,NULL),(436,'La Unión de Isidoro Montes de Oca',1,12,1,NULL,NULL),(437,'Xalpatláhuac',1,12,1,NULL,NULL),(438,'Xochihuehuetlán',1,12,1,NULL,NULL),(439,'Xochistlahuaca',1,12,1,NULL,NULL),(440,'Zapotitlán Tablas',1,12,1,NULL,NULL),(441,'Zirándaro',1,12,1,NULL,NULL),(442,'Zitlala',1,12,1,NULL,NULL),(443,'Eduardo Neri',1,12,1,NULL,NULL),(444,'Acatepec',1,12,1,NULL,NULL),(445,'Marquelia',1,12,1,NULL,NULL),(446,'Cochoapa el Grande',1,12,1,NULL,NULL),(447,'José Joaquín de Herrera',1,12,1,NULL,NULL),(448,'Juchitán',1,12,1,NULL,NULL),(449,'Iliatenco',1,12,1,NULL,NULL),(450,'Acatlán',1,13,1,NULL,NULL),(451,'Acaxochitlán',1,13,1,NULL,NULL),(452,'Actopan',1,13,1,NULL,NULL),(453,'Agua Blanca de Iturbide',1,13,1,NULL,NULL),(454,'Ajacuba',1,13,1,NULL,NULL),(455,'Alfajayucan',1,13,1,NULL,NULL),(456,'Almoloya',1,13,1,NULL,NULL),(457,'Apan',1,13,1,NULL,NULL),(458,'El Arenal',1,13,1,NULL,NULL),(459,'Atitalaquia',1,13,1,NULL,NULL),(460,'Atlapexco',1,13,1,NULL,NULL),(461,'Atotonilco el Grande',1,13,1,NULL,NULL),(462,'Atotonilco de Tula',1,13,1,NULL,NULL),(463,'Calnali',1,13,1,NULL,NULL),(464,'Cardonal',1,13,1,NULL,NULL),(465,'Cuautepec de Hinojosa',1,13,1,NULL,NULL),(466,'Chapantongo',1,13,1,NULL,NULL),(467,'Chapulhuacán',1,13,1,NULL,NULL),(468,'Chilcuautla',1,13,1,NULL,NULL),(469,'Eloxochitlán',1,13,1,NULL,NULL),(470,'Emiliano Zapata',1,13,1,NULL,NULL),(471,'Epazoyucan',1,13,1,NULL,NULL),(472,'Francisco I. Madero',1,13,1,NULL,NULL),(473,'Huasca de Ocampo',1,13,1,NULL,NULL),(474,'Huautla',1,13,1,NULL,NULL),(475,'Huazalingo',1,13,1,NULL,NULL),(476,'Huehuetla',1,13,1,NULL,NULL),(477,'Huejutla de Reyes',1,13,1,NULL,NULL),(478,'Huichapan',1,13,1,NULL,NULL),(479,'Ixmiquilpan',1,13,1,NULL,NULL),(480,'Jacala de Ledezma',1,13,1,NULL,NULL),(481,'Jaltocán',1,13,1,NULL,NULL),(482,'Juárez Hidalgo',1,13,1,NULL,NULL),(483,'Lolotla',1,13,1,NULL,NULL),(484,'Metepec',1,13,1,NULL,NULL),(485,'San Agustín Metzquititlán',1,13,1,NULL,NULL),(486,'Metztitlán',1,13,1,NULL,NULL),(487,'Mineral del Chico',1,13,1,NULL,NULL),(488,'Mineral del Monte',1,13,1,NULL,NULL),(489,'La Misión',1,13,1,NULL,NULL),(490,'Mixquiahuala de Juárez',1,13,1,NULL,NULL),(491,'Molango de Escamilla',1,13,1,NULL,NULL),(492,'Nicolás Flores',1,13,1,NULL,NULL),(493,'Nopala de Villagrán',1,13,1,NULL,NULL),(494,'Omitlán de Juárez',1,13,1,NULL,NULL),(495,'San Felipe Orizatlán',1,13,1,NULL,NULL),(496,'Pacula',1,13,1,NULL,NULL),(497,'Pachuca de Soto',1,13,1,NULL,NULL),(498,'Pisaflores',1,13,1,NULL,NULL),(499,'Progreso de Obregón',1,13,1,NULL,NULL),(500,'Mineral de la Reforma',1,13,1,NULL,NULL),(501,'San Agustín Tlaxiaca',1,13,1,NULL,NULL),(502,'San Bartolo Tutotepec',1,13,1,NULL,NULL),(503,'San Salvador',1,13,1,NULL,NULL),(504,'Santiago de Anaya',1,13,1,NULL,NULL),(505,'Santiago Tulantepec de Lugo Guerrero',1,13,1,NULL,NULL),(506,'Singuilucan',1,13,1,NULL,NULL),(507,'Tasquillo',1,13,1,NULL,NULL),(508,'Tecozautla',1,13,1,NULL,NULL),(509,'Tenango de Doria',1,13,1,NULL,NULL),(510,'Tepeapulco',1,13,1,NULL,NULL),(511,'Tepehuacán de Guerrero',1,13,1,NULL,NULL),(512,'Tepeji del Río de Ocampo',1,13,1,NULL,NULL),(513,'Tepetitlán',1,13,1,NULL,NULL),(514,'Tetepango',1,13,1,NULL,NULL),(515,'Villa de Tezontepec',1,13,1,NULL,NULL),(516,'Tezontepec de Aldama',1,13,1,NULL,NULL),(517,'Tianguistengo',1,13,1,NULL,NULL),(518,'Tizayuca',1,13,1,NULL,NULL),(519,'Tlahuelilpan',1,13,1,NULL,NULL),(520,'Tlahuiltepa',1,13,1,NULL,NULL),(521,'Tlanalapa',1,13,1,NULL,NULL),(522,'Tlanchinol',1,13,1,NULL,NULL),(523,'Tlaxcoapan',1,13,1,NULL,NULL),(524,'Tolcayuca',1,13,1,NULL,NULL),(525,'Tula de Allende',1,13,1,NULL,NULL),(526,'Tulancingo de Bravo',1,13,1,NULL,NULL),(527,'Xochiatipan',1,13,1,NULL,NULL),(528,'Xochicoatlán',1,13,1,NULL,NULL),(529,'Yahualica',1,13,1,NULL,NULL),(530,'Zacualtipán de Ángeles',1,13,1,NULL,NULL),(531,'Zapotlán de Juárez',1,13,1,NULL,NULL),(532,'Zempoala',1,13,1,NULL,NULL),(533,'Zimapán',1,13,1,NULL,NULL),(534,'Acatic',1,14,1,NULL,NULL),(535,'Acatlán de Juárez',1,14,1,NULL,NULL),(536,'Ahualulco de Mercado',1,14,1,NULL,NULL),(537,'Amacueca',1,14,1,NULL,NULL),(538,'Amatitán',1,14,1,NULL,NULL),(539,'Ameca',1,14,1,NULL,NULL),(540,'San Juanito de Escobedo',1,14,1,NULL,NULL),(541,'Arandas',1,14,1,NULL,NULL),(542,'El Arenal',1,14,1,NULL,NULL),(543,'Atemajac de Brizuela',1,14,1,NULL,NULL),(544,'Atengo',1,14,1,NULL,NULL),(545,'Atenguillo',1,14,1,NULL,NULL),(546,'Atotonilco el Alto',1,14,1,NULL,NULL),(547,'Atoyac',1,14,1,NULL,NULL),(548,'Autlán de Navarro',1,14,1,NULL,NULL),(549,'Ayotlán',1,14,1,NULL,NULL),(550,'Ayutla',1,14,1,NULL,NULL),(551,'La Barca',1,14,1,NULL,NULL),(552,'Bolaños',1,14,1,NULL,NULL),(553,'Cabo Corrientes',1,14,1,NULL,NULL),(554,'Casimiro Castillo',1,14,1,NULL,NULL),(555,'Cihuatlán',1,14,1,NULL,NULL),(556,'Zapotlán el Grande',1,14,1,NULL,NULL),(557,'Cocula',1,14,1,NULL,NULL),(558,'Colotlán',1,14,1,NULL,NULL),(559,'Concepción de Buenos Aires',1,14,1,NULL,NULL),(560,'Cuautitlán de García Barragán',1,14,1,NULL,NULL),(561,'Cuautla',1,14,1,NULL,NULL),(562,'Cuquío',1,14,1,NULL,NULL),(563,'Chapala',1,14,1,NULL,NULL),(564,'Chimaltitán',1,14,1,NULL,NULL),(565,'Chiquilistlán',1,14,1,NULL,NULL),(566,'Degollado',1,14,1,NULL,NULL),(567,'Ejutla',1,14,1,NULL,NULL),(568,'Encarnación de Díaz',1,14,1,NULL,NULL),(569,'Etzatlán',1,14,1,NULL,NULL),(570,'El Grullo',1,14,1,NULL,NULL),(571,'Guachinango',1,14,1,NULL,NULL),(572,'Guadalajara',1,14,1,NULL,NULL),(573,'Hostotipaquillo',1,14,1,NULL,NULL),(574,'Huejúcar',1,14,1,NULL,NULL),(575,'Huejuquilla el Alto',1,14,1,NULL,NULL),(576,'La Huerta',1,14,1,NULL,NULL),(577,'Ixtlahuacán de los Membrillos',1,14,1,NULL,NULL),(578,'Ixtlahuacán del Río',1,14,1,NULL,NULL),(579,'Jalostotitlán',1,14,1,NULL,NULL),(580,'Jamay',1,14,1,NULL,NULL),(581,'Jesús María',1,14,1,NULL,NULL),(582,'Jilotlán de los Dolores',1,14,1,NULL,NULL),(583,'Jocotepec',1,14,1,NULL,NULL),(584,'Juanacatlán',1,14,1,NULL,NULL),(585,'Juchitlán',1,14,1,NULL,NULL),(586,'Lagos de Moreno',1,14,1,NULL,NULL),(587,'El Limón',1,14,1,NULL,NULL),(588,'Magdalena',1,14,1,NULL,NULL),(589,'Santa María del Oro',1,14,1,NULL,NULL),(590,'La Manzanilla de la Paz',1,14,1,NULL,NULL),(591,'Mascota',1,14,1,NULL,NULL),(592,'Mazamitla',1,14,1,NULL,NULL),(593,'Mexticacán',1,14,1,NULL,NULL),(594,'Mezquitic',1,14,1,NULL,NULL),(595,'Mixtlán',1,14,1,NULL,NULL),(596,'Ocotlán',1,14,1,NULL,NULL),(597,'Ojuelos de Jalisco',1,14,1,NULL,NULL),(598,'Pihuamo',1,14,1,NULL,NULL),(599,'Poncitlán',1,14,1,NULL,NULL),(600,'Puerto Vallarta',1,14,1,NULL,NULL),(601,'Villa Purificación',1,14,1,NULL,NULL),(602,'Quitupan',1,14,1,NULL,NULL),(604,'El Salto',1,14,1,NULL,NULL),(605,'San Cristóbal de la Barranca',1,14,1,NULL,NULL),(606,'San Diego de Alejandría',1,14,1,NULL,NULL),(607,'San Juan de los Lagos',1,14,1,NULL,NULL),(608,'San Julián',1,14,1,NULL,NULL),(609,'San Marcos',1,14,1,NULL,NULL),(610,'San Martín de Bolaños',1,14,1,NULL,NULL),(611,'San Martín Hidalgo',1,14,1,NULL,NULL),(612,'San Miguel el Alto',1,14,1,NULL,NULL),(613,'Gómez Farías',1,14,1,NULL,NULL),(614,'San Sebastián del Oeste',1,14,1,NULL,NULL),(615,'Santa María de los Ángeles',1,14,1,NULL,NULL),(616,'Sayula',1,14,1,NULL,NULL),(617,'Tala',1,14,1,NULL,NULL),(618,'Talpa de Allende',1,14,1,NULL,NULL),(619,'Tamazula de Gordiano',1,14,1,NULL,NULL),(620,'Tapalpa',1,14,1,NULL,NULL),(621,'Tecalitlán',1,14,1,NULL,NULL),(622,'Tecolotlán',1,14,1,NULL,NULL),(623,'Techaluta de Montenegro',1,14,1,NULL,NULL),(624,'Tenamaxtlán',1,14,1,NULL,NULL),(625,'Teocaltiche',1,14,1,NULL,NULL),(626,'Teocuitatlán de Corona',1,14,1,NULL,NULL),(627,'Tepatitlán de Morelos',1,14,1,NULL,NULL),(628,'Tequila',1,14,1,NULL,NULL),(629,'Teuchitlán',1,14,1,NULL,NULL),(630,'Tizapán el Alto',1,14,1,NULL,NULL),(631,'Tlajomulco de Zúñiga',1,14,1,NULL,NULL),(632,'San Pedro Tlaquepaque',1,14,1,NULL,NULL),(633,'Tolimán',1,14,1,NULL,NULL),(634,'Tomatlán',1,14,1,NULL,NULL),(635,'Tonalá',1,14,1,NULL,NULL),(636,'Tonaya',1,14,1,NULL,NULL),(637,'Tonila',1,14,1,NULL,NULL),(638,'Totatiche',1,14,1,NULL,NULL),(639,'Tototlán',1,14,1,NULL,NULL),(640,'Tuxcacuesco',1,14,1,NULL,NULL),(641,'Tuxcueca',1,14,1,NULL,NULL),(642,'Tuxpan',1,14,1,NULL,NULL),(643,'Unión de San Antonio',1,14,1,NULL,NULL),(644,'Unión de Tula',1,14,1,NULL,NULL),(645,'Valle de Guadalupe',1,14,1,NULL,NULL),(646,'Valle de Juárez',1,14,1,NULL,NULL),(647,'San Gabriel',1,14,1,NULL,NULL),(648,'Villa Corona',1,14,1,NULL,NULL),(649,'Villa Guerrero',1,14,1,NULL,NULL),(650,'Villa Hidalgo',1,14,1,NULL,NULL),(651,'Cañadas de Obregón',1,14,1,NULL,NULL),(652,'Yahualica de González Gallo',1,14,1,NULL,NULL),(653,'Zacoalco de Torres',1,14,1,NULL,NULL),(654,'Zapopan',1,14,1,NULL,NULL),(655,'Zapotiltic',1,14,1,NULL,NULL),(656,'Zapotitlán de Vadillo',1,14,1,NULL,NULL),(657,'Zapotlán del Rey',1,14,1,NULL,NULL),(658,'Zapotlanejo',1,14,1,NULL,NULL),(659,'San Ignacio Cerro Gordo',1,14,1,NULL,NULL),(660,'Acambay de Ruíz Castañeda',1,15,1,NULL,NULL),(661,'Acolman',1,15,1,NULL,NULL),(662,'Aculco',1,15,1,NULL,NULL),(663,'Almoloya de Alquisiras',1,15,1,NULL,NULL),(664,'Almoloya de Juárez',1,15,1,NULL,NULL),(665,'Almoloya del Río',1,15,1,NULL,NULL),(666,'Amanalco',1,15,1,NULL,NULL),(667,'Amatepec',1,15,1,NULL,NULL),(668,'Amecameca',1,15,1,NULL,NULL),(669,'Apaxco',1,15,1,NULL,NULL),(670,'Atenco',1,15,1,NULL,NULL),(671,'Atizapán',1,15,1,NULL,NULL),(672,'Atizapán de Zaragoza',1,15,1,NULL,NULL),(673,'Atlacomulco',1,15,1,NULL,NULL),(674,'Atlautla',1,15,1,NULL,NULL),(675,'Axapusco',1,15,1,NULL,NULL),(676,'Ayapango',1,15,1,NULL,NULL),(677,'Calimaya',1,15,1,NULL,NULL),(678,'Capulhuac',1,15,1,NULL,NULL),(679,'Coacalco de Berriozábal',1,15,1,NULL,NULL),(680,'Coatepec Harinas',1,15,1,NULL,NULL),(681,'Cocotitlán',1,15,1,NULL,NULL),(682,'Coyotepec',1,15,1,NULL,NULL),(683,'Cuautitlán',1,15,1,NULL,NULL),(684,'Chalco',1,15,1,NULL,NULL),(685,'Chapa de Mota',1,15,1,NULL,NULL),(686,'Chapultepec',1,15,1,NULL,NULL),(687,'Chiautla',1,15,1,NULL,NULL),(688,'Chicoloapan',1,15,1,NULL,NULL),(689,'Chiconcuac',1,15,1,NULL,NULL),(690,'Chimalhuacán',1,15,1,NULL,NULL),(691,'Donato Guerra',1,15,1,NULL,NULL),(692,'Ecatepec de Morelos',1,15,1,NULL,NULL),(693,'Ecatzingo',1,15,1,NULL,NULL),(694,'Huehuetoca',1,15,1,NULL,NULL),(695,'Hueypoxtla',1,15,1,NULL,NULL),(696,'Huixquilucan',1,15,1,NULL,NULL),(697,'Isidro Fabela',1,15,1,NULL,NULL),(698,'Ixtapaluca',1,15,1,NULL,NULL),(699,'Ixtapan de la Sal',1,15,1,NULL,NULL),(700,'Ixtapan del Oro',1,15,1,NULL,NULL),(701,'Ixtlahuaca',1,15,1,NULL,NULL),(702,'Xalatlaco',1,15,1,NULL,NULL),(703,'Jaltenco',1,15,1,NULL,NULL),(705,'Jilotepec',1,15,1,NULL,NULL),(706,'Jilotzingo',1,15,1,NULL,NULL),(707,'Jiquipilco',1,15,1,NULL,NULL),(708,'Jocotitlán',1,15,1,NULL,NULL),(709,'Joquicingo',1,15,1,NULL,NULL),(710,'Juchitepec',1,15,1,NULL,NULL),(711,'Lerma',1,15,1,NULL,NULL),(712,'Malinalco',1,15,1,NULL,NULL),(713,'Melchor Ocampo',1,15,1,NULL,NULL),(714,'Metepec',1,15,1,NULL,NULL),(715,'Mexicaltzingo',1,15,1,NULL,NULL),(716,'Morelos',1,15,1,NULL,NULL),(717,'Naucalpan de Juárez',1,15,1,NULL,NULL),(718,'Nezahualcóyotl',1,15,1,NULL,NULL),(719,'Nextlalpan',1,15,1,NULL,NULL),(720,'Nicolás Romero',1,15,1,NULL,NULL),(721,'Nopaltepec',1,15,1,NULL,NULL),(722,'Ocoyoacac',1,15,1,NULL,NULL),(723,'Ocuilan',1,15,1,NULL,NULL),(724,'El Oro',1,15,1,NULL,NULL),(725,'Otumba',1,15,1,NULL,NULL),(726,'Otzoloapan',1,15,1,NULL,NULL),(727,'Otzolotepec',1,15,1,NULL,NULL),(728,'Ozumba',1,15,1,NULL,NULL),(729,'Papalotla',1,15,1,NULL,NULL),(730,'La Paz',1,15,1,NULL,NULL),(731,'Polotitlán',1,15,1,NULL,NULL),(732,'Rayón',1,15,1,NULL,NULL),(733,'San Antonio la Isla',1,15,1,NULL,NULL),(734,'San Felipe del Progreso',1,15,1,NULL,NULL),(735,'San Martín de las Pirámides',1,15,1,NULL,NULL),(736,'San Mateo Atenco',1,15,1,NULL,NULL),(737,'San Simón de Guerrero',1,15,1,NULL,NULL),(738,'Santo Tomás',1,15,1,NULL,NULL),(739,'Soyaniquilpan de Juárez',1,15,1,NULL,NULL),(740,'Sultepec',1,15,1,NULL,NULL),(741,'Tecámac',1,15,1,NULL,NULL),(742,'Tejupilco',1,15,1,NULL,NULL),(743,'Temamatla',1,15,1,NULL,NULL),(744,'Temascalapa',1,15,1,NULL,NULL),(745,'Temascalcingo',1,15,1,NULL,NULL),(746,'Temascaltepec',1,15,1,NULL,NULL),(747,'Temoaya',1,15,1,NULL,NULL),(748,'Tenancingo',1,15,1,NULL,NULL),(749,'Tenango del Aire',1,15,1,NULL,NULL),(750,'Tenango del Valle',1,15,1,NULL,NULL),(751,'Teoloyucan',1,15,1,NULL,NULL),(752,'Teotihuacán',1,15,1,NULL,NULL),(753,'Tepetlaoxtoc',1,15,1,NULL,NULL),(754,'Tepetlixpa',1,15,1,NULL,NULL),(755,'Tepotzotlán',1,15,1,NULL,NULL),(756,'Tequixquiac',1,15,1,NULL,NULL),(757,'Texcaltitlán',1,15,1,NULL,NULL),(758,'Texcalyacac',1,15,1,NULL,NULL),(759,'Texcoco',1,15,1,NULL,NULL),(760,'Tezoyuca',1,15,1,NULL,NULL),(761,'Tianguistenco',1,15,1,NULL,NULL),(762,'Timilpan',1,15,1,NULL,NULL),(763,'Tlalmanalco',1,15,1,NULL,NULL),(764,'Tlalnepantla de Baz',1,15,1,NULL,NULL),(765,'Tlatlaya',1,15,1,NULL,NULL),(766,'Toluca',1,15,1,NULL,NULL),(767,'Tonatico',1,15,1,NULL,NULL),(768,'Tultepec',1,15,1,NULL,NULL),(769,'Tultitlán',1,15,1,NULL,NULL),(770,'Valle de Bravo',1,15,1,NULL,NULL),(771,'Villa de Allende',1,15,1,NULL,NULL),(772,'Villa del Carbón',1,15,1,NULL,NULL),(773,'Villa Guerrero',1,15,1,NULL,NULL),(774,'Villa Victoria',1,15,1,NULL,NULL),(775,'Xonacatlán',1,15,1,NULL,NULL),(776,'Zacazonapan',1,15,1,NULL,NULL),(777,'Zacualpan',1,15,1,NULL,NULL),(778,'Zinacantepec',1,15,1,NULL,NULL),(779,'Zumpahuacán',1,15,1,NULL,NULL),(780,'Zumpango',1,15,1,NULL,NULL),(781,'Cuautitlán Izcalli',1,15,1,NULL,NULL),(782,'Valle de Chalco Solidaridad',1,15,1,NULL,NULL),(783,'Luvianos',1,15,1,NULL,NULL),(784,'San José del Rincón',1,15,1,NULL,NULL),(785,'Tonanitla',1,15,1,NULL,NULL),(786,'Acuitzio',1,16,1,NULL,NULL),(787,'Aguililla',1,16,1,NULL,NULL),(788,'Álvaro Obregón',1,16,1,NULL,NULL),(789,'Angamacutiro',1,16,1,NULL,NULL),(790,'Angangueo',1,16,1,NULL,NULL),(791,'Apatzingán',1,16,1,NULL,NULL),(792,'Aporo',1,16,1,NULL,NULL),(793,'Aquila',1,16,1,NULL,NULL),(794,'Ario',1,16,1,NULL,NULL),(795,'Arteaga',1,16,1,NULL,NULL),(796,'Briseñas',1,16,1,NULL,NULL),(797,'Buenavista',1,16,1,NULL,NULL),(798,'Carácuaro',1,16,1,NULL,NULL),(799,'Coahuayana',1,16,1,NULL,NULL),(800,'Coalcomán de Vázquez Pallares',1,16,1,NULL,NULL),(801,'Coeneo',1,16,1,NULL,NULL),(802,'Contepec',1,16,1,NULL,NULL),(803,'Copándaro',1,16,1,NULL,NULL),(804,'Cotija',1,16,1,NULL,NULL),(806,'Cuitzeo',1,16,1,NULL,NULL),(807,'Charapan',1,16,1,NULL,NULL),(808,'Charo',1,16,1,NULL,NULL),(809,'Chavinda',1,16,1,NULL,NULL),(810,'Cherán',1,16,1,NULL,NULL),(811,'Chilchota',1,16,1,NULL,NULL),(812,'Chinicuila',1,16,1,NULL,NULL),(813,'Chucándiro',1,16,1,NULL,NULL),(814,'Churintzio',1,16,1,NULL,NULL),(815,'Churumuco',1,16,1,NULL,NULL),(816,'Ecuandureo',1,16,1,NULL,NULL),(817,'Epitacio Huerta',1,16,1,NULL,NULL),(818,'Erongarícuaro',1,16,1,NULL,NULL),(819,'Gabriel Zamora',1,16,1,NULL,NULL),(820,'Hidalgo',1,16,1,NULL,NULL),(821,'La Huacana',1,16,1,NULL,NULL),(822,'Huandacareo',1,16,1,NULL,NULL),(823,'Huaniqueo',1,16,1,NULL,NULL),(824,'Huetamo',1,16,1,NULL,NULL),(825,'Huiramba',1,16,1,NULL,NULL),(826,'Indaparapeo',1,16,1,NULL,NULL),(827,'Irimbo',1,16,1,NULL,NULL),(828,'Ixtlán',1,16,1,NULL,NULL),(829,'Jacona',1,16,1,NULL,NULL),(830,'Jiménez',1,16,1,NULL,NULL),(831,'Jiquilpan',1,16,1,NULL,NULL),(832,'Juárez',1,16,1,NULL,NULL),(833,'Jungapeo',1,16,1,NULL,NULL),(834,'Lagunillas',1,16,1,NULL,NULL),(835,'Madero',1,16,1,NULL,NULL),(836,'Maravatío',1,16,1,NULL,NULL),(837,'Marcos Castellanos',1,16,1,NULL,NULL),(838,'Lázaro Cárdenas',1,16,1,NULL,NULL),(839,'Morelia',1,16,1,NULL,NULL),(840,'Morelos',1,16,1,NULL,NULL),(841,'Múgica',1,16,1,NULL,NULL),(842,'Nahuatzen',1,16,1,NULL,NULL),(843,'Nocupétaro',1,16,1,NULL,NULL),(844,'Nuevo Parangaricutiro',1,16,1,NULL,NULL),(845,'Nuevo Urecho',1,16,1,NULL,NULL),(846,'Numarán',1,16,1,NULL,NULL),(847,'Ocampo',1,16,1,NULL,NULL),(848,'Pajacuarán',1,16,1,NULL,NULL),(849,'Panindícuaro',1,16,1,NULL,NULL),(850,'Parácuaro',1,16,1,NULL,NULL),(851,'Paracho',1,16,1,NULL,NULL),(852,'Pátzcuaro',1,16,1,NULL,NULL),(853,'Penjamillo',1,16,1,NULL,NULL),(854,'Peribán',1,16,1,NULL,NULL),(855,'La Piedad',1,16,1,NULL,NULL),(856,'Purépero',1,16,1,NULL,NULL),(857,'Puruándiro',1,16,1,NULL,NULL),(858,'Queréndaro',1,16,1,NULL,NULL),(859,'Quiroga',1,16,1,NULL,NULL),(860,'Cojumatlán de Régules',1,16,1,NULL,NULL),(861,'Los Reyes',1,16,1,NULL,NULL),(862,'Sahuayo',1,16,1,NULL,NULL),(863,'San Lucas',1,16,1,NULL,NULL),(864,'Santa Ana Maya',1,16,1,NULL,NULL),(865,'Salvador Escalante',1,16,1,NULL,NULL),(866,'Senguio',1,16,1,NULL,NULL),(867,'Susupuato',1,16,1,NULL,NULL),(868,'Tacámbaro',1,16,1,NULL,NULL),(869,'Tancítaro',1,16,1,NULL,NULL),(870,'Tangamandapio',1,16,1,NULL,NULL),(871,'Tangancícuaro',1,16,1,NULL,NULL),(872,'Tanhuato',1,16,1,NULL,NULL),(873,'Taretan',1,16,1,NULL,NULL),(874,'Tarímbaro',1,16,1,NULL,NULL),(875,'Tepalcatepec',1,16,1,NULL,NULL),(876,'Tingambato',1,16,1,NULL,NULL),(877,'Tingüindín',1,16,1,NULL,NULL),(878,'Tiquicheo de Nicolás Romero',1,16,1,NULL,NULL),(879,'Tlalpujahua',1,16,1,NULL,NULL),(880,'Tlazazalca',1,16,1,NULL,NULL),(881,'Tocumbo',1,16,1,NULL,NULL),(882,'Tumbiscatío',1,16,1,NULL,NULL),(883,'Turicato',1,16,1,NULL,NULL),(884,'Tuxpan',1,16,1,NULL,NULL),(885,'Tuzantla',1,16,1,NULL,NULL),(886,'Tzintzuntzan',1,16,1,NULL,NULL),(887,'Tzitzio',1,16,1,NULL,NULL),(888,'Uruapan',1,16,1,NULL,NULL),(889,'Venustiano Carranza',1,16,1,NULL,NULL),(890,'Villamar',1,16,1,NULL,NULL),(891,'Vista Hermosa',1,16,1,NULL,NULL),(892,'Yurécuaro',1,16,1,NULL,NULL),(893,'Zacapu',1,16,1,NULL,NULL),(894,'Zamora',1,16,1,NULL,NULL),(895,'Zináparo',1,16,1,NULL,NULL),(896,'Zinapécuaro',1,16,1,NULL,NULL),(897,'Ziracuaretiro',1,16,1,NULL,NULL),(898,'Zitácuaro',1,16,1,NULL,NULL),(899,'José Sixto Verduzco',1,16,1,NULL,NULL),(900,'Amacuzac',1,17,1,NULL,NULL),(901,'Atlatlahucan',1,17,1,NULL,NULL),(902,'Axochiapan',1,17,1,NULL,NULL),(903,'Ayala',1,17,1,NULL,NULL),(904,'Coatlán del Río',1,17,1,NULL,NULL),(905,'Cuautla',1,17,1,NULL,NULL),(907,'Cuernavaca',1,17,1,NULL,NULL),(908,'Emiliano Zapata',1,17,1,NULL,NULL),(909,'Huitzilac',1,17,1,NULL,NULL),(910,'Jantetelco',1,17,1,NULL,NULL),(911,'Jiutepec',1,17,1,NULL,NULL),(912,'Jojutla',1,17,1,NULL,NULL),(913,'Jonacatepec',1,17,1,NULL,NULL),(914,'Mazatepec',1,17,1,NULL,NULL),(915,'Miacatlán',1,17,1,NULL,NULL),(916,'Ocuituco',1,17,1,NULL,NULL),(917,'Puente de Ixtla',1,17,1,NULL,NULL),(918,'Temixco',1,17,1,NULL,NULL),(919,'Tepalcingo',1,17,1,NULL,NULL),(920,'Tepoztlán',1,17,1,NULL,NULL),(921,'Tetecala',1,17,1,NULL,NULL),(922,'Tetela del Volcán',1,17,1,NULL,NULL),(923,'Tlalnepantla',1,17,1,NULL,NULL),(924,'Tlaltizapán de Zapata',1,17,1,NULL,NULL),(925,'Tlaquiltenango',1,17,1,NULL,NULL),(926,'Tlayacapan',1,17,1,NULL,NULL),(927,'Totolapan',1,17,1,NULL,NULL),(928,'Xochitepec',1,17,1,NULL,NULL),(929,'Yautepec',1,17,1,NULL,NULL),(930,'Yecapixtla',1,17,1,NULL,NULL),(931,'Zacatepec',1,17,1,NULL,NULL),(932,'Zacualpan de Amilpas',1,17,1,NULL,NULL),(933,'Temoac',1,17,1,NULL,NULL),(934,'Acaponeta',1,18,1,NULL,NULL),(935,'Ahuacatlán',1,18,1,NULL,NULL),(936,'Amatlán de Cañas',1,18,1,NULL,NULL),(937,'Compostela',1,18,1,NULL,NULL),(938,'Huajicori',1,18,1,NULL,NULL),(939,'Ixtlán del Río',1,18,1,NULL,NULL),(940,'Jala',1,18,1,NULL,NULL),(941,'Xalisco',1,18,1,NULL,NULL),(942,'Del Nayar',1,18,1,NULL,NULL),(943,'Rosamorada',1,18,1,NULL,NULL),(944,'Ruíz',1,18,1,NULL,NULL),(945,'San Blas',1,18,1,NULL,NULL),(946,'San Pedro Lagunillas',1,18,1,NULL,NULL),(947,'Santa María del Oro',1,18,1,NULL,NULL),(948,'Santiago Ixcuintla',1,18,1,NULL,NULL),(949,'Tecuala',1,18,1,NULL,NULL),(950,'Tepic',1,18,1,NULL,NULL),(951,'Tuxpan',1,18,1,NULL,NULL),(952,'La Yesca',1,18,1,NULL,NULL),(953,'Bahía de Banderas',1,18,1,NULL,NULL),(954,'Abasolo',1,19,1,NULL,NULL),(955,'Agualeguas',1,19,1,NULL,NULL),(956,'Los Aldamas',1,19,1,NULL,NULL),(957,'Allende',1,19,1,NULL,NULL),(958,'Anáhuac',1,19,1,NULL,NULL),(959,'Apodaca',1,19,1,NULL,NULL),(960,'Aramberri',1,19,1,NULL,NULL),(961,'Bustamante',1,19,1,NULL,NULL),(962,'Cadereyta Jiménez',1,19,1,NULL,NULL),(963,'El Carmen',1,19,1,NULL,NULL),(964,'Cerralvo',1,19,1,NULL,NULL),(965,'Ciénega de Flores',1,19,1,NULL,NULL),(966,'China',1,19,1,NULL,NULL),(967,'Doctor Arroyo',1,19,1,NULL,NULL),(968,'Doctor Coss',1,19,1,NULL,NULL),(969,'Doctor González',1,19,1,NULL,NULL),(970,'Galeana',1,19,1,NULL,NULL),(971,'García',1,19,1,NULL,NULL),(972,'San Pedro Garza García',1,19,1,NULL,NULL),(973,'General Bravo',1,19,1,NULL,NULL),(974,'General Escobedo',1,19,1,NULL,NULL),(975,'General Terán',1,19,1,NULL,NULL),(976,'General Treviño',1,19,1,NULL,NULL),(977,'General Zaragoza',1,19,1,NULL,NULL),(978,'General Zuazua',1,19,1,NULL,NULL),(979,'Guadalupe',1,19,1,NULL,NULL),(980,'Los Herreras',1,19,1,NULL,NULL),(981,'Higueras',1,19,1,NULL,NULL),(982,'Hualahuises',1,19,1,NULL,NULL),(983,'Iturbide',1,19,1,NULL,NULL),(984,'Juárez',1,19,1,NULL,NULL),(985,'Lampazos de Naranjo',1,19,1,NULL,NULL),(986,'Linares',1,19,1,NULL,NULL),(987,'Marín',1,19,1,NULL,NULL),(988,'Melchor Ocampo',1,19,1,NULL,NULL),(989,'Mier y Noriega',1,19,1,NULL,NULL),(990,'Mina',1,19,1,NULL,NULL),(991,'Montemorelos',1,19,1,NULL,NULL),(992,'Monterrey',1,19,1,NULL,NULL),(993,'Parás',1,19,1,NULL,NULL),(994,'Pesquería',1,19,1,NULL,NULL),(995,'Los Ramones',1,19,1,NULL,NULL),(996,'Rayones',1,19,1,NULL,NULL),(997,'Sabinas Hidalgo',1,19,1,NULL,NULL),(998,'Salinas Victoria',1,19,1,NULL,NULL),(999,'San Nicolás de los Garza',1,19,1,NULL,NULL),(1000,'Hidalgo',1,19,1,NULL,NULL),(1001,'Santa Catarina',1,19,1,NULL,NULL),(1002,'Santiago',1,19,1,NULL,NULL),(1003,'Vallecillo',1,19,1,NULL,NULL),(1004,'Villaldama',1,19,1,NULL,NULL),(1005,'Abejones',1,20,1,NULL,NULL),(1006,'Acatlán de Pérez Figueroa',1,20,1,NULL,NULL),(1007,'Asunción Cacalotepec',1,20,1,NULL,NULL),(1008,'Asunción Cuyotepeji',1,20,1,NULL,NULL),(1009,'Asunción Ixtaltepec',1,20,1,NULL,NULL),(1010,'Asunción Nochixtlán',1,20,1,NULL,NULL),(1011,'Asunción Ocotlán',1,20,1,NULL,NULL),(1012,'Asunción Tlacolulita',1,20,1,NULL,NULL),(1013,'Ayotzintepec',1,20,1,NULL,NULL),(1014,'El Barrio de la Soledad',1,20,1,NULL,NULL),(1015,'Calihualá',1,20,1,NULL,NULL),(1016,'Candelaria Loxicha',1,20,1,NULL,NULL),(1017,'Ciénega de Zimatlán',1,20,1,NULL,NULL),(1018,'Ciudad Ixtepec',1,20,1,NULL,NULL),(1019,'Coatecas Altas',1,20,1,NULL,NULL),(1020,'Coicoyán de las Flores',1,20,1,NULL,NULL),(1021,'La Compañía',1,20,1,NULL,NULL),(1022,'Concepción Buenavista',1,20,1,NULL,NULL),(1023,'Concepción Pápalo',1,20,1,NULL,NULL),(1024,'Constancia del Rosario',1,20,1,NULL,NULL),(1025,'Cosolapa',1,20,1,NULL,NULL),(1026,'Cosoltepec',1,20,1,NULL,NULL),(1027,'Cuilápam de Guerrero',1,20,1,NULL,NULL),(1028,'Cuyamecalco Villa de Zaragoza',1,20,1,NULL,NULL),(1029,'Chahuites',1,20,1,NULL,NULL),(1030,'Chalcatongo de Hidalgo',1,20,1,NULL,NULL),(1031,'Chiquihuitlán de Benito Juárez',1,20,1,NULL,NULL),(1032,'Heroica Ciudad de Ejutla de Crespo',1,20,1,NULL,NULL),(1033,'Eloxochitlán de Flores Magón',1,20,1,NULL,NULL),(1034,'El Espinal',1,20,1,NULL,NULL),(1035,'Tamazulápam del Espíritu Santo',1,20,1,NULL,NULL),(1036,'Fresnillo de Trujano',1,20,1,NULL,NULL),(1037,'Guadalupe Etla',1,20,1,NULL,NULL),(1038,'Guadalupe de Ramírez',1,20,1,NULL,NULL),(1039,'Guelatao de Juárez',1,20,1,NULL,NULL),(1040,'Guevea de Humboldt',1,20,1,NULL,NULL),(1041,'Mesones Hidalgo',1,20,1,NULL,NULL),(1042,'Villa Hidalgo',1,20,1,NULL,NULL),(1043,'Heroica Ciudad de Huajuapan de León',1,20,1,NULL,NULL),(1044,'Huautepec',1,20,1,NULL,NULL),(1045,'Huautla de Jiménez',1,20,1,NULL,NULL),(1046,'Ixtlán de Juárez',1,20,1,NULL,NULL),(1047,'Heroica Ciudad de Juchitán de Zaragoza',1,20,1,NULL,NULL),(1048,'Loma Bonita',1,20,1,NULL,NULL),(1049,'Magdalena Apasco',1,20,1,NULL,NULL),(1050,'Magdalena Jaltepec',1,20,1,NULL,NULL),(1051,'Santa Magdalena Jicotlán',1,20,1,NULL,NULL),(1052,'Magdalena Mixtepec',1,20,1,NULL,NULL),(1053,'Magdalena Ocotlán',1,20,1,NULL,NULL),(1054,'Magdalena Peñasco',1,20,1,NULL,NULL),(1055,'Magdalena Teitipac',1,20,1,NULL,NULL),(1056,'Magdalena Tequisistlán',1,20,1,NULL,NULL),(1057,'Magdalena Tlacotepec',1,20,1,NULL,NULL),(1058,'Magdalena Zahuatlán',1,20,1,NULL,NULL),(1059,'Mariscala de Juárez',1,20,1,NULL,NULL),(1060,'Mártires de Tacubaya',1,20,1,NULL,NULL),(1061,'Matías Romero Avendaño',1,20,1,NULL,NULL),(1062,'Mazatlán Villa de Flores',1,20,1,NULL,NULL),(1063,'Miahuatlán de Porfirio Díaz',1,20,1,NULL,NULL),(1064,'Mixistlán de la Reforma',1,20,1,NULL,NULL),(1065,'Monjas',1,20,1,NULL,NULL),(1066,'Natividad',1,20,1,NULL,NULL),(1067,'Nazareno Etla',1,20,1,NULL,NULL),(1068,'Nejapa de Madero',1,20,1,NULL,NULL),(1069,'Ixpantepec Nieves',1,20,1,NULL,NULL),(1070,'Santiago Niltepec',1,20,1,NULL,NULL),(1071,'Oaxaca de Juárez',1,20,1,NULL,NULL),(1072,'Ocotlán de Morelos',1,20,1,NULL,NULL),(1073,'La Pe',1,20,1,NULL,NULL),(1074,'Pinotepa de Don Luis',1,20,1,NULL,NULL),(1075,'Pluma Hidalgo',1,20,1,NULL,NULL),(1076,'San José del Progreso',1,20,1,NULL,NULL),(1077,'Putla Villa de Guerrero',1,20,1,NULL,NULL),(1078,'Santa Catarina Quioquitani',1,20,1,NULL,NULL),(1079,'Reforma de Pineda',1,20,1,NULL,NULL),(1080,'La Reforma',1,20,1,NULL,NULL),(1081,'Reyes Etla',1,20,1,NULL,NULL),(1082,'Rojas de Cuauhtémoc',1,20,1,NULL,NULL),(1083,'Salina Cruz',1,20,1,NULL,NULL),(1084,'San Agustín Amatengo',1,20,1,NULL,NULL),(1085,'San Agustín Atenango',1,20,1,NULL,NULL),(1086,'San Agustín Chayuco',1,20,1,NULL,NULL),(1087,'San Agustín de las Juntas',1,20,1,NULL,NULL),(1088,'San Agustín Etla',1,20,1,NULL,NULL),(1089,'San Agustín Loxicha',1,20,1,NULL,NULL),(1090,'San Agustín Tlacotepec',1,20,1,NULL,NULL),(1091,'San Agustín Yatareni',1,20,1,NULL,NULL),(1092,'San Andrés Cabecera Nueva',1,20,1,NULL,NULL),(1093,'San Andrés Dinicuiti',1,20,1,NULL,NULL),(1094,'San Andrés Huaxpaltepec',1,20,1,NULL,NULL),(1095,'San Andrés Huayápam',1,20,1,NULL,NULL),(1096,'San Andrés Ixtlahuaca',1,20,1,NULL,NULL),(1097,'San Andrés Lagunas',1,20,1,NULL,NULL),(1098,'San Andrés Nuxiño',1,20,1,NULL,NULL),(1099,'San Andrés Paxtlán',1,20,1,NULL,NULL),(1100,'San Andrés Sinaxtla',1,20,1,NULL,NULL),(1101,'San Andrés Solaga',1,20,1,NULL,NULL),(1102,'San Andrés Teotilálpam',1,20,1,NULL,NULL),(1103,'San Andrés Tepetlapa',1,20,1,NULL,NULL),(1104,'San Andrés Yaá',1,20,1,NULL,NULL),(1105,'San Andrés Zabache',1,20,1,NULL,NULL),(1106,'San Andrés Zautla',1,20,1,NULL,NULL),(1108,'San Antonino Castillo Velasco',1,20,1,NULL,NULL),(1109,'San Antonino el Alto',1,20,1,NULL,NULL),(1110,'San Antonino Monte Verde',1,20,1,NULL,NULL),(1111,'San Antonio Acutla',1,20,1,NULL,NULL),(1112,'San Antonio de la Cal',1,20,1,NULL,NULL),(1113,'San Antonio Huitepec',1,20,1,NULL,NULL),(1114,'San Antonio Nanahuatípam',1,20,1,NULL,NULL),(1115,'San Antonio Sinicahua',1,20,1,NULL,NULL),(1116,'San Antonio Tepetlapa',1,20,1,NULL,NULL),(1117,'San Baltazar Chichicápam',1,20,1,NULL,NULL),(1118,'San Baltazar Loxicha',1,20,1,NULL,NULL),(1119,'San Baltazar Yatzachi el Bajo',1,20,1,NULL,NULL),(1120,'San Bartolo Coyotepec',1,20,1,NULL,NULL),(1121,'San Bartolomé Ayautla',1,20,1,NULL,NULL),(1122,'San Bartolomé Loxicha',1,20,1,NULL,NULL),(1123,'San Bartolomé Quialana',1,20,1,NULL,NULL),(1124,'San Bartolomé Yucuañe',1,20,1,NULL,NULL),(1125,'San Bartolomé Zoogocho',1,20,1,NULL,NULL),(1126,'San Bartolo Soyaltepec',1,20,1,NULL,NULL),(1127,'San Bartolo Yautepec',1,20,1,NULL,NULL),(1128,'San Bernardo Mixtepec',1,20,1,NULL,NULL),(1129,'San Blas Atempa',1,20,1,NULL,NULL),(1130,'San Carlos Yautepec',1,20,1,NULL,NULL),(1131,'San Cristóbal Amatlán',1,20,1,NULL,NULL),(1132,'San Cristóbal Amoltepec',1,20,1,NULL,NULL),(1133,'San Cristóbal Lachirioag',1,20,1,NULL,NULL),(1134,'San Cristóbal Suchixtlahuaca',1,20,1,NULL,NULL),(1135,'San Dionisio del Mar',1,20,1,NULL,NULL),(1136,'San Dionisio Ocotepec',1,20,1,NULL,NULL),(1137,'San Dionisio Ocotlán',1,20,1,NULL,NULL),(1138,'San Esteban Atatlahuca',1,20,1,NULL,NULL),(1139,'San Felipe Jalapa de Díaz',1,20,1,NULL,NULL),(1140,'San Felipe Tejalápam',1,20,1,NULL,NULL),(1141,'San Felipe Usila',1,20,1,NULL,NULL),(1142,'San Francisco Cahuacuá',1,20,1,NULL,NULL),(1143,'San Francisco Cajonos',1,20,1,NULL,NULL),(1144,'San Francisco Chapulapa',1,20,1,NULL,NULL),(1145,'San Francisco Chindúa',1,20,1,NULL,NULL),(1146,'San Francisco del Mar',1,20,1,NULL,NULL),(1147,'San Francisco Huehuetlán',1,20,1,NULL,NULL),(1148,'San Francisco Ixhuatán',1,20,1,NULL,NULL),(1149,'San Francisco Jaltepetongo',1,20,1,NULL,NULL),(1150,'San Francisco Lachigoló',1,20,1,NULL,NULL),(1151,'San Francisco Logueche',1,20,1,NULL,NULL),(1152,'San Francisco Nuxaño',1,20,1,NULL,NULL),(1153,'San Francisco Ozolotepec',1,20,1,NULL,NULL),(1154,'San Francisco Sola',1,20,1,NULL,NULL),(1155,'San Francisco Telixtlahuaca',1,20,1,NULL,NULL),(1156,'San Francisco Teopan',1,20,1,NULL,NULL),(1157,'San Francisco Tlapancingo',1,20,1,NULL,NULL),(1158,'San Gabriel Mixtepec',1,20,1,NULL,NULL),(1159,'San Ildefonso Amatlán',1,20,1,NULL,NULL),(1160,'San Ildefonso Sola',1,20,1,NULL,NULL),(1161,'San Ildefonso Villa Alta',1,20,1,NULL,NULL),(1162,'San Jacinto Amilpas',1,20,1,NULL,NULL),(1163,'San Jacinto Tlacotepec',1,20,1,NULL,NULL),(1164,'San Jerónimo Coatlán',1,20,1,NULL,NULL),(1165,'San Jerónimo Silacayoapilla',1,20,1,NULL,NULL),(1166,'San Jerónimo Sosola',1,20,1,NULL,NULL),(1167,'San Jerónimo Taviche',1,20,1,NULL,NULL),(1168,'San Jerónimo Tecóatl',1,20,1,NULL,NULL),(1169,'San Jorge Nuchita',1,20,1,NULL,NULL),(1170,'San José Ayuquila',1,20,1,NULL,NULL),(1171,'San José Chiltepec',1,20,1,NULL,NULL),(1172,'San José del Peñasco',1,20,1,NULL,NULL),(1173,'San José Estancia Grande',1,20,1,NULL,NULL),(1174,'San José Independencia',1,20,1,NULL,NULL),(1175,'San José Lachiguiri',1,20,1,NULL,NULL),(1176,'San José Tenango',1,20,1,NULL,NULL),(1177,'San Juan Achiutla',1,20,1,NULL,NULL),(1178,'San Juan Atepec',1,20,1,NULL,NULL),(1179,'Ánimas Trujano',1,20,1,NULL,NULL),(1180,'San Juan Bautista Atatlahuca',1,20,1,NULL,NULL),(1181,'San Juan Bautista Coixtlahuaca',1,20,1,NULL,NULL),(1182,'San Juan Bautista Cuicatlán',1,20,1,NULL,NULL),(1183,'San Juan Bautista Guelache',1,20,1,NULL,NULL),(1184,'San Juan Bautista Jayacatlán',1,20,1,NULL,NULL),(1185,'San Juan Bautista Lo de Soto',1,20,1,NULL,NULL),(1186,'San Juan Bautista Suchitepec',1,20,1,NULL,NULL),(1187,'San Juan Bautista Tlacoatzintepec',1,20,1,NULL,NULL),(1188,'San Juan Bautista Tlachichilco',1,20,1,NULL,NULL),(1189,'San Juan Bautista Tuxtepec',1,20,1,NULL,NULL),(1190,'San Juan Cacahuatepec',1,20,1,NULL,NULL),(1191,'San Juan Cieneguilla',1,20,1,NULL,NULL),(1192,'San Juan Coatzóspam',1,20,1,NULL,NULL),(1193,'San Juan Colorado',1,20,1,NULL,NULL),(1194,'San Juan Comaltepec',1,20,1,NULL,NULL),(1195,'San Juan Cotzocón',1,20,1,NULL,NULL),(1196,'San Juan Chicomezúchil',1,20,1,NULL,NULL),(1197,'San Juan Chilateca',1,20,1,NULL,NULL),(1198,'San Juan del Estado',1,20,1,NULL,NULL),(1199,'San Juan del Río',1,20,1,NULL,NULL),(1200,'San Juan Diuxi',1,20,1,NULL,NULL),(1201,'San Juan Evangelista Analco',1,20,1,NULL,NULL),(1202,'San Juan Guelavía',1,20,1,NULL,NULL),(1203,'San Juan Guichicovi',1,20,1,NULL,NULL),(1204,'San Juan Ihualtepec',1,20,1,NULL,NULL),(1205,'San Juan Juquila Mixes',1,20,1,NULL,NULL),(1206,'San Juan Juquila Vijanos',1,20,1,NULL,NULL),(1207,'San Juan Lachao',1,20,1,NULL,NULL),(1209,'San Juan Lachigalla',1,20,1,NULL,NULL),(1210,'San Juan Lajarcia',1,20,1,NULL,NULL),(1211,'San Juan Lalana',1,20,1,NULL,NULL),(1212,'San Juan de los Cués',1,20,1,NULL,NULL),(1213,'San Juan Mazatlán',1,20,1,NULL,NULL),(1214,'San Juan Mixtepec',1,20,1,NULL,NULL),(1215,'San Juan Mixtepec',1,20,1,NULL,NULL),(1216,'San Juan Ñumí',1,20,1,NULL,NULL),(1217,'San Juan Ozolotepec',1,20,1,NULL,NULL),(1218,'San Juan Petlapa',1,20,1,NULL,NULL),(1219,'San Juan Quiahije',1,20,1,NULL,NULL),(1220,'San Juan Quiotepec',1,20,1,NULL,NULL),(1221,'San Juan Sayultepec',1,20,1,NULL,NULL),(1222,'San Juan Tabaá',1,20,1,NULL,NULL),(1223,'San Juan Tamazola',1,20,1,NULL,NULL),(1224,'San Juan Teita',1,20,1,NULL,NULL),(1225,'San Juan Teitipac',1,20,1,NULL,NULL),(1226,'San Juan Tepeuxila',1,20,1,NULL,NULL),(1227,'San Juan Teposcolula',1,20,1,NULL,NULL),(1228,'San Juan Yaeé',1,20,1,NULL,NULL),(1229,'San Juan Yatzona',1,20,1,NULL,NULL),(1230,'San Juan Yucuita',1,20,1,NULL,NULL),(1231,'San Lorenzo',1,20,1,NULL,NULL),(1232,'San Lorenzo Albarradas',1,20,1,NULL,NULL),(1233,'San Lorenzo Cacaotepec',1,20,1,NULL,NULL),(1234,'San Lorenzo Cuaunecuiltitla',1,20,1,NULL,NULL),(1235,'San Lorenzo Texmelúcan',1,20,1,NULL,NULL),(1236,'San Lorenzo Victoria',1,20,1,NULL,NULL),(1237,'San Lucas Camotlán',1,20,1,NULL,NULL),(1238,'San Lucas Ojitlán',1,20,1,NULL,NULL),(1239,'San Lucas Quiaviní',1,20,1,NULL,NULL),(1240,'San Lucas Zoquiápam',1,20,1,NULL,NULL),(1241,'San Luis Amatlán',1,20,1,NULL,NULL),(1242,'San Marcial Ozolotepec',1,20,1,NULL,NULL),(1243,'San Marcos Arteaga',1,20,1,NULL,NULL),(1244,'San Martín de los Cansecos',1,20,1,NULL,NULL),(1245,'San Martín Huamelúlpam',1,20,1,NULL,NULL),(1246,'San Martín Itunyoso',1,20,1,NULL,NULL),(1247,'San Martín Lachilá',1,20,1,NULL,NULL),(1248,'San Martín Peras',1,20,1,NULL,NULL),(1249,'San Martín Tilcajete',1,20,1,NULL,NULL),(1250,'San Martín Toxpalan',1,20,1,NULL,NULL),(1251,'San Martín Zacatepec',1,20,1,NULL,NULL),(1252,'San Mateo Cajonos',1,20,1,NULL,NULL),(1253,'Capulálpam de Méndez',1,20,1,NULL,NULL),(1254,'San Mateo del Mar',1,20,1,NULL,NULL),(1255,'San Mateo Yoloxochitlán',1,20,1,NULL,NULL),(1256,'San Mateo Etlatongo',1,20,1,NULL,NULL),(1257,'San Mateo Nejápam',1,20,1,NULL,NULL),(1258,'San Mateo Peñasco',1,20,1,NULL,NULL),(1259,'San Mateo Piñas',1,20,1,NULL,NULL),(1260,'San Mateo Río Hondo',1,20,1,NULL,NULL),(1261,'San Mateo Sindihui',1,20,1,NULL,NULL),(1262,'San Mateo Tlapiltepec',1,20,1,NULL,NULL),(1263,'San Melchor Betaza',1,20,1,NULL,NULL),(1264,'San Miguel Achiutla',1,20,1,NULL,NULL),(1265,'San Miguel Ahuehuetitlán',1,20,1,NULL,NULL),(1266,'San Miguel Aloápam',1,20,1,NULL,NULL),(1267,'San Miguel Amatitlán',1,20,1,NULL,NULL),(1268,'San Miguel Amatlán',1,20,1,NULL,NULL),(1269,'San Miguel Coatlán',1,20,1,NULL,NULL),(1270,'San Miguel Chicahua',1,20,1,NULL,NULL),(1271,'San Miguel Chimalapa',1,20,1,NULL,NULL),(1272,'San Miguel del Puerto',1,20,1,NULL,NULL),(1273,'San Miguel del Río',1,20,1,NULL,NULL),(1274,'San Miguel Ejutla',1,20,1,NULL,NULL),(1275,'San Miguel el Grande',1,20,1,NULL,NULL),(1276,'San Miguel Huautla',1,20,1,NULL,NULL),(1277,'San Miguel Mixtepec',1,20,1,NULL,NULL),(1278,'San Miguel Panixtlahuaca',1,20,1,NULL,NULL),(1279,'San Miguel Peras',1,20,1,NULL,NULL),(1280,'San Miguel Piedras',1,20,1,NULL,NULL),(1281,'San Miguel Quetzaltepec',1,20,1,NULL,NULL),(1282,'San Miguel Santa Flor',1,20,1,NULL,NULL),(1283,'Villa Sola de Vega',1,20,1,NULL,NULL),(1284,'San Miguel Soyaltepec',1,20,1,NULL,NULL),(1285,'San Miguel Suchixtepec',1,20,1,NULL,NULL),(1286,'Villa Talea de Castro',1,20,1,NULL,NULL),(1287,'San Miguel Tecomatlán',1,20,1,NULL,NULL),(1288,'San Miguel Tenango',1,20,1,NULL,NULL),(1289,'San Miguel Tequixtepec',1,20,1,NULL,NULL),(1290,'San Miguel Tilquiápam',1,20,1,NULL,NULL),(1291,'San Miguel Tlacamama',1,20,1,NULL,NULL),(1292,'San Miguel Tlacotepec',1,20,1,NULL,NULL),(1293,'San Miguel Tulancingo',1,20,1,NULL,NULL),(1294,'San Miguel Yotao',1,20,1,NULL,NULL),(1295,'San Nicolás',1,20,1,NULL,NULL),(1296,'San Nicolás Hidalgo',1,20,1,NULL,NULL),(1297,'San Pablo Coatlán',1,20,1,NULL,NULL),(1298,'San Pablo Cuatro Venados',1,20,1,NULL,NULL),(1299,'San Pablo Etla',1,20,1,NULL,NULL),(1300,'San Pablo Huitzo',1,20,1,NULL,NULL),(1301,'San Pablo Huixtepec',1,20,1,NULL,NULL),(1302,'San Pablo Macuiltianguis',1,20,1,NULL,NULL),(1303,'San Pablo Tijaltepec',1,20,1,NULL,NULL),(1304,'San Pablo Villa de Mitla',1,20,1,NULL,NULL),(1305,'San Pablo Yaganiza',1,20,1,NULL,NULL),(1306,'San Pedro Amuzgos',1,20,1,NULL,NULL),(1307,'San Pedro Apóstol',1,20,1,NULL,NULL),(1308,'San Pedro Atoyac',1,20,1,NULL,NULL),(1310,'San Pedro Cajonos',1,20,1,NULL,NULL),(1311,'San Pedro Coxcaltepec Cántaros',1,20,1,NULL,NULL),(1312,'San Pedro Comitancillo',1,20,1,NULL,NULL),(1313,'San Pedro el Alto',1,20,1,NULL,NULL),(1314,'San Pedro Huamelula',1,20,1,NULL,NULL),(1315,'San Pedro Huilotepec',1,20,1,NULL,NULL),(1316,'San Pedro Ixcatlán',1,20,1,NULL,NULL),(1317,'San Pedro Ixtlahuaca',1,20,1,NULL,NULL),(1318,'San Pedro Jaltepetongo',1,20,1,NULL,NULL),(1319,'San Pedro Jicayán',1,20,1,NULL,NULL),(1320,'San Pedro Jocotipac',1,20,1,NULL,NULL),(1321,'San Pedro Juchatengo',1,20,1,NULL,NULL),(1322,'San Pedro Mártir',1,20,1,NULL,NULL),(1323,'San Pedro Mártir Quiechapa',1,20,1,NULL,NULL),(1324,'San Pedro Mártir Yucuxaco',1,20,1,NULL,NULL),(1325,'San Pedro Mixtepec',1,20,1,NULL,NULL),(1326,'San Pedro Mixtepec',1,20,1,NULL,NULL),(1327,'San Pedro Molinos',1,20,1,NULL,NULL),(1328,'San Pedro Nopala',1,20,1,NULL,NULL),(1329,'San Pedro Ocopetatillo',1,20,1,NULL,NULL),(1330,'San Pedro Ocotepec',1,20,1,NULL,NULL),(1331,'San Pedro Pochutla',1,20,1,NULL,NULL),(1332,'San Pedro Quiatoni',1,20,1,NULL,NULL),(1333,'San Pedro Sochiápam',1,20,1,NULL,NULL),(1334,'San Pedro Tapanatepec',1,20,1,NULL,NULL),(1335,'San Pedro Taviche',1,20,1,NULL,NULL),(1336,'San Pedro Teozacoalco',1,20,1,NULL,NULL),(1337,'San Pedro Teutila',1,20,1,NULL,NULL),(1338,'San Pedro Tidaá',1,20,1,NULL,NULL),(1339,'San Pedro Topiltepec',1,20,1,NULL,NULL),(1340,'San Pedro Totolápam',1,20,1,NULL,NULL),(1341,'Villa de Tututepec de Melchor Ocampo',1,20,1,NULL,NULL),(1342,'San Pedro Yaneri',1,20,1,NULL,NULL),(1343,'San Pedro Yólox',1,20,1,NULL,NULL),(1344,'San Pedro y San Pablo Ayutla',1,20,1,NULL,NULL),(1345,'Villa de Etla',1,20,1,NULL,NULL),(1346,'San Pedro y San Pablo Teposcolula',1,20,1,NULL,NULL),(1347,'San Pedro y San Pablo Tequixtepec',1,20,1,NULL,NULL),(1348,'San Pedro Yucunama',1,20,1,NULL,NULL),(1349,'San Raymundo Jalpan',1,20,1,NULL,NULL),(1350,'San Sebastián Abasolo',1,20,1,NULL,NULL),(1351,'San Sebastián Coatlán',1,20,1,NULL,NULL),(1352,'San Sebastián Ixcapa',1,20,1,NULL,NULL),(1353,'San Sebastián Nicananduta',1,20,1,NULL,NULL),(1354,'San Sebastián Río Hondo',1,20,1,NULL,NULL),(1355,'San Sebastián Tecomaxtlahuaca',1,20,1,NULL,NULL),(1356,'San Sebastián Teitipac',1,20,1,NULL,NULL),(1357,'San Sebastián Tutla',1,20,1,NULL,NULL),(1358,'San Simón Almolongas',1,20,1,NULL,NULL),(1359,'San Simón Zahuatlán',1,20,1,NULL,NULL),(1360,'Santa Ana',1,20,1,NULL,NULL),(1361,'Santa Ana Ateixtlahuaca',1,20,1,NULL,NULL),(1362,'Santa Ana Cuauhtémoc',1,20,1,NULL,NULL),(1363,'Santa Ana del Valle',1,20,1,NULL,NULL),(1364,'Santa Ana Tavela',1,20,1,NULL,NULL),(1365,'Santa Ana Tlapacoyan',1,20,1,NULL,NULL),(1366,'Santa Ana Yareni',1,20,1,NULL,NULL),(1367,'Santa Ana Zegache',1,20,1,NULL,NULL),(1368,'Santa Catalina Quierí',1,20,1,NULL,NULL),(1369,'Santa Catarina Cuixtla',1,20,1,NULL,NULL),(1370,'Santa Catarina Ixtepeji',1,20,1,NULL,NULL),(1371,'Santa Catarina Juquila',1,20,1,NULL,NULL),(1372,'Santa Catarina Lachatao',1,20,1,NULL,NULL),(1373,'Santa Catarina Loxicha',1,20,1,NULL,NULL),(1374,'Santa Catarina Mechoacán',1,20,1,NULL,NULL),(1375,'Santa Catarina Minas',1,20,1,NULL,NULL),(1376,'Santa Catarina Quiané',1,20,1,NULL,NULL),(1377,'Santa Catarina Tayata',1,20,1,NULL,NULL),(1378,'Santa Catarina Ticuá',1,20,1,NULL,NULL),(1379,'Santa Catarina Yosonotú',1,20,1,NULL,NULL),(1380,'Santa Catarina Zapoquila',1,20,1,NULL,NULL),(1381,'Santa Cruz Acatepec',1,20,1,NULL,NULL),(1382,'Santa Cruz Amilpas',1,20,1,NULL,NULL),(1383,'Santa Cruz de Bravo',1,20,1,NULL,NULL),(1384,'Santa Cruz Itundujia',1,20,1,NULL,NULL),(1385,'Santa Cruz Mixtepec',1,20,1,NULL,NULL),(1386,'Santa Cruz Nundaco',1,20,1,NULL,NULL),(1387,'Santa Cruz Papalutla',1,20,1,NULL,NULL),(1388,'Santa Cruz Tacache de Mina',1,20,1,NULL,NULL),(1389,'Santa Cruz Tacahua',1,20,1,NULL,NULL),(1390,'Santa Cruz Tayata',1,20,1,NULL,NULL),(1391,'Santa Cruz Xitla',1,20,1,NULL,NULL),(1392,'Santa Cruz Xoxocotlán',1,20,1,NULL,NULL),(1393,'Santa Cruz Zenzontepec',1,20,1,NULL,NULL),(1394,'Santa Gertrudis',1,20,1,NULL,NULL),(1395,'Santa Inés del Monte',1,20,1,NULL,NULL),(1396,'Santa Inés Yatzeche',1,20,1,NULL,NULL),(1397,'Santa Lucía del Camino',1,20,1,NULL,NULL),(1398,'Santa Lucía Miahuatlán',1,20,1,NULL,NULL),(1399,'Santa Lucía Monteverde',1,20,1,NULL,NULL),(1400,'Santa Lucía Ocotlán',1,20,1,NULL,NULL),(1401,'Santa María Alotepec',1,20,1,NULL,NULL),(1402,'Santa María Apazco',1,20,1,NULL,NULL),(1403,'Santa María la Asunción',1,20,1,NULL,NULL),(1404,'Heroica Ciudad de Tlaxiaco',1,20,1,NULL,NULL),(1405,'Ayoquezco de Aldama',1,20,1,NULL,NULL),(1406,'Santa María Atzompa',1,20,1,NULL,NULL),(1407,'Santa María Camotlán',1,20,1,NULL,NULL),(1408,'Santa María Colotepec',1,20,1,NULL,NULL),(1409,'Santa María Cortijo',1,20,1,NULL,NULL),(1411,'Santa María Coyotepec',1,20,1,NULL,NULL),(1412,'Santa María Chachoápam',1,20,1,NULL,NULL),(1413,'Villa de Chilapa de Díaz',1,20,1,NULL,NULL),(1414,'Santa María Chilchotla',1,20,1,NULL,NULL),(1415,'Santa María Chimalapa',1,20,1,NULL,NULL),(1416,'Santa María del Rosario',1,20,1,NULL,NULL),(1417,'Santa María del Tule',1,20,1,NULL,NULL),(1418,'Santa María Ecatepec',1,20,1,NULL,NULL),(1419,'Santa María Guelacé',1,20,1,NULL,NULL),(1420,'Santa María Guienagati',1,20,1,NULL,NULL),(1421,'Santa María Huatulco',1,20,1,NULL,NULL),(1422,'Santa María Huazolotitlán',1,20,1,NULL,NULL),(1423,'Santa María Ipalapa',1,20,1,NULL,NULL),(1424,'Santa María Ixcatlán',1,20,1,NULL,NULL),(1425,'Santa María Jacatepec',1,20,1,NULL,NULL),(1426,'Santa María Jalapa del Marqués',1,20,1,NULL,NULL),(1427,'Santa María Jaltianguis',1,20,1,NULL,NULL),(1428,'Santa María Lachixío',1,20,1,NULL,NULL),(1429,'Santa María Mixtequilla',1,20,1,NULL,NULL),(1430,'Santa María Nativitas',1,20,1,NULL,NULL),(1431,'Santa María Nduayaco',1,20,1,NULL,NULL),(1432,'Santa María Ozolotepec',1,20,1,NULL,NULL),(1433,'Santa María Pápalo',1,20,1,NULL,NULL),(1434,'Santa María Peñoles',1,20,1,NULL,NULL),(1435,'Santa María Petapa',1,20,1,NULL,NULL),(1436,'Santa María Quiegolani',1,20,1,NULL,NULL),(1437,'Santa María Sola',1,20,1,NULL,NULL),(1438,'Santa María Tataltepec',1,20,1,NULL,NULL),(1439,'Santa María Tecomavaca',1,20,1,NULL,NULL),(1440,'Santa María Temaxcalapa',1,20,1,NULL,NULL),(1441,'Santa María Temaxcaltepec',1,20,1,NULL,NULL),(1442,'Santa María Teopoxco',1,20,1,NULL,NULL),(1443,'Santa María Tepantlali',1,20,1,NULL,NULL),(1444,'Santa María Texcatitlán',1,20,1,NULL,NULL),(1445,'Santa María Tlahuitoltepec',1,20,1,NULL,NULL),(1446,'Santa María Tlalixtac',1,20,1,NULL,NULL),(1447,'Santa María Tonameca',1,20,1,NULL,NULL),(1448,'Santa María Totolapilla',1,20,1,NULL,NULL),(1449,'Santa María Xadani',1,20,1,NULL,NULL),(1450,'Santa María Yalina',1,20,1,NULL,NULL),(1451,'Santa María Yavesía',1,20,1,NULL,NULL),(1452,'Santa María Yolotepec',1,20,1,NULL,NULL),(1453,'Santa María Yosoyúa',1,20,1,NULL,NULL),(1454,'Santa María Yucuhiti',1,20,1,NULL,NULL),(1455,'Santa María Zacatepec',1,20,1,NULL,NULL),(1456,'Santa María Zaniza',1,20,1,NULL,NULL),(1457,'Santa María Zoquitlán',1,20,1,NULL,NULL),(1458,'Santiago Amoltepec',1,20,1,NULL,NULL),(1459,'Santiago Apoala',1,20,1,NULL,NULL),(1460,'Santiago Apóstol',1,20,1,NULL,NULL),(1461,'Santiago Astata',1,20,1,NULL,NULL),(1462,'Santiago Atitlán',1,20,1,NULL,NULL),(1463,'Santiago Ayuquililla',1,20,1,NULL,NULL),(1464,'Santiago Cacaloxtepec',1,20,1,NULL,NULL),(1465,'Santiago Camotlán',1,20,1,NULL,NULL),(1466,'Santiago Comaltepec',1,20,1,NULL,NULL),(1467,'Santiago Chazumba',1,20,1,NULL,NULL),(1468,'Santiago Choápam',1,20,1,NULL,NULL),(1469,'Santiago del Río',1,20,1,NULL,NULL),(1470,'Santiago Huajolotitlán',1,20,1,NULL,NULL),(1471,'Santiago Huauclilla',1,20,1,NULL,NULL),(1472,'Santiago Ihuitlán Plumas',1,20,1,NULL,NULL),(1473,'Santiago Ixcuintepec',1,20,1,NULL,NULL),(1474,'Santiago Ixtayutla',1,20,1,NULL,NULL),(1475,'Santiago Jamiltepec',1,20,1,NULL,NULL),(1476,'Santiago Jocotepec',1,20,1,NULL,NULL),(1477,'Santiago Juxtlahuaca',1,20,1,NULL,NULL),(1478,'Santiago Lachiguiri',1,20,1,NULL,NULL),(1479,'Santiago Lalopa',1,20,1,NULL,NULL),(1480,'Santiago Laollaga',1,20,1,NULL,NULL),(1481,'Santiago Laxopa',1,20,1,NULL,NULL),(1482,'Santiago Llano Grande',1,20,1,NULL,NULL),(1483,'Santiago Matatlán',1,20,1,NULL,NULL),(1484,'Santiago Miltepec',1,20,1,NULL,NULL),(1485,'Santiago Minas',1,20,1,NULL,NULL),(1486,'Santiago Nacaltepec',1,20,1,NULL,NULL),(1487,'Santiago Nejapilla',1,20,1,NULL,NULL),(1488,'Santiago Nundiche',1,20,1,NULL,NULL),(1489,'Santiago Nuyoó',1,20,1,NULL,NULL),(1490,'Santiago Pinotepa Nacional',1,20,1,NULL,NULL),(1491,'Santiago Suchilquitongo',1,20,1,NULL,NULL),(1492,'Santiago Tamazola',1,20,1,NULL,NULL),(1493,'Santiago Tapextla',1,20,1,NULL,NULL),(1494,'Villa Tejúpam de la Unión',1,20,1,NULL,NULL),(1495,'Santiago Tenango',1,20,1,NULL,NULL),(1496,'Santiago Tepetlapa',1,20,1,NULL,NULL),(1497,'Santiago Tetepec',1,20,1,NULL,NULL),(1498,'Santiago Texcalcingo',1,20,1,NULL,NULL),(1499,'Santiago Textitlán',1,20,1,NULL,NULL),(1500,'Santiago Tilantongo',1,20,1,NULL,NULL),(1501,'Santiago Tillo',1,20,1,NULL,NULL),(1502,'Santiago Tlazoyaltepec',1,20,1,NULL,NULL),(1503,'Santiago Xanica',1,20,1,NULL,NULL),(1504,'Santiago Xiacuí',1,20,1,NULL,NULL),(1505,'Santiago Yaitepec',1,20,1,NULL,NULL),(1506,'Santiago Yaveo',1,20,1,NULL,NULL),(1507,'Santiago Yolomécatl',1,20,1,NULL,NULL),(1508,'Santiago Yosondúa',1,20,1,NULL,NULL),(1509,'Santiago Yucuyachi',1,20,1,NULL,NULL),(1510,'Santiago Zacatepec',1,20,1,NULL,NULL),(1511,'Santiago Zoochila',1,20,1,NULL,NULL),(1512,'Nuevo Zoquiápam',1,20,1,NULL,NULL),(1513,'Santo Domingo Ingenio',1,20,1,NULL,NULL),(1514,'Santo Domingo Albarradas',1,20,1,NULL,NULL),(1515,'Santo Domingo Armenta',1,20,1,NULL,NULL),(1516,'Santo Domingo Chihuitán',1,20,1,NULL,NULL),(1517,'Santo Domingo de Morelos',1,20,1,NULL,NULL),(1518,'Santo Domingo Ixcatlán',1,20,1,NULL,NULL),(1519,'Santo Domingo Nuxaá',1,20,1,NULL,NULL),(1520,'Santo Domingo Ozolotepec',1,20,1,NULL,NULL),(1521,'Santo Domingo Petapa',1,20,1,NULL,NULL),(1522,'Santo Domingo Roayaga',1,20,1,NULL,NULL),(1523,'Santo Domingo Tehuantepec',1,20,1,NULL,NULL),(1524,'Santo Domingo Teojomulco',1,20,1,NULL,NULL),(1525,'Santo Domingo Tepuxtepec',1,20,1,NULL,NULL),(1526,'Santo Domingo Tlatayápam',1,20,1,NULL,NULL),(1527,'Santo Domingo Tomaltepec',1,20,1,NULL,NULL),(1528,'Santo Domingo Tonalá',1,20,1,NULL,NULL),(1529,'Santo Domingo Tonaltepec',1,20,1,NULL,NULL),(1530,'Santo Domingo Xagacía',1,20,1,NULL,NULL),(1531,'Santo Domingo Yanhuitlán',1,20,1,NULL,NULL),(1532,'Santo Domingo Yodohino',1,20,1,NULL,NULL),(1533,'Santo Domingo Zanatepec',1,20,1,NULL,NULL),(1534,'Santos Reyes Nopala',1,20,1,NULL,NULL),(1535,'Santos Reyes Pápalo',1,20,1,NULL,NULL),(1536,'Santos Reyes Tepejillo',1,20,1,NULL,NULL),(1537,'Santos Reyes Yucuná',1,20,1,NULL,NULL),(1538,'Santo Tomás Jalieza',1,20,1,NULL,NULL),(1539,'Santo Tomás Mazaltepec',1,20,1,NULL,NULL),(1540,'Santo Tomás Ocotepec',1,20,1,NULL,NULL),(1541,'Santo Tomás Tamazulapan',1,20,1,NULL,NULL),(1542,'San Vicente Coatlán',1,20,1,NULL,NULL),(1543,'San Vicente Lachixío',1,20,1,NULL,NULL),(1544,'San Vicente Nuñú',1,20,1,NULL,NULL),(1545,'Silacayoápam',1,20,1,NULL,NULL),(1546,'Sitio de Xitlapehua',1,20,1,NULL,NULL),(1547,'Soledad Etla',1,20,1,NULL,NULL),(1548,'Villa de Tamazulápam del Progreso',1,20,1,NULL,NULL),(1549,'Tanetze de Zaragoza',1,20,1,NULL,NULL),(1550,'Taniche',1,20,1,NULL,NULL),(1551,'Tataltepec de Valdés',1,20,1,NULL,NULL),(1552,'Teococuilco de Marcos Pérez',1,20,1,NULL,NULL),(1553,'Teotitlán de Flores Magón',1,20,1,NULL,NULL),(1554,'Teotitlán del Valle',1,20,1,NULL,NULL),(1555,'Teotongo',1,20,1,NULL,NULL),(1556,'Tepelmeme Villa de Morelos',1,20,1,NULL,NULL),(1557,'Heroica Villa Tezoatlán de Segura y Luna, Cuna de la Independencia de Oaxaca',1,20,1,NULL,NULL),(1558,'San Jerónimo Tlacochahuaya',1,20,1,NULL,NULL),(1559,'Tlacolula de Matamoros',1,20,1,NULL,NULL),(1560,'Tlacotepec Plumas',1,20,1,NULL,NULL),(1561,'Tlalixtac de Cabrera',1,20,1,NULL,NULL),(1562,'Totontepec Villa de Morelos',1,20,1,NULL,NULL),(1563,'Trinidad Zaachila',1,20,1,NULL,NULL),(1564,'La Trinidad Vista Hermosa',1,20,1,NULL,NULL),(1565,'Unión Hidalgo',1,20,1,NULL,NULL),(1566,'Valerio Trujano',1,20,1,NULL,NULL),(1567,'San Juan Bautista Valle Nacional',1,20,1,NULL,NULL),(1568,'Villa Díaz Ordaz',1,20,1,NULL,NULL),(1569,'Yaxe',1,20,1,NULL,NULL),(1570,'Magdalena Yodocono de Porfirio Díaz',1,20,1,NULL,NULL),(1571,'Yogana',1,20,1,NULL,NULL),(1572,'Yutanduchi de Guerrero',1,20,1,NULL,NULL),(1573,'Villa de Zaachila',1,20,1,NULL,NULL),(1574,'San Mateo Yucutindoo',1,20,1,NULL,NULL),(1575,'Zapotitlán Lagunas',1,20,1,NULL,NULL),(1576,'Zapotitlán Palmas',1,20,1,NULL,NULL),(1577,'Santa Inés de Zaragoza',1,20,1,NULL,NULL),(1578,'Zimatlán de Álvarez',1,20,1,NULL,NULL),(1579,'Acajete',1,21,1,NULL,NULL),(1580,'Acateno',1,21,1,NULL,NULL),(1581,'Acatlán',1,21,1,NULL,NULL),(1582,'Acatzingo',1,21,1,NULL,NULL),(1583,'Acteopan',1,21,1,NULL,NULL),(1584,'Ahuacatlán',1,21,1,NULL,NULL),(1585,'Ahuatlán',1,21,1,NULL,NULL),(1586,'Ahuazotepec',1,21,1,NULL,NULL),(1587,'Ahuehuetitla',1,21,1,NULL,NULL),(1588,'Ajalpan',1,21,1,NULL,NULL),(1589,'Albino Zertuche',1,21,1,NULL,NULL),(1590,'Aljojuca',1,21,1,NULL,NULL),(1591,'Altepexi',1,21,1,NULL,NULL),(1592,'Amixtlán',1,21,1,NULL,NULL),(1593,'Amozoc',1,21,1,NULL,NULL),(1594,'Aquixtla',1,21,1,NULL,NULL),(1595,'Atempan',1,21,1,NULL,NULL),(1596,'Atexcal',1,21,1,NULL,NULL),(1597,'Atlixco',1,21,1,NULL,NULL),(1598,'Atoyatempan',1,21,1,NULL,NULL),(1599,'Atzala',1,21,1,NULL,NULL),(1600,'Atzitzihuacán',1,21,1,NULL,NULL),(1601,'Atzitzintla',1,21,1,NULL,NULL),(1602,'Axutla',1,21,1,NULL,NULL),(1603,'Ayotoxco de Guerrero',1,21,1,NULL,NULL),(1604,'Calpan',1,21,1,NULL,NULL),(1605,'Caltepec',1,21,1,NULL,NULL),(1606,'Camocuautla',1,21,1,NULL,NULL),(1607,'Caxhuacan',1,21,1,NULL,NULL),(1608,'Coatepec',1,21,1,NULL,NULL),(1609,'Coatzingo',1,21,1,NULL,NULL),(1610,'Cohetzala',1,21,1,NULL,NULL),(1612,'Cohuecan',1,21,1,NULL,NULL),(1613,'Coronango',1,21,1,NULL,NULL),(1614,'Coxcatlán',1,21,1,NULL,NULL),(1615,'Coyomeapan',1,21,1,NULL,NULL),(1616,'Coyotepec',1,21,1,NULL,NULL),(1617,'Cuapiaxtla de Madero',1,21,1,NULL,NULL),(1618,'Cuautempan',1,21,1,NULL,NULL),(1619,'Cuautinchán',1,21,1,NULL,NULL),(1620,'Cuautlancingo',1,21,1,NULL,NULL),(1621,'Cuayuca de Andrade',1,21,1,NULL,NULL),(1622,'Cuetzalan del Progreso',1,21,1,NULL,NULL),(1623,'Cuyoaco',1,21,1,NULL,NULL),(1624,'Chalchicomula de Sesma',1,21,1,NULL,NULL),(1625,'Chapulco',1,21,1,NULL,NULL),(1626,'Chiautla',1,21,1,NULL,NULL),(1627,'Chiautzingo',1,21,1,NULL,NULL),(1628,'Chiconcuautla',1,21,1,NULL,NULL),(1629,'Chichiquila',1,21,1,NULL,NULL),(1630,'Chietla',1,21,1,NULL,NULL),(1631,'Chigmecatitlán',1,21,1,NULL,NULL),(1632,'Chignahuapan',1,21,1,NULL,NULL),(1633,'Chignautla',1,21,1,NULL,NULL),(1634,'Chila',1,21,1,NULL,NULL),(1635,'Chila de la Sal',1,21,1,NULL,NULL),(1636,'Honey',1,21,1,NULL,NULL),(1637,'Chilchotla',1,21,1,NULL,NULL),(1638,'Chinantla',1,21,1,NULL,NULL),(1639,'Domingo Arenas',1,21,1,NULL,NULL),(1640,'Eloxochitlán',1,21,1,NULL,NULL),(1641,'Epatlán',1,21,1,NULL,NULL),(1642,'Esperanza',1,21,1,NULL,NULL),(1643,'Francisco Z. Mena',1,21,1,NULL,NULL),(1644,'General Felipe Ángeles',1,21,1,NULL,NULL),(1645,'Guadalupe',1,21,1,NULL,NULL),(1646,'Guadalupe Victoria',1,21,1,NULL,NULL),(1647,'Hermenegildo Galeana',1,21,1,NULL,NULL),(1648,'Huaquechula',1,21,1,NULL,NULL),(1649,'Huatlatlauca',1,21,1,NULL,NULL),(1650,'Huauchinango',1,21,1,NULL,NULL),(1651,'Huehuetla',1,21,1,NULL,NULL),(1652,'Huehuetlán el Chico',1,21,1,NULL,NULL),(1653,'Huejotzingo',1,21,1,NULL,NULL),(1654,'Hueyapan',1,21,1,NULL,NULL),(1655,'Hueytamalco',1,21,1,NULL,NULL),(1656,'Hueytlalpan',1,21,1,NULL,NULL),(1657,'Huitzilan de Serdán',1,21,1,NULL,NULL),(1658,'Huitziltepec',1,21,1,NULL,NULL),(1659,'Atlequizayan',1,21,1,NULL,NULL),(1660,'Ixcamilpa de Guerrero',1,21,1,NULL,NULL),(1661,'Ixcaquixtla',1,21,1,NULL,NULL),(1662,'Ixtacamaxtitlán',1,21,1,NULL,NULL),(1663,'Ixtepec',1,21,1,NULL,NULL),(1664,'Izúcar de Matamoros',1,21,1,NULL,NULL),(1665,'Jalpan',1,21,1,NULL,NULL),(1666,'Jolalpan',1,21,1,NULL,NULL),(1667,'Jonotla',1,21,1,NULL,NULL),(1668,'Jopala',1,21,1,NULL,NULL),(1669,'Juan C. Bonilla',1,21,1,NULL,NULL),(1670,'Juan Galindo',1,21,1,NULL,NULL),(1671,'Juan N. Méndez',1,21,1,NULL,NULL),(1672,'Lafragua',1,21,1,NULL,NULL),(1673,'Libres',1,21,1,NULL,NULL),(1674,'La Magdalena Tlatlauquitepec',1,21,1,NULL,NULL),(1675,'Mazapiltepec de Juárez',1,21,1,NULL,NULL),(1676,'Mixtla',1,21,1,NULL,NULL),(1677,'Molcaxac',1,21,1,NULL,NULL),(1678,'Cañada Morelos',1,21,1,NULL,NULL),(1679,'Naupan',1,21,1,NULL,NULL),(1680,'Nauzontla',1,21,1,NULL,NULL),(1681,'Nealtican',1,21,1,NULL,NULL),(1682,'Nicolás Bravo',1,21,1,NULL,NULL),(1683,'Nopalucan',1,21,1,NULL,NULL),(1684,'Ocotepec',1,21,1,NULL,NULL),(1685,'Ocoyucan',1,21,1,NULL,NULL),(1686,'Olintla',1,21,1,NULL,NULL),(1687,'Oriental',1,21,1,NULL,NULL),(1688,'Pahuatlán',1,21,1,NULL,NULL),(1689,'Palmar de Bravo',1,21,1,NULL,NULL),(1690,'Pantepec',1,21,1,NULL,NULL),(1691,'Petlalcingo',1,21,1,NULL,NULL),(1692,'Piaxtla',1,21,1,NULL,NULL),(1693,'Puebla',1,21,1,NULL,NULL),(1694,'Quecholac',1,21,1,NULL,NULL),(1695,'Quimixtlán',1,21,1,NULL,NULL),(1696,'Rafael Lara Grajales',1,21,1,NULL,NULL),(1697,'Los Reyes de Juárez',1,21,1,NULL,NULL),(1698,'San Andrés Cholula',1,21,1,NULL,NULL),(1699,'San Antonio Cañada',1,21,1,NULL,NULL),(1700,'San Diego la Mesa Tochimiltzingo',1,21,1,NULL,NULL),(1701,'San Felipe Teotlalcingo',1,21,1,NULL,NULL),(1702,'San Felipe Tepatlán',1,21,1,NULL,NULL),(1703,'San Gabriel Chilac',1,21,1,NULL,NULL),(1704,'San Gregorio Atzompa',1,21,1,NULL,NULL),(1705,'San Jerónimo Tecuanipan',1,21,1,NULL,NULL),(1706,'San Jerónimo Xayacatlán',1,21,1,NULL,NULL),(1707,'San José Chiapa',1,21,1,NULL,NULL),(1708,'San José Miahuatlán',1,21,1,NULL,NULL),(1709,'San Juan Atenco',1,21,1,NULL,NULL),(1710,'San Juan Atzompa',1,21,1,NULL,NULL),(1711,'San Martín Texmelucan',1,21,1,NULL,NULL),(1713,'San Martín Totoltepec',1,21,1,NULL,NULL),(1714,'San Matías Tlalancaleca',1,21,1,NULL,NULL),(1715,'San Miguel Ixitlán',1,21,1,NULL,NULL),(1716,'San Miguel Xoxtla',1,21,1,NULL,NULL),(1717,'San Nicolás Buenos Aires',1,21,1,NULL,NULL),(1718,'San Nicolás de los Ranchos',1,21,1,NULL,NULL),(1719,'San Pablo Anicano',1,21,1,NULL,NULL),(1720,'San Pedro Cholula',1,21,1,NULL,NULL),(1721,'San Pedro Yeloixtlahuaca',1,21,1,NULL,NULL),(1722,'San Salvador el Seco',1,21,1,NULL,NULL),(1723,'San Salvador el Verde',1,21,1,NULL,NULL),(1724,'San Salvador Huixcolotla',1,21,1,NULL,NULL),(1725,'San Sebastián Tlacotepec',1,21,1,NULL,NULL),(1726,'Santa Catarina Tlaltempan',1,21,1,NULL,NULL),(1727,'Santa Inés Ahuatempan',1,21,1,NULL,NULL),(1728,'Santa Isabel Cholula',1,21,1,NULL,NULL),(1729,'Santiago Miahuatlán',1,21,1,NULL,NULL),(1730,'Huehuetlán el Grande',1,21,1,NULL,NULL),(1731,'Santo Tomás Hueyotlipan',1,21,1,NULL,NULL),(1732,'Soltepec',1,21,1,NULL,NULL),(1733,'Tecali de Herrera',1,21,1,NULL,NULL),(1734,'Tecamachalco',1,21,1,NULL,NULL),(1735,'Tecomatlán',1,21,1,NULL,NULL),(1736,'Tehuacán',1,21,1,NULL,NULL),(1737,'Tehuitzingo',1,21,1,NULL,NULL),(1738,'Tenampulco',1,21,1,NULL,NULL),(1739,'Teopantlán',1,21,1,NULL,NULL),(1740,'Teotlalco',1,21,1,NULL,NULL),(1741,'Tepanco de López',1,21,1,NULL,NULL),(1742,'Tepango de Rodríguez',1,21,1,NULL,NULL),(1743,'Tepatlaxco de Hidalgo',1,21,1,NULL,NULL),(1744,'Tepeaca',1,21,1,NULL,NULL),(1745,'Tepemaxalco',1,21,1,NULL,NULL),(1746,'Tepeojuma',1,21,1,NULL,NULL),(1747,'Tepetzintla',1,21,1,NULL,NULL),(1748,'Tepexco',1,21,1,NULL,NULL),(1749,'Tepexi de Rodríguez',1,21,1,NULL,NULL),(1750,'Tepeyahualco',1,21,1,NULL,NULL),(1751,'Tepeyahualco de Cuauhtémoc',1,21,1,NULL,NULL),(1752,'Tetela de Ocampo',1,21,1,NULL,NULL),(1753,'Teteles de Avila Castillo',1,21,1,NULL,NULL),(1754,'Teziutlán',1,21,1,NULL,NULL),(1755,'Tianguismanalco',1,21,1,NULL,NULL),(1756,'Tilapa',1,21,1,NULL,NULL),(1757,'Tlacotepec de Benito Juárez',1,21,1,NULL,NULL),(1758,'Tlacuilotepec',1,21,1,NULL,NULL),(1759,'Tlachichuca',1,21,1,NULL,NULL),(1760,'Tlahuapan',1,21,1,NULL,NULL),(1761,'Tlaltenango',1,21,1,NULL,NULL),(1762,'Tlanepantla',1,21,1,NULL,NULL),(1763,'Tlaola',1,21,1,NULL,NULL),(1764,'Tlapacoya',1,21,1,NULL,NULL),(1765,'Tlapanalá',1,21,1,NULL,NULL),(1766,'Tlatlauquitepec',1,21,1,NULL,NULL),(1767,'Tlaxco',1,21,1,NULL,NULL),(1768,'Tochimilco',1,21,1,NULL,NULL),(1769,'Tochtepec',1,21,1,NULL,NULL),(1770,'Totoltepec de Guerrero',1,21,1,NULL,NULL),(1771,'Tulcingo',1,21,1,NULL,NULL),(1772,'Tuzamapan de Galeana',1,21,1,NULL,NULL),(1773,'Tzicatlacoyan',1,21,1,NULL,NULL),(1774,'Venustiano Carranza',1,21,1,NULL,NULL),(1775,'Vicente Guerrero',1,21,1,NULL,NULL),(1776,'Xayacatlán de Bravo',1,21,1,NULL,NULL),(1777,'Xicotepec',1,21,1,NULL,NULL),(1778,'Xicotlán',1,21,1,NULL,NULL),(1779,'Xiutetelco',1,21,1,NULL,NULL),(1780,'Xochiapulco',1,21,1,NULL,NULL),(1781,'Xochiltepec',1,21,1,NULL,NULL),(1782,'Xochitlán de Vicente Suárez',1,21,1,NULL,NULL),(1783,'Xochitlán Todos Santos',1,21,1,NULL,NULL),(1784,'Yaonáhuac',1,21,1,NULL,NULL),(1785,'Yehualtepec',1,21,1,NULL,NULL),(1786,'Zacapala',1,21,1,NULL,NULL),(1787,'Zacapoaxtla',1,21,1,NULL,NULL),(1788,'Zacatlán',1,21,1,NULL,NULL),(1789,'Zapotitlán',1,21,1,NULL,NULL),(1790,'Zapotitlán de Méndez',1,21,1,NULL,NULL),(1791,'Zaragoza',1,21,1,NULL,NULL),(1792,'Zautla',1,21,1,NULL,NULL),(1793,'Zihuateutla',1,21,1,NULL,NULL),(1794,'Zinacatepec',1,21,1,NULL,NULL),(1795,'Zongozotla',1,21,1,NULL,NULL),(1796,'Zoquiapan',1,21,1,NULL,NULL),(1797,'Zoquitlán',1,21,1,NULL,NULL),(1798,'Amealco de Bonfil',1,22,1,NULL,NULL),(1799,'Pinal de Amoles',1,22,1,NULL,NULL),(1800,'Arroyo Seco',1,22,1,NULL,NULL),(1801,'Cadereyta de Montes',1,22,1,NULL,NULL),(1802,'Colón',1,22,1,NULL,NULL),(1803,'Corregidora',1,22,1,NULL,NULL),(1804,'Ezequiel Montes',1,22,1,NULL,NULL),(1805,'Huimilpan',1,22,1,NULL,NULL),(1806,'Jalpan de Serra',1,22,1,NULL,NULL),(1807,'Landa de Matamoros',1,22,1,NULL,NULL),(1808,'El Marqués',1,22,1,NULL,NULL),(1809,'Pedro Escobedo',1,22,1,NULL,NULL),(1810,'Peñamiller',1,22,1,NULL,NULL),(1811,'Querétaro',1,22,1,NULL,NULL),(1812,'San Joaquín',1,22,1,NULL,NULL),(1814,'San Juan del Río',1,22,1,NULL,NULL),(1815,'Tequisquiapan',1,22,1,NULL,NULL),(1816,'Tolimán',1,22,1,NULL,NULL),(1817,'Cozumel',1,23,1,NULL,NULL),(1818,'Felipe Carrillo Puerto',1,23,1,NULL,NULL),(1819,'Isla Mujeres',1,23,1,NULL,NULL),(1820,'Othón P. Blanco',1,23,1,NULL,NULL),(1821,'Benito Juárez',1,23,1,NULL,NULL),(1822,'José María Morelos',1,23,1,NULL,NULL),(1823,'Lázaro Cárdenas',1,23,1,NULL,NULL),(1824,'Solidaridad',1,23,1,NULL,NULL),(1825,'Tulum',1,23,1,NULL,NULL),(1826,'Bacalar',1,23,1,NULL,NULL),(1827,'Ahualulco',1,24,1,NULL,NULL),(1828,'Alaquines',1,24,1,NULL,NULL),(1829,'Aquismón',1,24,1,NULL,NULL),(1830,'Armadillo de los Infante',1,24,1,NULL,NULL),(1831,'Cárdenas',1,24,1,NULL,NULL),(1832,'Catorce',1,24,1,NULL,NULL),(1833,'Cedral',1,24,1,NULL,NULL),(1834,'Cerritos',1,24,1,NULL,NULL),(1835,'Cerro de San Pedro',1,24,1,NULL,NULL),(1836,'Ciudad del Maíz',1,24,1,NULL,NULL),(1837,'Ciudad Fernández',1,24,1,NULL,NULL),(1838,'Tancanhuitz',1,24,1,NULL,NULL),(1839,'Ciudad Valles',1,24,1,NULL,NULL),(1840,'Coxcatlán',1,24,1,NULL,NULL),(1841,'Charcas',1,24,1,NULL,NULL),(1842,'Ebano',1,24,1,NULL,NULL),(1843,'Guadalcázar',1,24,1,NULL,NULL),(1844,'Huehuetlán',1,24,1,NULL,NULL),(1845,'Lagunillas',1,24,1,NULL,NULL),(1846,'Matehuala',1,24,1,NULL,NULL),(1847,'Mexquitic de Carmona',1,24,1,NULL,NULL),(1848,'Moctezuma',1,24,1,NULL,NULL),(1849,'Rayón',1,24,1,NULL,NULL),(1850,'Rioverde',1,24,1,NULL,NULL),(1851,'Salinas',1,24,1,NULL,NULL),(1852,'San Antonio',1,24,1,NULL,NULL),(1853,'San Ciro de Acosta',1,24,1,NULL,NULL),(1854,'San Luis Potosí',1,24,1,NULL,NULL),(1855,'San Martín Chalchicuautla',1,24,1,NULL,NULL),(1856,'San Nicolás Tolentino',1,24,1,NULL,NULL),(1857,'Santa Catarina',1,24,1,NULL,NULL),(1858,'Santa María del Río',1,24,1,NULL,NULL),(1859,'Santo Domingo',1,24,1,NULL,NULL),(1860,'San Vicente Tancuayalab',1,24,1,NULL,NULL),(1861,'Soledad de Graciano Sánchez',1,24,1,NULL,NULL),(1862,'Tamasopo',1,24,1,NULL,NULL),(1863,'Tamazunchale',1,24,1,NULL,NULL),(1864,'Tampacán',1,24,1,NULL,NULL),(1865,'Tampamolón Corona',1,24,1,NULL,NULL),(1866,'Tamuín',1,24,1,NULL,NULL),(1867,'Tanlajás',1,24,1,NULL,NULL),(1868,'Tanquián de Escobedo',1,24,1,NULL,NULL),(1869,'Tierra Nueva',1,24,1,NULL,NULL),(1870,'Vanegas',1,24,1,NULL,NULL),(1871,'Venado',1,24,1,NULL,NULL),(1872,'Villa de Arriaga',1,24,1,NULL,NULL),(1873,'Villa de Guadalupe',1,24,1,NULL,NULL),(1874,'Villa de la Paz',1,24,1,NULL,NULL),(1875,'Villa de Ramos',1,24,1,NULL,NULL),(1876,'Villa de Reyes',1,24,1,NULL,NULL),(1877,'Villa Hidalgo',1,24,1,NULL,NULL),(1878,'Villa Juárez',1,24,1,NULL,NULL),(1879,'Axtla de Terrazas',1,24,1,NULL,NULL),(1880,'Xilitla',1,24,1,NULL,NULL),(1881,'Zaragoza',1,24,1,NULL,NULL),(1882,'Villa de Arista',1,24,1,NULL,NULL),(1883,'Matlapa',1,24,1,NULL,NULL),(1884,'El Naranjo',1,24,1,NULL,NULL),(1885,'Ahome',1,25,1,NULL,NULL),(1886,'Angostura',1,25,1,NULL,NULL),(1887,'Badiraguato',1,25,1,NULL,NULL),(1888,'Concordia',1,25,1,NULL,NULL),(1889,'Cosalá',1,25,1,NULL,NULL),(1890,'Culiacán',1,25,1,NULL,NULL),(1891,'Choix',1,25,1,NULL,NULL),(1892,'Elota',1,25,1,NULL,NULL),(1893,'Escuinapa',1,25,1,NULL,NULL),(1894,'El Fuerte',1,25,1,NULL,NULL),(1895,'Guasave',1,25,1,NULL,NULL),(1896,'Mazatlán',1,25,1,NULL,NULL),(1897,'Mocorito',1,25,1,NULL,NULL),(1898,'Rosario',1,25,1,NULL,NULL),(1899,'Salvador Alvarado',1,25,1,NULL,NULL),(1900,'San Ignacio',1,25,1,NULL,NULL),(1901,'Sinaloa',1,25,1,NULL,NULL),(1902,'Navolato',1,25,1,NULL,NULL),(1903,'Aconchi',1,26,1,NULL,NULL),(1904,'Agua Prieta',1,26,1,NULL,NULL),(1905,'Alamos',1,26,1,NULL,NULL),(1906,'Altar',1,26,1,NULL,NULL),(1907,'Arivechi',1,26,1,NULL,NULL),(1908,'Arizpe',1,26,1,NULL,NULL),(1909,'Atil',1,26,1,NULL,NULL),(1910,'Bacadéhuachi',1,26,1,NULL,NULL),(1911,'Bacanora',1,26,1,NULL,NULL),(1912,'Bacerac',1,26,1,NULL,NULL),(1913,'Bacoachi',1,26,1,NULL,NULL),(1915,'Bácum',1,26,1,NULL,NULL),(1916,'Banámichi',1,26,1,NULL,NULL),(1917,'Baviácora',1,26,1,NULL,NULL),(1918,'Bavispe',1,26,1,NULL,NULL),(1919,'Benjamín Hill',1,26,1,NULL,NULL),(1920,'Caborca',1,26,1,NULL,NULL),(1921,'Cajeme',1,26,1,NULL,NULL),(1922,'Cananea',1,26,1,NULL,NULL),(1923,'Carbó',1,26,1,NULL,NULL),(1924,'La Colorada',1,26,1,NULL,NULL),(1925,'Cucurpe',1,26,1,NULL,NULL),(1926,'Cumpas',1,26,1,NULL,NULL),(1927,'Divisaderos',1,26,1,NULL,NULL),(1928,'Empalme',1,26,1,NULL,NULL),(1929,'Etchojoa',1,26,1,NULL,NULL),(1930,'Fronteras',1,26,1,NULL,NULL),(1931,'Granados',1,26,1,NULL,NULL),(1932,'Guaymas',1,26,1,NULL,NULL),(1933,'Hermosillo',1,26,1,NULL,NULL),(1934,'Huachinera',1,26,1,NULL,NULL),(1935,'Huásabas',1,26,1,NULL,NULL),(1936,'Huatabampo',1,26,1,NULL,NULL),(1937,'Huépac',1,26,1,NULL,NULL),(1938,'Imuris',1,26,1,NULL,NULL),(1939,'Magdalena',1,26,1,NULL,NULL),(1940,'Mazatán',1,26,1,NULL,NULL),(1941,'Moctezuma',1,26,1,NULL,NULL),(1942,'Naco',1,26,1,NULL,NULL),(1943,'Nácori Chico',1,26,1,NULL,NULL),(1944,'Nacozari de García',1,26,1,NULL,NULL),(1945,'Navojoa',1,26,1,NULL,NULL),(1946,'Nogales',1,26,1,NULL,NULL),(1947,'Onavas',1,26,1,NULL,NULL),(1948,'Opodepe',1,26,1,NULL,NULL),(1949,'Oquitoa',1,26,1,NULL,NULL),(1950,'Pitiquito',1,26,1,NULL,NULL),(1951,'Puerto Peñasco',1,26,1,NULL,NULL),(1952,'Quiriego',1,26,1,NULL,NULL),(1953,'Rayón',1,26,1,NULL,NULL),(1954,'Rosario',1,26,1,NULL,NULL),(1955,'Sahuaripa',1,26,1,NULL,NULL),(1956,'San Felipe de Jesús',1,26,1,NULL,NULL),(1957,'San Javier',1,26,1,NULL,NULL),(1958,'San Luis Río Colorado',1,26,1,NULL,NULL),(1959,'San Miguel de Horcasitas',1,26,1,NULL,NULL),(1960,'San Pedro de la Cueva',1,26,1,NULL,NULL),(1961,'Santa Ana',1,26,1,NULL,NULL),(1962,'Santa Cruz',1,26,1,NULL,NULL),(1963,'Sáric',1,26,1,NULL,NULL),(1964,'Soyopa',1,26,1,NULL,NULL),(1965,'Suaqui Grande',1,26,1,NULL,NULL),(1966,'Tepache',1,26,1,NULL,NULL),(1967,'Trincheras',1,26,1,NULL,NULL),(1968,'Tubutama',1,26,1,NULL,NULL),(1969,'Ures',1,26,1,NULL,NULL),(1970,'Villa Hidalgo',1,26,1,NULL,NULL),(1971,'Villa Pesqueira',1,26,1,NULL,NULL),(1972,'Yécora',1,26,1,NULL,NULL),(1973,'General Plutarco Elías Calles',1,26,1,NULL,NULL),(1974,'Benito Juárez',1,26,1,NULL,NULL),(1975,'San Ignacio Río Muerto',1,26,1,NULL,NULL),(1976,'Balancán',1,27,1,NULL,NULL),(1977,'Cárdenas',1,27,1,NULL,NULL),(1978,'Centla',1,27,1,NULL,NULL),(1979,'Centro',1,27,1,NULL,NULL),(1980,'Comalcalco',1,27,1,NULL,NULL),(1981,'Cunduacán',1,27,1,NULL,NULL),(1982,'Emiliano Zapata',1,27,1,NULL,NULL),(1983,'Huimanguillo',1,27,1,NULL,NULL),(1984,'Jalapa',1,27,1,NULL,NULL),(1985,'Jalpa de Méndez',1,27,1,NULL,NULL),(1986,'Jonuta',1,27,1,NULL,NULL),(1987,'Macuspana',1,27,1,NULL,NULL),(1988,'Nacajuca',1,27,1,NULL,NULL),(1989,'Paraíso',1,27,1,NULL,NULL),(1990,'Tacotalpa',1,27,1,NULL,NULL),(1991,'Teapa',1,27,1,NULL,NULL),(1992,'Tenosique',1,27,1,NULL,NULL),(1993,'Abasolo',1,28,1,NULL,NULL),(1994,'Aldama',1,28,1,NULL,NULL),(1995,'Altamira',1,28,1,NULL,NULL),(1996,'Antiguo Morelos',1,28,1,NULL,NULL),(1997,'Burgos',1,28,1,NULL,NULL),(1998,'Bustamante',1,28,1,NULL,NULL),(1999,'Camargo',1,28,1,NULL,NULL),(2000,'Casas',1,28,1,NULL,NULL),(2001,'Ciudad Madero',1,28,1,NULL,NULL),(2002,'Cruillas',1,28,1,NULL,NULL),(2003,'Gómez Farías',1,28,1,NULL,NULL),(2004,'González',1,28,1,NULL,NULL),(2005,'Güémez',1,28,1,NULL,NULL),(2006,'Guerrero',1,28,1,NULL,NULL),(2007,'Gustavo Díaz Ordaz',1,28,1,NULL,NULL),(2008,'Hidalgo',1,28,1,NULL,NULL),(2009,'Jaumave',1,28,1,NULL,NULL),(2010,'Jiménez',1,28,1,NULL,NULL),(2011,'Llera',1,28,1,NULL,NULL),(2012,'Mainero',1,28,1,NULL,NULL),(2013,'El Mante',1,28,1,NULL,NULL),(2014,'Matamoros',1,28,1,NULL,NULL),(2015,'Méndez',1,28,1,NULL,NULL),(2016,'Mier',1,28,1,NULL,NULL),(2017,'Miguel Alemán',1,28,1,NULL,NULL),(2018,'Miquihuana',1,28,1,NULL,NULL),(2019,'Nuevo Laredo',1,28,1,NULL,NULL),(2020,'Nuevo Morelos',1,28,1,NULL,NULL),(2021,'Ocampo',1,28,1,NULL,NULL),(2022,'Padilla',1,28,1,NULL,NULL),(2023,'Palmillas',1,28,1,NULL,NULL),(2024,'Reynosa',1,28,1,NULL,NULL),(2025,'Río Bravo',1,28,1,NULL,NULL),(2026,'San Carlos',1,28,1,NULL,NULL),(2027,'San Fernando',1,28,1,NULL,NULL),(2028,'San Nicolás',1,28,1,NULL,NULL),(2029,'Soto la Marina',1,28,1,NULL,NULL),(2030,'Tampico',1,28,1,NULL,NULL),(2031,'Tula',1,28,1,NULL,NULL),(2032,'Valle Hermoso',1,28,1,NULL,NULL),(2033,'Victoria',1,28,1,NULL,NULL),(2034,'Villagrán',1,28,1,NULL,NULL),(2035,'Xicoténcatl',1,28,1,NULL,NULL),(2036,'Amaxac de Guerrero',1,29,1,NULL,NULL),(2037,'Apetatitlán de Antonio Carvajal',1,29,1,NULL,NULL),(2038,'Atlangatepec',1,29,1,NULL,NULL),(2039,'Atltzayanca',1,29,1,NULL,NULL),(2040,'Apizaco',1,29,1,NULL,NULL),(2041,'Calpulalpan',1,29,1,NULL,NULL),(2042,'El Carmen Tequexquitla',1,29,1,NULL,NULL),(2043,'Cuapiaxtla',1,29,1,NULL,NULL),(2044,'Cuaxomulco',1,29,1,NULL,NULL),(2045,'Chiautempan',1,29,1,NULL,NULL),(2046,'Muñoz de Domingo Arenas',1,29,1,NULL,NULL),(2047,'Españita',1,29,1,NULL,NULL),(2048,'Huamantla',1,29,1,NULL,NULL),(2049,'Hueyotlipan',1,29,1,NULL,NULL),(2050,'Ixtacuixtla de Mariano Matamoros',1,29,1,NULL,NULL),(2051,'Ixtenco',1,29,1,NULL,NULL),(2052,'Mazatecochco de José María Morelos',1,29,1,NULL,NULL),(2053,'Contla de Juan Cuamatzi',1,29,1,NULL,NULL),(2054,'Tepetitla de Lardizábal',1,29,1,NULL,NULL),(2055,'Sanctórum de Lázaro Cárdenas',1,29,1,NULL,NULL),(2056,'Nanacamilpa de Mariano Arista',1,29,1,NULL,NULL),(2057,'Acuamanala de Miguel Hidalgo',1,29,1,NULL,NULL),(2058,'Natívitas',1,29,1,NULL,NULL),(2059,'Panotla',1,29,1,NULL,NULL),(2060,'San Pablo del Monte',1,29,1,NULL,NULL),(2061,'Santa Cruz Tlaxcala',1,29,1,NULL,NULL),(2062,'Tenancingo',1,29,1,NULL,NULL),(2063,'Teolocholco',1,29,1,NULL,NULL),(2064,'Tepeyanco',1,29,1,NULL,NULL),(2065,'Terrenate',1,29,1,NULL,NULL),(2066,'Tetla de la Solidaridad',1,29,1,NULL,NULL),(2067,'Tetlatlahuca',1,29,1,NULL,NULL),(2068,'Tlaxcala',1,29,1,NULL,NULL),(2069,'Tlaxco',1,29,1,NULL,NULL),(2070,'Tocatlán',1,29,1,NULL,NULL),(2071,'Totolac',1,29,1,NULL,NULL),(2072,'Ziltlaltépec de Trinidad Sánchez Santos',1,29,1,NULL,NULL),(2073,'Tzompantepec',1,29,1,NULL,NULL),(2074,'Xaloztoc',1,29,1,NULL,NULL),(2075,'Xaltocan',1,29,1,NULL,NULL),(2076,'Papalotla de Xicohténcatl',1,29,1,NULL,NULL),(2077,'Xicohtzinco',1,29,1,NULL,NULL),(2078,'Yauhquemehcan',1,29,1,NULL,NULL),(2079,'Zacatelco',1,29,1,NULL,NULL),(2080,'Benito Juárez',1,29,1,NULL,NULL),(2081,'Emiliano Zapata',1,29,1,NULL,NULL),(2082,'Lázaro Cárdenas',1,29,1,NULL,NULL),(2083,'La Magdalena Tlaltelulco',1,29,1,NULL,NULL),(2084,'San Damián Texóloc',1,29,1,NULL,NULL),(2085,'San Francisco Tetlanohcan',1,29,1,NULL,NULL),(2086,'San Jerónimo Zacualpan',1,29,1,NULL,NULL),(2087,'San José Teacalco',1,29,1,NULL,NULL),(2088,'San Juan Huactzinco',1,29,1,NULL,NULL),(2089,'San Lorenzo Axocomanitla',1,29,1,NULL,NULL),(2090,'San Lucas Tecopilco',1,29,1,NULL,NULL),(2091,'Santa Ana Nopalucan',1,29,1,NULL,NULL),(2092,'Santa Apolonia Teacalco',1,29,1,NULL,NULL),(2093,'Santa Catarina Ayometla',1,29,1,NULL,NULL),(2094,'Santa Cruz Quilehtla',1,29,1,NULL,NULL),(2095,'Santa Isabel Xiloxoxtla',1,29,1,NULL,NULL),(2096,'Acajete',1,30,1,NULL,NULL),(2097,'Acatlán',1,30,1,NULL,NULL),(2098,'Acayucan',1,30,1,NULL,NULL),(2099,'Actopan',1,30,1,NULL,NULL),(2100,'Acula',1,30,1,NULL,NULL),(2101,'Acultzingo',1,30,1,NULL,NULL),(2102,'Camarón de Tejeda',1,30,1,NULL,NULL),(2103,'Alpatláhuac',1,30,1,NULL,NULL),(2104,'Alto Lucero de Gutiérrez Barrios',1,30,1,NULL,NULL),(2105,'Altotonga',1,30,1,NULL,NULL),(2106,'Alvarado',1,30,1,NULL,NULL),(2107,'Amatitlán',1,30,1,NULL,NULL),(2108,'Naranjos Amatlán',1,30,1,NULL,NULL),(2109,'Amatlán de los Reyes',1,30,1,NULL,NULL),(2110,'Angel R. Cabada',1,30,1,NULL,NULL),(2111,'La Antigua',1,30,1,NULL,NULL),(2112,'Apazapan',1,30,1,NULL,NULL),(2113,'Aquila',1,30,1,NULL,NULL),(2114,'Astacinga',1,30,1,NULL,NULL),(2116,'Atlahuilco',1,30,1,NULL,NULL),(2117,'Atoyac',1,30,1,NULL,NULL),(2118,'Atzacan',1,30,1,NULL,NULL),(2119,'Atzalan',1,30,1,NULL,NULL),(2120,'Tlaltetela',1,30,1,NULL,NULL),(2121,'Ayahualulco',1,30,1,NULL,NULL),(2122,'Banderilla',1,30,1,NULL,NULL),(2123,'Benito Juárez',1,30,1,NULL,NULL),(2124,'Boca del Río',1,30,1,NULL,NULL),(2125,'Calcahualco',1,30,1,NULL,NULL),(2126,'Camerino Z. Mendoza',1,30,1,NULL,NULL),(2127,'Carrillo Puerto',1,30,1,NULL,NULL),(2128,'Catemaco',1,30,1,NULL,NULL),(2129,'Cazones de Herrera',1,30,1,NULL,NULL),(2130,'Cerro Azul',1,30,1,NULL,NULL),(2131,'Citlaltépetl',1,30,1,NULL,NULL),(2132,'Coacoatzintla',1,30,1,NULL,NULL),(2133,'Coahuitlán',1,30,1,NULL,NULL),(2134,'Coatepec',1,30,1,NULL,NULL),(2135,'Coatzacoalcos',1,30,1,NULL,NULL),(2136,'Coatzintla',1,30,1,NULL,NULL),(2137,'Coetzala',1,30,1,NULL,NULL),(2138,'Colipa',1,30,1,NULL,NULL),(2139,'Comapa',1,30,1,NULL,NULL),(2140,'Córdoba',1,30,1,NULL,NULL),(2141,'Cosamaloapan de Carpio',1,30,1,NULL,NULL),(2142,'Cosautlán de Carvajal',1,30,1,NULL,NULL),(2143,'Coscomatepec',1,30,1,NULL,NULL),(2144,'Cosoleacaque',1,30,1,NULL,NULL),(2145,'Cotaxtla',1,30,1,NULL,NULL),(2146,'Coxquihui',1,30,1,NULL,NULL),(2147,'Coyutla',1,30,1,NULL,NULL),(2148,'Cuichapa',1,30,1,NULL,NULL),(2149,'Cuitláhuac',1,30,1,NULL,NULL),(2150,'Chacaltianguis',1,30,1,NULL,NULL),(2151,'Chalma',1,30,1,NULL,NULL),(2152,'Chiconamel',1,30,1,NULL,NULL),(2153,'Chiconquiaco',1,30,1,NULL,NULL),(2154,'Chicontepec',1,30,1,NULL,NULL),(2155,'Chinameca',1,30,1,NULL,NULL),(2156,'Chinampa de Gorostiza',1,30,1,NULL,NULL),(2157,'Las Choapas',1,30,1,NULL,NULL),(2158,'Chocamán',1,30,1,NULL,NULL),(2159,'Chontla',1,30,1,NULL,NULL),(2160,'Chumatlán',1,30,1,NULL,NULL),(2161,'Emiliano Zapata',1,30,1,NULL,NULL),(2162,'Espinal',1,30,1,NULL,NULL),(2163,'Filomeno Mata',1,30,1,NULL,NULL),(2164,'Fortín',1,30,1,NULL,NULL),(2165,'Gutiérrez Zamora',1,30,1,NULL,NULL),(2166,'Hidalgotitlán',1,30,1,NULL,NULL),(2167,'Huatusco',1,30,1,NULL,NULL),(2168,'Huayacocotla',1,30,1,NULL,NULL),(2169,'Hueyapan de Ocampo',1,30,1,NULL,NULL),(2170,'Huiloapan de Cuauhtémoc',1,30,1,NULL,NULL),(2171,'Ignacio de la Llave',1,30,1,NULL,NULL),(2172,'Ilamatlán',1,30,1,NULL,NULL),(2173,'Isla',1,30,1,NULL,NULL),(2174,'Ixcatepec',1,30,1,NULL,NULL),(2175,'Ixhuacán de los Reyes',1,30,1,NULL,NULL),(2176,'Ixhuatlán del Café',1,30,1,NULL,NULL),(2177,'Ixhuatlancillo',1,30,1,NULL,NULL),(2178,'Ixhuatlán del Sureste',1,30,1,NULL,NULL),(2179,'Ixhuatlán de Madero',1,30,1,NULL,NULL),(2180,'Ixmatlahuacan',1,30,1,NULL,NULL),(2181,'Ixtaczoquitlán',1,30,1,NULL,NULL),(2182,'Jalacingo',1,30,1,NULL,NULL),(2183,'Xalapa',1,30,1,NULL,NULL),(2184,'Jalcomulco',1,30,1,NULL,NULL),(2185,'Jáltipan',1,30,1,NULL,NULL),(2186,'Jamapa',1,30,1,NULL,NULL),(2187,'Jesús Carranza',1,30,1,NULL,NULL),(2188,'Xico',1,30,1,NULL,NULL),(2189,'Jilotepec',1,30,1,NULL,NULL),(2190,'Juan Rodríguez Clara',1,30,1,NULL,NULL),(2191,'Juchique de Ferrer',1,30,1,NULL,NULL),(2192,'Landero y Coss',1,30,1,NULL,NULL),(2193,'Lerdo de Tejada',1,30,1,NULL,NULL),(2194,'Magdalena',1,30,1,NULL,NULL),(2195,'Maltrata',1,30,1,NULL,NULL),(2196,'Manlio Fabio Altamirano',1,30,1,NULL,NULL),(2197,'Mariano Escobedo',1,30,1,NULL,NULL),(2198,'Martínez de la Torre',1,30,1,NULL,NULL),(2199,'Mecatlán',1,30,1,NULL,NULL),(2200,'Mecayapan',1,30,1,NULL,NULL),(2201,'Medellín de Bravo',1,30,1,NULL,NULL),(2202,'Miahuatlán',1,30,1,NULL,NULL),(2203,'Las Minas',1,30,1,NULL,NULL),(2204,'Minatitlán',1,30,1,NULL,NULL),(2205,'Misantla',1,30,1,NULL,NULL),(2206,'Mixtla de Altamirano',1,30,1,NULL,NULL),(2207,'Moloacán',1,30,1,NULL,NULL),(2208,'Naolinco',1,30,1,NULL,NULL),(2209,'Naranjal',1,30,1,NULL,NULL),(2210,'Nautla',1,30,1,NULL,NULL),(2211,'Nogales',1,30,1,NULL,NULL),(2212,'Oluta',1,30,1,NULL,NULL),(2213,'Omealca',1,30,1,NULL,NULL),(2214,'Orizaba',1,30,1,NULL,NULL),(2215,'Otatitlán',1,30,1,NULL,NULL),(2217,'Oteapan',1,30,1,NULL,NULL),(2218,'Ozuluama de Mascareñas',1,30,1,NULL,NULL),(2219,'Pajapan',1,30,1,NULL,NULL),(2220,'Pánuco',1,30,1,NULL,NULL),(2221,'Papantla',1,30,1,NULL,NULL),(2222,'Paso del Macho',1,30,1,NULL,NULL),(2223,'Paso de Ovejas',1,30,1,NULL,NULL),(2224,'La Perla',1,30,1,NULL,NULL),(2225,'Perote',1,30,1,NULL,NULL),(2226,'Platón Sánchez',1,30,1,NULL,NULL),(2227,'Playa Vicente',1,30,1,NULL,NULL),(2228,'Poza Rica de Hidalgo',1,30,1,NULL,NULL),(2229,'Las Vigas de Ramírez',1,30,1,NULL,NULL),(2230,'Pueblo Viejo',1,30,1,NULL,NULL),(2231,'Puente Nacional',1,30,1,NULL,NULL),(2232,'Rafael Delgado',1,30,1,NULL,NULL),(2233,'Rafael Lucio',1,30,1,NULL,NULL),(2234,'Los Reyes',1,30,1,NULL,NULL),(2235,'Río Blanco',1,30,1,NULL,NULL),(2236,'Saltabarranca',1,30,1,NULL,NULL),(2237,'San Andrés Tenejapan',1,30,1,NULL,NULL),(2238,'San Andrés Tuxtla',1,30,1,NULL,NULL),(2239,'San Juan Evangelista',1,30,1,NULL,NULL),(2240,'Santiago Tuxtla',1,30,1,NULL,NULL),(2241,'Sayula de Alemán',1,30,1,NULL,NULL),(2242,'Soconusco',1,30,1,NULL,NULL),(2243,'Sochiapa',1,30,1,NULL,NULL),(2244,'Soledad Atzompa',1,30,1,NULL,NULL),(2245,'Soledad de Doblado',1,30,1,NULL,NULL),(2246,'Soteapan',1,30,1,NULL,NULL),(2247,'Tamalín',1,30,1,NULL,NULL),(2248,'Tamiahua',1,30,1,NULL,NULL),(2249,'Tampico Alto',1,30,1,NULL,NULL),(2250,'Tancoco',1,30,1,NULL,NULL),(2251,'Tantima',1,30,1,NULL,NULL),(2252,'Tantoyuca',1,30,1,NULL,NULL),(2253,'Tatatila',1,30,1,NULL,NULL),(2254,'Castillo de Teayo',1,30,1,NULL,NULL),(2255,'Tecolutla',1,30,1,NULL,NULL),(2256,'Tehuipango',1,30,1,NULL,NULL),(2257,'Álamo Temapache',1,30,1,NULL,NULL),(2258,'Tempoal',1,30,1,NULL,NULL),(2259,'Tenampa',1,30,1,NULL,NULL),(2260,'Tenochtitlán',1,30,1,NULL,NULL),(2261,'Teocelo',1,30,1,NULL,NULL),(2262,'Tepatlaxco',1,30,1,NULL,NULL),(2263,'Tepetlán',1,30,1,NULL,NULL),(2264,'Tepetzintla',1,30,1,NULL,NULL),(2265,'Tequila',1,30,1,NULL,NULL),(2266,'José Azueta',1,30,1,NULL,NULL),(2267,'Texcatepec',1,30,1,NULL,NULL),(2268,'Texhuacán',1,30,1,NULL,NULL),(2269,'Texistepec',1,30,1,NULL,NULL),(2270,'Tezonapa',1,30,1,NULL,NULL),(2271,'Tierra Blanca',1,30,1,NULL,NULL),(2272,'Tihuatlán',1,30,1,NULL,NULL),(2273,'Tlacojalpan',1,30,1,NULL,NULL),(2274,'Tlacolulan',1,30,1,NULL,NULL),(2275,'Tlacotalpan',1,30,1,NULL,NULL),(2276,'Tlacotepec de Mejía',1,30,1,NULL,NULL),(2277,'Tlachichilco',1,30,1,NULL,NULL),(2278,'Tlalixcoyan',1,30,1,NULL,NULL),(2279,'Tlalnelhuayocan',1,30,1,NULL,NULL),(2280,'Tlapacoyan',1,30,1,NULL,NULL),(2281,'Tlaquilpa',1,30,1,NULL,NULL),(2282,'Tlilapan',1,30,1,NULL,NULL),(2283,'Tomatlán',1,30,1,NULL,NULL),(2284,'Tonayán',1,30,1,NULL,NULL),(2285,'Totutla',1,30,1,NULL,NULL),(2286,'Tuxpan',1,30,1,NULL,NULL),(2287,'Tuxtilla',1,30,1,NULL,NULL),(2288,'Ursulo Galván',1,30,1,NULL,NULL),(2289,'Vega de Alatorre',1,30,1,NULL,NULL),(2290,'Veracruz',1,30,1,NULL,NULL),(2291,'Villa Aldama',1,30,1,NULL,NULL),(2292,'Xoxocotla',1,30,1,NULL,NULL),(2293,'Yanga',1,30,1,NULL,NULL),(2294,'Yecuatla',1,30,1,NULL,NULL),(2295,'Zacualpan',1,30,1,NULL,NULL),(2296,'Zaragoza',1,30,1,NULL,NULL),(2297,'Zentla',1,30,1,NULL,NULL),(2298,'Zongolica',1,30,1,NULL,NULL),(2299,'Zontecomatlán de López y Fuentes',1,30,1,NULL,NULL),(2300,'Zozocolco de Hidalgo',1,30,1,NULL,NULL),(2301,'Agua Dulce',1,30,1,NULL,NULL),(2302,'El Higo',1,30,1,NULL,NULL),(2303,'Nanchital de Lázaro Cárdenas del Río',1,30,1,NULL,NULL),(2304,'Tres Valles',1,30,1,NULL,NULL),(2305,'Carlos A. Carrillo',1,30,1,NULL,NULL),(2306,'Tatahuicapan de Juárez',1,30,1,NULL,NULL),(2307,'Uxpanapa',1,30,1,NULL,NULL),(2308,'San Rafael',1,30,1,NULL,NULL),(2309,'Santiago Sochiapan',1,30,1,NULL,NULL),(2310,'Abalá',1,31,1,NULL,NULL),(2311,'Acanceh',1,31,1,NULL,NULL),(2312,'Akil',1,31,1,NULL,NULL),(2313,'Baca',1,31,1,NULL,NULL),(2314,'Bokobá',1,31,1,NULL,NULL),(2315,'Buctzotz',1,31,1,NULL,NULL),(2316,'Cacalchén',1,31,1,NULL,NULL),(2318,'Calotmul',1,31,1,NULL,NULL),(2319,'Cansahcab',1,31,1,NULL,NULL),(2320,'Cantamayec',1,31,1,NULL,NULL),(2321,'Celestún',1,31,1,NULL,NULL),(2322,'Cenotillo',1,31,1,NULL,NULL),(2323,'Conkal',1,31,1,NULL,NULL),(2324,'Cuncunul',1,31,1,NULL,NULL),(2325,'Cuzamá',1,31,1,NULL,NULL),(2326,'Chacsinkín',1,31,1,NULL,NULL),(2327,'Chankom',1,31,1,NULL,NULL),(2328,'Chapab',1,31,1,NULL,NULL),(2329,'Chemax',1,31,1,NULL,NULL),(2330,'Chicxulub Pueblo',1,31,1,NULL,NULL),(2331,'Chichimilá',1,31,1,NULL,NULL),(2332,'Chikindzonot',1,31,1,NULL,NULL),(2333,'Chocholá',1,31,1,NULL,NULL),(2334,'Chumayel',1,31,1,NULL,NULL),(2335,'Dzán',1,31,1,NULL,NULL),(2336,'Dzemul',1,31,1,NULL,NULL),(2337,'Dzidzantún',1,31,1,NULL,NULL),(2338,'Dzilam de Bravo',1,31,1,NULL,NULL),(2339,'Dzilam González',1,31,1,NULL,NULL),(2340,'Dzitás',1,31,1,NULL,NULL),(2341,'Dzoncauich',1,31,1,NULL,NULL),(2342,'Espita',1,31,1,NULL,NULL),(2343,'Halachó',1,31,1,NULL,NULL),(2344,'Hocabá',1,31,1,NULL,NULL),(2345,'Hoctún',1,31,1,NULL,NULL),(2346,'Homún',1,31,1,NULL,NULL),(2347,'Huhí',1,31,1,NULL,NULL),(2348,'Hunucmá',1,31,1,NULL,NULL),(2349,'Ixil',1,31,1,NULL,NULL),(2350,'Izamal',1,31,1,NULL,NULL),(2351,'Kanasín',1,31,1,NULL,NULL),(2352,'Kantunil',1,31,1,NULL,NULL),(2353,'Kaua',1,31,1,NULL,NULL),(2354,'Kinchil',1,31,1,NULL,NULL),(2355,'Kopomá',1,31,1,NULL,NULL),(2356,'Mama',1,31,1,NULL,NULL),(2357,'Maní',1,31,1,NULL,NULL),(2358,'Maxcanú',1,31,1,NULL,NULL),(2359,'Mayapán',1,31,1,NULL,NULL),(2360,'Mérida',1,31,1,NULL,NULL),(2361,'Mocochá',1,31,1,NULL,NULL),(2362,'Motul',1,31,1,NULL,NULL),(2363,'Muna',1,31,1,NULL,NULL),(2364,'Muxupip',1,31,1,NULL,NULL),(2365,'Opichén',1,31,1,NULL,NULL),(2366,'Oxkutzcab',1,31,1,NULL,NULL),(2367,'Panabá',1,31,1,NULL,NULL),(2368,'Peto',1,31,1,NULL,NULL),(2369,'Progreso',1,31,1,NULL,NULL),(2370,'Quintana Roo',1,31,1,NULL,NULL),(2371,'Río Lagartos',1,31,1,NULL,NULL),(2372,'Sacalum',1,31,1,NULL,NULL),(2373,'Samahil',1,31,1,NULL,NULL),(2374,'Sanahcat',1,31,1,NULL,NULL),(2375,'San Felipe',1,31,1,NULL,NULL),(2376,'Santa Elena',1,31,1,NULL,NULL),(2377,'Seyé',1,31,1,NULL,NULL),(2378,'Sinanché',1,31,1,NULL,NULL),(2379,'Sotuta',1,31,1,NULL,NULL),(2380,'Sucilá',1,31,1,NULL,NULL),(2381,'Sudzal',1,31,1,NULL,NULL),(2382,'Suma',1,31,1,NULL,NULL),(2383,'Tahdziú',1,31,1,NULL,NULL),(2384,'Tahmek',1,31,1,NULL,NULL),(2385,'Teabo',1,31,1,NULL,NULL),(2386,'Tecoh',1,31,1,NULL,NULL),(2387,'Tekal de Venegas',1,31,1,NULL,NULL),(2388,'Tekantó',1,31,1,NULL,NULL),(2389,'Tekax',1,31,1,NULL,NULL),(2390,'Tekit',1,31,1,NULL,NULL),(2391,'Tekom',1,31,1,NULL,NULL),(2392,'Telchac Pueblo',1,31,1,NULL,NULL),(2393,'Telchac Puerto',1,31,1,NULL,NULL),(2394,'Temax',1,31,1,NULL,NULL),(2395,'Temozón',1,31,1,NULL,NULL),(2396,'Tepakán',1,31,1,NULL,NULL),(2397,'Tetiz',1,31,1,NULL,NULL),(2398,'Teya',1,31,1,NULL,NULL),(2399,'Ticul',1,31,1,NULL,NULL),(2400,'Timucuy',1,31,1,NULL,NULL),(2401,'Tinum',1,31,1,NULL,NULL),(2402,'Tixcacalcupul',1,31,1,NULL,NULL),(2403,'Tixkokob',1,31,1,NULL,NULL),(2404,'Tixmehuac',1,31,1,NULL,NULL),(2405,'Tixpéhual',1,31,1,NULL,NULL),(2406,'Tizimín',1,31,1,NULL,NULL),(2407,'Tunkás',1,31,1,NULL,NULL),(2408,'Tzucacab',1,31,1,NULL,NULL),(2409,'Uayma',1,31,1,NULL,NULL),(2410,'Ucú',1,31,1,NULL,NULL),(2411,'Umán',1,31,1,NULL,NULL),(2412,'Valladolid',1,31,1,NULL,NULL),(2413,'Xocchel',1,31,1,NULL,NULL),(2414,'Yaxcabá',1,31,1,NULL,NULL),(2415,'Yaxkukul',1,31,1,NULL,NULL),(2416,'Yobaín',1,31,1,NULL,NULL),(2417,'Apozol',1,32,1,NULL,NULL),(2419,'Apulco',1,32,1,NULL,NULL),(2420,'Atolinga',1,32,1,NULL,NULL),(2421,'Benito Juárez',1,32,1,NULL,NULL),(2422,'Calera',1,32,1,NULL,NULL),(2423,'Cañitas de Felipe Pescador',1,32,1,NULL,NULL),(2424,'Concepción del Oro',1,32,1,NULL,NULL),(2425,'Cuauhtémoc',1,32,1,NULL,NULL),(2426,'Chalchihuites',1,32,1,NULL,NULL),(2427,'Fresnillo',1,32,1,NULL,NULL),(2428,'Trinidad García de la Cadena',1,32,1,NULL,NULL),(2429,'Genaro Codina',1,32,1,NULL,NULL),(2430,'General Enrique Estrada',1,32,1,NULL,NULL),(2431,'General Francisco R. Murguía',1,32,1,NULL,NULL),(2432,'El Plateado de Joaquín Amaro',1,32,1,NULL,NULL),(2433,'General Pánfilo Natera',1,32,1,NULL,NULL),(2434,'Guadalupe',1,32,1,NULL,NULL),(2435,'Huanusco',1,32,1,NULL,NULL),(2436,'Jalpa',1,32,1,NULL,NULL),(2437,'Jerez',1,32,1,NULL,NULL),(2438,'Jiménez del Teul',1,32,1,NULL,NULL),(2439,'Juan Aldama',1,32,1,NULL,NULL),(2440,'Juchipila',1,32,1,NULL,NULL),(2441,'Loreto',1,32,1,NULL,NULL),(2442,'Luis Moya',1,32,1,NULL,NULL),(2443,'Mazapil',1,32,1,NULL,NULL),(2444,'Melchor Ocampo',1,32,1,NULL,NULL),(2445,'Mezquital del Oro',1,32,1,NULL,NULL),(2446,'Miguel Auza',1,32,1,NULL,NULL),(2447,'Momax',1,32,1,NULL,NULL),(2448,'Monte Escobedo',1,32,1,NULL,NULL),(2449,'Morelos',1,32,1,NULL,NULL),(2450,'Moyahua de Estrada',1,32,1,NULL,NULL),(2451,'Nochistlán de Mejía',1,32,1,NULL,NULL),(2452,'Noria de Ángeles',1,32,1,NULL,NULL),(2453,'Ojocaliente',1,32,1,NULL,NULL),(2454,'Pánuco',1,32,1,NULL,NULL),(2455,'Pinos',1,32,1,NULL,NULL),(2456,'Río Grande',1,32,1,NULL,NULL),(2457,'Sain Alto',1,32,1,NULL,NULL),(2458,'El Salvador',1,32,1,NULL,NULL),(2459,'Sombrerete',1,32,1,NULL,NULL),(2460,'Susticacán',1,32,1,NULL,NULL),(2461,'Tabasco',1,32,1,NULL,NULL),(2462,'Tepechitlán',1,32,1,NULL,NULL),(2463,'Tepetongo',1,32,1,NULL,NULL),(2464,'Teúl de González Ortega',1,32,1,NULL,NULL),(2465,'Tlaltenango de Sánchez Román',1,32,1,NULL,NULL),(2466,'Valparaíso',1,32,1,NULL,NULL),(2467,'Vetagrande',1,32,1,NULL,NULL),(2468,'Villa de Cos',1,32,1,NULL,NULL),(2469,'Villa Garcia',1,32,1,NULL,NULL),(2470,'Villa Gonzalez Ortega',1,32,1,NULL,NULL),(2471,'Villa Hidalgo',1,32,1,NULL,NULL),(2472,'Villanueva',1,32,1,NULL,NULL),(2473,'Zacatecas',1,32,1,NULL,NULL),(2474,'Trancoso',1,32,1,NULL,NULL),(2475,'Santa Mariaa de la Paz',1,32,1,NULL,NULL);
/*!40000 ALTER TABLE `ciudades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_giro` int(11) DEFAULT NULL,
  `fuente` int(11) NOT NULL,
  `tipo_cliente` int(11) NOT NULL,
  `rfc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `id_cartera` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'7-ELEVEN',1,NULL,'7-ELEVEN',NULL,1,1,'7ELEVEN12090900',1,1,1,'2020-03-25 08:23:04','2020-03-25 08:23:04'),(2,'OXXO',1,NULL,'OXXO',NULL,1,1,'OXXO8928453344',1,1,1,'2020-03-27 02:17:48','2020-03-27 02:17:48'),(3,'TESLA',1,'San lorenzo #453','Tenere S.A de C.V.',NULL,1,1,'TESLA203LOE23',2,2,1,'2020-04-26 02:24:24','2020-04-26 02:24:24');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compromisos`
--

DROP TABLE IF EXISTS `compromisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compromisos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) NOT NULL,
  `tipo_compromiso` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `comentarios` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fase_venta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `obs_usuario` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cumplimiento` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compromisos`
--

LOCK TABLES `compromisos` WRITE;
/*!40000 ALTER TABLE `compromisos` DISABLE KEYS */;
INSERT INTO `compromisos` VALUES (1,7,2,3,'2020-04-24','14:30',NULL,1,'Hablar con ruperto martínez',0,1,NULL,0,1,NULL,NULL),(2,7,1,4,'2020-04-24','15:30',NULL,2,'Se revisaran los puntos esenciales para el proyecto NPC. \nNota: Traeer Cubre Bocas',0,1,NULL,0,1,NULL,NULL),(3,7,2,5,'2020-04-24','13:30',NULL,3,'Procurar subir precio.',0,1,NULL,0,1,NULL,NULL);
/*!40000 ALTER TABLE `compromisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obs` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cumpleanios` datetime DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizaciones`
--

DROP TABLE IF EXISTS `cotizaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cotizaciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `importe` double(8,2) NOT NULL,
  `utilidad` double(8,2) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizaciones`
--

LOCK TABLES `cotizaciones` WRITE;
/*!40000 ALTER TABLE `cotizaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `cotizaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_cots`
--

DROP TABLE IF EXISTS `det_cots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_cots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_cot` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `descuento` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_cots`
--

LOCK TABLES `det_cots` WRITE;
/*!40000 ALTER TABLE `det_cots` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_cots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_prods`
--

DROP TABLE IF EXISTS `det_prods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_prods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_precio` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_prods`
--

LOCK TABLES `det_prods` WRITE;
/*!40000 ALTER TABLE `det_prods` DISABLE KEYS */;
INSERT INTO `det_prods` VALUES (4,2,14,1,NULL,NULL),(5,2,13,1,NULL,NULL),(6,6,13,1,NULL,NULL),(7,3,15,1,NULL,NULL),(8,6,15,1,NULL,NULL);
/*!40000 ALTER TABLE `det_prods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pais` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados`
--

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES (1,'Aguascalientes','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(2,'Baja Califo','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(3,'Baja California Sur','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(4,'Campeche','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(5,'Coahuila de Zaragoza','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(6,'Colima','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(7,'Chiapas','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(8,'Chihuahua','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(9,'Distrito Federal','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(10,'Durango','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(11,'Guanajuato','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(12,'Guerrero','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(13,'Hidalgo','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(14,'Jalisco','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(15,'Mexico','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(16,'Michoacan de Ocampo','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(17,'Morelos','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(18,'Nayarit','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(19,'Nuevo Leon','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(20,'Oaxaca','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(21,'Puebla','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(22,'Queretaro','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(23,'Quintana Roo','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(24,'San Luis PotosÃ­','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(25,'Sinaloa','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(26,'Sonora','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(27,'Tabasco','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(28,'Tamaulipas','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(29,'Tlaxcala','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(30,'Veracruz de Ignacio de la Llave','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(31,'Yucatan','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(32,'Zacatecas','1',1,'2020-03-25 01:39:17','2020-03-25 01:39:17');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
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
-- Table structure for table `giro_comercial`
--

DROP TABLE IF EXISTS `giro_comercial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giro_comercial` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giro_comercial`
--

LOCK TABLES `giro_comercial` WRITE;
/*!40000 ALTER TABLE `giro_comercial` DISABLE KEYS */;
/*!40000 ALTER TABLE `giro_comercial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lineas_prods`
--

DROP TABLE IF EXISTS `lineas_prods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lineas_prods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lineas_prods`
--

LOCK TABLES `lineas_prods` WRITE;
/*!40000 ALTER TABLE `lineas_prods` DISABLE KEYS */;
INSERT INTO `lineas_prods` VALUES (1,'Ensamblado',1,'2020-03-13 09:52:21','2020-03-13 09:52:21'),(2,'Embarque',1,'2020-03-13 09:54:00','2020-03-13 09:54:00');
/*!40000 ALTER TABLE `lineas_prods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metas`
--

DROP TABLE IF EXISTS `metas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `enero` double(8,2) DEFAULT NULL,
  `febrero` double(8,2) DEFAULT NULL,
  `marzo` double(8,2) DEFAULT NULL,
  `abril` double(8,2) DEFAULT NULL,
  `mayo` double(8,2) DEFAULT NULL,
  `junio` double(8,2) DEFAULT NULL,
  `julio` double(8,2) DEFAULT NULL,
  `agosto` double(8,2) DEFAULT NULL,
  `septiembre` double(8,2) DEFAULT NULL,
  `octubre` double(8,2) DEFAULT NULL,
  `noviembre` double(8,2) DEFAULT NULL,
  `diciembre` double(8,2) DEFAULT NULL,
  `total_anual` double(8,2) DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metas`
--

LOCK TABLES `metas` WRITE;
/*!40000 ALTER TABLE `metas` DISABLE KEYS */;
/*!40000 ALTER TABLE `metas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1),(3,'2020_03_09_223928_create_clientes_table',1),(4,'2020_03_09_231929_create_carteras_table',1),(5,'2020_03_09_232106_create_ciudades_table',1),(6,'2020_03_09_232318_create_contactos_table',1),(7,'2020_03_09_232559_create_cotizaciones_table',1),(8,'2020_03_09_232915_create_det_cots_table',1),(9,'2020_03_09_233731_create_estados_table',1),(10,'2020_03_09_233845_create_lineas_prods_table',1),(11,'2020_03_09_234200_create_metas_table',1),(12,'2020_03_09_234518_create_monedas_table',1),(13,'2020_03_09_234703_create_paises_table',1),(14,'2020_03_09_234809_create_precios_table',1),(15,'2020_03_10_003246_create_productos_table',1),(16,'2020_03_10_005550_create_proveedores_table',1),(17,'2020_03_10_010558_create_rastreo_rutas_table',1),(18,'2020_03_10_011021_create_rastreos_table',1),(19,'2020_03_10_011230_create_rutas_estaticas_table',1),(20,'2020_03_10_011905_create_rutas_table',1),(21,'2020_03_10_012427_create_tipos_precios_table',1),(22,'2020_03_10_013202_create_sucursales_table',1),(23,'2020_03_10_013318_create_unidades_table',1),(24,'2020_03_10_013435_create_ventas_table',1),(30,'2020_03_10_014304_create_zonas_table',2),(31,'2020_03_10_014513_create_compromisos_table',2),(32,'2020_03_18_155604_create_det_prods_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monedas`
--

DROP TABLE IF EXISTS `monedas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monedas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_cambio` double(8,2) NOT NULL,
  `predeterminado` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monedas`
--

LOCK TABLES `monedas` WRITE;
/*!40000 ALTER TABLE `monedas` DISABLE KEYS */;
INSERT INTO `monedas` VALUES (1,'MX','PESO MEXICANO',1.00,0,1,'2020-03-12 10:08:03','2020-03-12 10:08:03'),(2,'USD','DOLAR EU',21.94,1,1,'2020-03-12 10:08:38','2020-03-12 10:08:38');
/*!40000 ALTER TABLE `monedas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` VALUES (1,'Mexico','1',NULL,NULL),(2,'Canada','1',NULL,NULL),(3,'Estados Unidos','1',NULL,NULL);
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `precios`
--

DROP TABLE IF EXISTS `precios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `precios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `tipo_precio` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `precio` double(8,2) NOT NULL,
  `produccion` double(8,2) NOT NULL,
  `pje_admin` int(11) NOT NULL,
  `costo_admin` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `predeterminado` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `precios`
--

LOCK TABLES `precios` WRITE;
/*!40000 ALTER TABLE `precios` DISABLE KEYS */;
INSERT INTO `precios` VALUES (1,2,2,2,2,232.00,0.00,19,276.08,276.08,0,1,'2020-03-25 01:39:17','2020-03-25 01:39:17'),(2,2,3,2,2,222.00,0.00,19,264.18,264.18,0,1,'2020-03-25 01:40:22','2020-03-25 01:40:22'),(3,2,3,3,2,235.00,0.00,19,279.65,279.65,1,1,'2020-03-25 01:41:38','2020-03-25 01:41:38'),(4,2,2,3,2,400.00,0.00,19,476.00,476.00,0,1,'2020-03-25 01:42:10','2020-03-25 01:42:10'),(5,3,3,2,2,199.45,0.00,19,237.35,237.35,0,1,'2020-03-25 01:44:07','2020-03-25 01:44:07'),(6,3,3,3,1,2500.00,0.00,19,135.60,2975.00,1,1,'2020-03-25 01:45:11','2020-03-25 01:45:11'),(7,1,1,2,2,230.00,431.45,19,273.70,705.15,1,1,'2020-03-25 02:23:47','2020-03-25 02:23:47'),(8,1,1,2,2,230.00,199.45,19,273.70,473.15,0,1,'2020-03-25 06:45:57','2020-03-25 06:45:57'),(9,6,3,3,1,2300.00,0.00,19,2737.00,2737.00,1,1,'2020-04-09 04:11:59','2020-04-09 04:11:59'),(10,6,2,4,2,150.00,0.00,19,3916.29,178.50,0,1,'2020-04-09 04:12:26','2020-04-09 04:12:26'),(11,6,2,1,1,1550.00,0.00,19,1844.50,1844.50,0,1,'2020-04-09 04:12:53','2020-04-09 04:12:53'),(12,3,3,2,2,750.00,0.00,19,892.50,892.50,0,1,'2020-04-12 03:47:21','2020-04-12 03:47:21'),(13,4,1,4,2,250.00,339.83,19,297.50,637.33,1,1,'2020-04-15 01:36:47','2020-04-15 01:36:47'),(14,4,1,1,1,2300.00,235.00,19,2737.00,2972.00,0,1,'2020-04-15 23:25:25','2020-04-15 23:25:25'),(15,5,1,2,2,330.00,218.78,19,392.70,611.48,1,1,'2020-04-21 01:15:52','2020-04-21 01:15:52');
/*!40000 ALTER TABLE `precios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_linea` int(11) NOT NULL,
  `tipo_producto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `obs` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'S235','ROLLO DE ETIQUETAS 1000','Rollo de etiquetas 1000 piezas 25x30 cm',2,2,1,1,NULL,NULL,1,'2020-03-24 05:16:48','2020-03-24 05:16:48'),(2,'MP001','CARTON LISO SIN PEGAMENTO','Cartos especializado para colocacion de plantillas de etiquetas',1,1,3,2,NULL,NULL,1,'2020-03-24 05:17:51','2020-03-24 05:17:51'),(3,'ET001','PLIEGO DE PAPEL ENCERADO','Papel para formación de etiquetas sin medidas',1,1,3,1,NULL,NULL,1,'2020-03-25 01:43:45','2020-03-25 01:43:45'),(4,'PLO405','PLOTER  2 METROS','Maquinaria Ploter para impresiones a la mejor calidad.',2,2,2,1,NULL,NULL,1,'2020-03-25 04:52:46','2020-03-25 04:52:46'),(5,'PT2110','PLOTTER GAMA','prueba',2,2,0,2,NULL,NULL,1,'2020-04-09 04:10:25','2020-04-09 04:10:25'),(6,'TS230','PEGAMENTO INDUSTRIAL','MATERIA',1,1,3,1,NULL,NULL,1,'2020-04-09 04:11:29','2020-04-09 04:11:29');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_zona` int(11) NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_giro` int(11) DEFAULT NULL,
  `tipo_prov` int(11) NOT NULL,
  `rfc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'GAMA ETIQUETAS',2,NULL,'GAMA ETIQUETAS S.A. de C.V.',NULL,2,'GAMA20320ETIQ','1','2020-03-24 05:11:28','2020-03-24 05:11:28'),(2,'FMS INN',2,NULL,'FIESTA MISSISIPI SHOP',NULL,2,'INN348978SHOP12','1','2020-03-24 05:12:51','2020-03-24 05:12:51'),(3,'REYES DEL NORTE',1,NULL,'LOS REYES DEL NORTE S.A. de C.V.',NULL,2,'REYES020378NORTE','1','2020-03-24 05:13:35','2020-03-24 05:13:35'),(4,'INTERNATIONAL INN',2,NULL,'INTERNATIONAL S.A de C.V.',NULL,2,'INTE02039INN12','1','2020-03-27 21:10:11','2020-03-27 21:10:11');
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rastreo_rutas`
--

DROP TABLE IF EXISTS `rastreo_rutas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rastreo_rutas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_rastreo` int(11) NOT NULL,
  `latitud` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitud` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flujo_rastreo` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rastreo_rutas`
--

LOCK TABLES `rastreo_rutas` WRITE;
/*!40000 ALTER TABLE `rastreo_rutas` DISABLE KEYS */;
/*!40000 ALTER TABLE `rastreo_rutas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rastreos`
--

DROP TABLE IF EXISTS `rastreos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rastreos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_compromiso` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `inicio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rastreos`
--

LOCK TABLES `rastreos` WRITE;
/*!40000 ALTER TABLE `rastreos` DISABLE KEYS */;
/*!40000 ALTER TABLE `rastreos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rutas`
--

DROP TABLE IF EXISTS `rutas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rutas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora_inicio` datetime DEFAULT NULL,
  `hora_fin` datetime DEFAULT NULL,
  `id_compromiso` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutas`
--

LOCK TABLES `rutas` WRITE;
/*!40000 ALTER TABLE `rutas` DISABLE KEYS */;
/*!40000 ALTER TABLE `rutas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rutas_estaticas`
--

DROP TABLE IF EXISTS `rutas_estaticas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rutas_estaticas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_rastreo_rutas` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `latitud` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitud` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tiempo` datetime NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rutas_estaticas`
--

LOCK TABLES `rutas_estaticas` WRITE;
/*!40000 ALTER TABLE `rutas_estaticas` DISABLE KEYS */;
/*!40000 ALTER TABLE `rutas_estaticas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subzonas`
--

DROP TABLE IF EXISTS `subzonas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subzonas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_zona` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subzonas`
--

LOCK TABLES `subzonas` WRITE;
/*!40000 ALTER TABLE `subzonas` DISABLE KEYS */;
INSERT INTO `subzonas` VALUES (1,'Zona 1 Apodaca',1,1,NULL,NULL),(2,'Zona Xilithla centro',2,1,NULL,NULL);
/*!40000 ALTER TABLE `subzonas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sucursales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursales`
--

LOCK TABLES `sucursales` WRITE;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;
INSERT INTO `sucursales` VALUES (1,'GAMA MITRAS',1,'2020-03-14 05:38:21','2020-03-14 05:38:21'),(2,'GAMA TALLERES',1,'2020-03-14 05:38:27','2020-03-14 05:38:27'),(3,'GAMA FRESNILLO',1,'2020-03-14 05:38:40','2020-03-14 05:38:40');
/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_precios`
--

DROP TABLE IF EXISTS `tipos_precios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_precios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_precios`
--

LOCK TABLES `tipos_precios` WRITE;
/*!40000 ALTER TABLE `tipos_precios` DISABLE KEYS */;
INSERT INTO `tipos_precios` VALUES (1,'POR CAMPAÑA',1,'2020-03-20 03:55:20','2020-03-20 03:55:20'),(2,'POR TEMPORADA',1,'2020-03-20 03:55:31','2020-03-20 03:55:31'),(3,'PRECIO DE MERCADO',1,'2020-03-20 03:55:52','2020-03-20 03:55:52'),(4,'PRECIO POR CLIENTE',1,'2020-03-20 03:56:03','2020-03-20 03:56:03');
/*!40000 ALTER TABLE `tipos_precios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades`
--

LOCK TABLES `unidades` WRITE;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` VALUES (1,'Milimetros',1,'2020-03-13 09:43:06','2020-03-13 09:43:06'),(2,'Centimetros',1,'2020-03-13 09:44:33','2020-03-13 09:44:33');
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_correo_unique` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Edgar Geovani Tamez García','a04e377db11cae60a2e9fc3b7ef889f6','edgar.t@gamaetiquetas.com',NULL,NULL,1,1,NULL,1,'2020-03-14 05:05:03','2020-03-14 05:05:03'),(2,'Angel Escajeda','d2ff0b7686906bdbc2ea19e4e702a7c4','a.escajeda@gamaetiquetas.com',NULL,NULL,2,1,NULL,1,'2020-03-14 05:05:03','2020-03-14 05:05:03'),(3,'Luis Daniel Marquez Ramos','2b991bcbdfdb5ab3ff8d5ac6c45d344e','daniel.m@gamaetiquetas.com',NULL,NULL,3,2,NULL,1,'2020-03-27 02:15:23','2020-03-27 02:15:23'),(7,'Jose Francisco Avalos Cortez','2b991bcbdfdb5ab3ff8d5ac6c45d344e','avaloz@gamaetiquetas.com',NULL,NULL,3,3,NULL,1,'2020-04-20 21:59:19','2020-04-20 21:59:19'),(8,'Marco Moralez Tellez','2b991bcbdfdb5ab3ff8d5ac6c45d344e','tellez@gamaetiquetas.com',NULL,NULL,3,3,NULL,1,'2020-04-20 22:00:21','2020-04-20 22:00:21'),(9,'Jose Francisco Diaz','2b991bcbdfdb5ab3ff8d5ac6c45d344e','dias@gamaetiquetas.com',NULL,NULL,3,3,NULL,1,'2020-04-20 22:03:45','2020-04-20 22:03:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `enero` double(8,2) DEFAULT NULL,
  `febrero` double(8,2) DEFAULT NULL,
  `marzo` double(8,2) DEFAULT NULL,
  `abril` double(8,2) DEFAULT NULL,
  `mayo` double(8,2) DEFAULT NULL,
  `junio` double(8,2) DEFAULT NULL,
  `julio` double(8,2) DEFAULT NULL,
  `agosto` double(8,2) DEFAULT NULL,
  `septiembre` double(8,2) DEFAULT NULL,
  `octubre` double(8,2) DEFAULT NULL,
  `noviembre` double(8,2) DEFAULT NULL,
  `diciembre` double(8,2) DEFAULT NULL,
  `total_anual` double(8,2) DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zonas`
--

DROP TABLE IF EXISTS `zonas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zonas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zonas`
--

LOCK TABLES `zonas` WRITE;
/*!40000 ALTER TABLE `zonas` DISABLE KEYS */;
INSERT INTO `zonas` VALUES (1,'San Sebastian',1,1,'2020-04-26 02:23:21','2020-04-26 02:23:21');
/*!40000 ALTER TABLE `zonas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-27 10:53:11
