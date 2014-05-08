-- MySQL dump 10.13  Distrib 5.5.33, for osx10.6 (i386)
--
-- Host: localhost    Database: dw_peppol_1_dlp
-- ------------------------------------------------------
-- Server version	5.5.33

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
-- Table structure for table `tbl_banners`
--

DROP TABLE IF EXISTS `tbl_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_image` varchar(255) NOT NULL,
  `id_sort` int(10) unsigned NOT NULL,
  `id_position` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_banners`
--

LOCK TABLES `tbl_banners` WRITE;
/*!40000 ALTER TABLE `tbl_banners` DISABLE KEYS */;
INSERT INTO `tbl_banners` VALUES (29,'94',2,0,'​McAfee Web Gateway','/products/mcafee_web_gateway','Обеспечивает всестороннюю защиту и контроль web-трафика вашей компании. Позволяет вам просто и эффективно контролировать и управлять доступом пользователей к ресурсам Интернет.'),(30,'95',4,0,'McAfee Network Security Platform','/products/mcafee_network_security_platform','Уникальное решение интеллектуальной защиты, предназначенное для обнаружения и блокирования изощренных сетевых угроз. '),(31,'96',6,0,'Mcafee Host Data Loss Prevention','/products/mcafee_host_data_loss_prevention','Управляйте способом отправки конфиденциальных данных, получения доступа к ним, печати, передачи по сети и через приложения, а также сохранения на устройствах хранения.'),(32,'97',2,1,'yandex.ru','yandex.ru','');
/*!40000 ALTER TABLE `tbl_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_bug_messages`
--

DROP TABLE IF EXISTS `tbl_bug_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bug_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_bug` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bug_messages`
--

LOCK TABLES `tbl_bug_messages` WRITE;
/*!40000 ALTER TABLE `tbl_bug_messages` DISABLE KEYS */;
INSERT INTO `tbl_bug_messages` VALUES (103,34,41,1386654600,'Статус изменен на \"Готово\"'),(104,33,41,1386654609,'Статус изменен на \"Готово\"'),(105,35,1,1386655191,'Статус изменен на \"В работе\"'),(106,35,1,1386655205,'Нужно связаться с верстальщиком'),(107,35,1,1386655221,'Статус изменен на \"Готово\"'),(108,35,41,1386655261,'Статус изменен на \"Закрыто\"'),(109,34,41,1386655279,'Статус изменен на \"Закрыто\"'),(110,33,41,1386655297,'Статус изменен на \"Закрыто\"'),(111,37,1,1387177478,'Статус изменен на \"Готово\"'),(112,36,1,1387177499,'Статус изменен на \"Готово\"');
/*!40000 ALTER TABLE `tbl_bug_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_bugs`
--

DROP TABLE IF EXISTS `tbl_bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bugs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `id_priority` int(10) unsigned NOT NULL,
  `id_state` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `reply` text NOT NULL,
  `id_user` varchar(45) NOT NULL,
  `time_detected` int(10) unsigned NOT NULL,
  `time_done` int(10) unsigned NOT NULL,
  `id_type` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bugs`
--

LOCK TABLES `tbl_bugs` WRITE;
/*!40000 ALTER TABLE `tbl_bugs` DISABLE KEYS */;
INSERT INTO `tbl_bugs` VALUES (33,'Убрать листалку','http://dbg2.deka-web.ru/contacts',0,30,'Убрать листалку с этой страницы. И сделать так, чтобы показ листалки на обычных страницах настраивался.','','41',1386619200,1386655297,0),(34,'Баннеры в правую колонку','http://dbg2.deka-web.ru/cp/banners/admin/admin',0,30,'','','41',1386619200,1386655279,1),(35,'Сделать резину','http://dbg2.deka-web.ru',1,30,'','','41',1386619200,1386655261,0),(36,'миниатюры плохо работают','http://dbg2.deka-web.ru',0,20,'','','41',1387137600,0,0),(37,'на витрине не краткое описание а название','http://dbg2.deka-web.ru',0,20,'','','41',1387137600,0,0);
/*!40000 ALTER TABLE `tbl_bugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_feedback`
--

DROP TABLE IF EXISTS `tbl_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tst_create` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `flg_new` tinyint(1) unsigned NOT NULL,
  `flg_phonecall` int(11) NOT NULL,
  `phone` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_feedback`
--

LOCK TABLES `tbl_feedback` WRITE;
/*!40000 ALTER TABLE `tbl_feedback` DISABLE KEYS */;
INSERT INTO `tbl_feedback` VALUES (17,1386576890,'Превед','tishurin@yandex.ru','',0,0,''),(18,1386577412,'Дмитрий','tishurin@yandex.ru','Мое сообщение - можно ли то-то',0,0,'123-23-23'),(19,1386577463,'Дмитрий','tishurin@yandex.ru','Мое сообщение - можно ли то-то',0,0,'123-23-23'),(20,1386577481,'Дмитрий','tishurin@yandex.ru','Мое сообщение - можно ли то-то',0,0,'123-23-23'),(21,1386577524,'Дмитрий','tishurin@yandex.ru','Мое сообщение - можно ли то-то',0,0,'123-23-23'),(22,1386579929,'Дмитрий','','',0,1,'926-355-96-83');
/*!40000 ALTER TABLE `tbl_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_files`
--

DROP TABLE IF EXISTS `tbl_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `tst_upload` int(10) unsigned NOT NULL,
  `flg_folder` int(10) unsigned NOT NULL,
  `id_parent` int(10) unsigned NOT NULL,
  `flg_image` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_files`
--

LOCK TABLES `tbl_files` WRITE;
/*!40000 ALTER TABLE `tbl_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pages`
--

DROP TABLE IF EXISTS `tbl_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) unsigned NOT NULL,
  `id_sort` int(10) unsigned NOT NULL,
  `id_image` int(11) NOT NULL,
  `tst_create` int(10) unsigned NOT NULL,
  `tst_update` int(10) unsigned NOT NULL,
  `flg_public` int(10) unsigned NOT NULL,
  `flg_folder` int(10) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `areas` text NOT NULL,
  `flg_block_header` int(10) unsigned NOT NULL,
  `flg_block_text` int(10) unsigned NOT NULL,
  `flg_markdown` int(10) unsigned NOT NULL,
  `flg_menu` int(11) NOT NULL,
  `flg_index` int(11) NOT NULL,
  `flg_show_news` int(11) NOT NULL,
  `flg_show_slider` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pages`
--

LOCK TABLES `tbl_pages` WRITE;
/*!40000 ALTER TABLE `tbl_pages` DISABLE KEYS */;
INSERT INTO `tbl_pages` VALUES (118,117,2,0,1399233600,1399272518,1,0,'1','Электронные счета в Норвегии, история успеха','','[default]','','С более чем 10.000 государственного и частного сектора в обмен свыше 2,7','','',0,0,0,0,0,1,1),(114,0,2,0,1399233600,1399272007,1,1,'additional','Дополнительно','additional','[default]','','','','',0,0,0,0,0,1,1),(119,117,4,0,1399233600,1399272508,1,0,'2','Электронные счета в Норвегии, история успеха','','[default]','','С более чем 10.000 государственного и частного сектора в обмен свыше 2,7 млн. электронных счетов-фактур','','',0,0,0,0,0,1,1),(120,113,2,0,1399233600,1399273025,1,0,'komponenti_peppol','Компоненты Peppol','','[default]','','PEPPOL базируется на трех основных \"китах\": сети (PEPPOL Транспортной Инфраструктуры), документ спецификации (PEPPOL Бизнес Iinteroperability технические Характеристики-BIS) правовая база, которая определяет сетевого управления (PEPPOL Транспортной Инфраструктуры Соглашений)','','',0,0,0,0,0,1,1),(121,113,4,0,1399233600,1399273040,1,0,'komponenti_peppol_2','Компоненты Peppol 2','','[default]','','PEPPOL базируется на трех основных \"китах\": сети (PEPPOL Транспортной Инфраструктуры), документ спецификации (PEPPOL Бизнес Iinteroperability технические Характеристики-BIS) правовая база, которая определяет сетевого управления (PEPPOL Транспортной Инфраструктуры Соглашений)','','',0,0,0,0,0,1,1),(115,114,2,0,1399233600,1399271968,1,0,'dopolnitelnii_razdel','Дополнительный раздел','','[default]','','','','',0,0,0,0,0,1,1),(116,114,4,0,1399233600,1399271974,1,0,'eshe_odin_razdel','Еще один раздел','','[default]','','','','',0,0,0,0,0,1,1),(117,0,6,0,1399233600,1399272948,1,1,'news','Новости','news','viewNews','','','','',0,0,0,1,0,1,1),(113,0,14,0,1399233600,1399273004,1,1,'index','Главная','index','viewPage','','','<p>\r\n	    OpenPEPPOL – это некоммерческая ассоциация, учрежденная Европейскими правительствами в сентябре 2012 г. вслед за успешным завершением проекта PEPPOL. Целью ассоциации является дальнейшее внедрение стандартизированных решений для электронных закупок, использующих спецификации PEPPOL, и продвижение передового опыта.\r\n</p>\r\n<p>\r\n	    PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. Подключившись к ЗАО \"Национальный удостоверяющий центр\" (далее – НУЦ России).\r\n</p>\r\n<p>\r\n	<img src=\"images/temp/275x208.jpg\" alt=\"\" class=\"right\">\r\n</p>\r\n<h3>Заголовок Н3</h3>\r\n<p>\r\n	    Ожидается, что это расширит деловые перспективы и повысит конкуренцию. Кроме того, данный проект будет способствовать <a href=\"\">ссылка</a> спецификаций PEPPOL, применяемых в отношениях B2B и B2C, на другие сферы деятельности.\r\n</p>\r\n<h2>Заголовок H2</h2>\r\n<p>\r\n	    НУЦ России с 2009 года активно занимается проблемами доверенного трансграничного электронного взаимодействия. Специалисты НУЦ <a href=\"\">ссылка при наведении</a> ведомствами Российской\r\n</p>\r\n<ul>\r\n	<li>Параллельно с участием в разработке концептуальных подходов НУЦ России занимается вопросами практического решения задач доверенного трансграничного электронного взаимодействия.</li>\r\n	<li>Параллельно с участием в разработке концептуальных подходов НУЦ России занимается вопросами практического решения задач доверенного трансграничного электронного взаимодействия.</li>\r\n</ul>\r\n<ol>\r\n	<li>Параллельно с участием в разработке концептуальных подходов НУЦ России занимается вопросами практического решения задач доверенного трансграничного электронного взаимодействия.</li>\r\n	<li>Параллельно с участием в разработке концептуальных подходов НУЦ России занимается вопросами практического решения задач доверенного трансграничного электронного взаимодействия.</li>\r\n</ol>\r\n    PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. Подключившись к ЗАО \"Национальный удостоверяющий центр\" (далее – НУЦ России).PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. Подключившись к ЗАО \"Национальный удостоверяющий центр\" (далее – НУЦ России).PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. Подключившись к ЗАО\r\n<table class=\"left\">\r\n<thead>\r\n<tr>\r\n	<th>\r\n		    Таблица\r\n	</th>\r\n	<td>\r\n		    Столбец\r\n	</td>\r\n	<td>\r\n		    Столбец\r\n	</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n	<th>\r\n		    Строка\r\n	</th>\r\n	<td>\r\n		    Ячейка\r\n	</td>\r\n	<td>\r\n		    Ячейка\r\n	</td>\r\n</tr>\r\n<tr>\r\n	<th>\r\n		    Строка на две <br>\r\n		    строки\r\n	</th>\r\n	<td>\r\n		    Ячейка на две <br>\r\n		    строки\r\n	</td>\r\n	<td>\r\n		    Ячейка на две <br>\r\n		    строки\r\n	</td>\r\n</tr>\r\n<tr>\r\n	<th>\r\n		    Строка\r\n	</th>\r\n	<td>\r\n		    Ячейка\r\n	</td>\r\n	<td>\r\n		    Ячейка\r\n	</td>\r\n</tr>\r\n<tr>\r\n	<th>\r\n		    Строка\r\n	</th>\r\n	<td>\r\n		    Ячейка\r\n	</td>\r\n	<td>\r\n		    Ячейка\r\n	</td>\r\n</tr>\r\n<tr>\r\n	<th>\r\n		    Строка\r\n	</th>\r\n	<td>\r\n		    Ячейка\r\n	</td>\r\n	<td>\r\n		    Ячейка\r\n	</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>\r\n	     \"Национальный удостоверяющий центр\" (далее – НУЦ России).PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок.\r\n</p>','',0,0,0,1,0,1,1),(106,0,12,0,1399233600,1399270227,1,0,'about','О проекте','','[default]','','','','',0,0,0,1,0,1,1),(107,0,10,0,1399233600,1399270103,1,1,'open_peppol','Open PEPPOL','','[default]','','','','',0,0,0,1,0,1,1),(108,107,2,0,1399233600,1399270141,1,0,'pervii_razdel','Первый раздел','','[default]','','','','',0,0,0,1,0,1,1),(109,107,4,0,1399233600,1399270135,1,0,'vtoroi_razdel','Второй раздел','','[default]','','','','',0,0,0,1,0,1,1),(110,107,6,0,1399233600,1399270125,1,0,'tretii_razdel','Третий раздел','','[default]','','','','',0,0,0,1,0,1,1),(111,0,8,0,1399233600,1399270862,1,0,'components','Компоненты PEPPOL','','[default]','','','<p>OpenPEPPOL – это некоммерческая ассоциация, учрежденная Европейскими правительствами в сентябре 2012 г. вслед за успешным завершением проекта PEPPOL. Целью ассоциации является дальнейшее внедрение стандартизированных решений для электронных закупок, использующих спецификации PEPPOL, и продвижение передового опыта.</p>\r\n								<p>PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. Подключившись к ЗАО &quot;Национальный удостоверяющий центр&quot; (далее – НУЦ России).</p>\r\n								<img src=\"images/temp/275x208.jpg\" alt=\"\" class=\"right\">\r\n								<h3>Заголовок Н3</h3>\r\n								<p>Ожидается, что это расширит деловые перспективы и повысит конкуренцию. Кроме того, данный проект будет способствовать <a href=\"\">ссылка</a> спецификаций PEPPOL, применяемых в отношениях B2B и B2C, на другие сферы деятельности.</p>\r\n								<h2>Заголовок H2</h2>\r\n								<p>НУЦ России с 2009 года активно занимается проблемами доверенного трансграничного электронного взаимодействия. Специалисты НУЦ <a href=\"\">ссылка при наведении</a> ведомствами Российской </p>\r\n								<ul>\r\n									<li>Параллельно с участием в разработке концептуальных подходов НУЦ России занимается вопросами практического решения задач доверенного трансграничного электронного взаимодействия.</li>\r\n									<li>Параллельно с участием в разработке концептуальных подходов НУЦ России занимается вопросами практического решения задач доверенного трансграничного электронного взаимодействия.</li>\r\n								</ul>\r\n								<ol>\r\n									<li>Параллельно с участием в разработке концептуальных подходов НУЦ России занимается вопросами практического решения задач доверенного трансграничного электронного взаимодействия.</li>\r\n									<li>Параллельно с участием в разработке концептуальных подходов НУЦ России занимается вопросами практического решения задач доверенного трансграничного электронного взаимодействия.</li>\r\n								</ol>\r\n								<p>PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. Подключившись к ЗАО &quot;Национальный удостоверяющий центр&quot; (далее – НУЦ России).PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. Подключившись к ЗАО &quot;Национальный удостоверяющий центр&quot; (далее – НУЦ России).PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. Подключившись к ЗАО</p>\r\n								<table class=\"left\">\r\n									<thead>\r\n										<tr>\r\n											<th>Таблица</th>\r\n											<td>Столбец</td>\r\n											<td>Столбец</td>\r\n										</tr>\r\n									</thead>\r\n									<tbody>\r\n										<tr>\r\n											<th>Строка</th>\r\n											<td>Ячейка</td>\r\n											<td>Ячейка</td>\r\n										</tr>\r\n										<tr>\r\n											<th>Строка на две <br>строки</th>\r\n											<td>Ячейка на две <br>строки</td>\r\n											<td>Ячейка на две <br>строки</td>\r\n										</tr>\r\n										<tr>\r\n											<th>Строка</th>\r\n											<td>Ячейка</td>\r\n											<td>Ячейка</td>\r\n										</tr>\r\n										<tr>\r\n											<th>Строка</th>\r\n											<td>Ячейка</td>\r\n											<td>Ячейка</td>\r\n										</tr>\r\n										<tr>\r\n											<th>Строка</th>\r\n											<td>Ячейка</td>\r\n											<td>Ячейка</td>\r\n										</tr>\r\n									</tbody>\r\n								</table>\r\n								<p> &quot;Национальный удостоверяющий центр&quot; (далее – НУЦ России).PEPPOL обеспечивает простое электронное взаимодействие бизнеса со всем Европейским государственным сектором в процессах государственных закупок. </p>\r\n						','',0,0,0,1,0,1,1),(112,0,4,0,1399233600,1399271596,1,0,'contacts','Контакты','contacts','[default]','','','<p>\r\n	Этот текст можно редактировать из контрольной панели\r\n</p>','',0,0,0,1,0,1,1);
/*!40000 ALTER TABLE `tbl_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pages_files`
--

DROP TABLE IF EXISTS `tbl_pages_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pages_files` (
  `id_page` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_file` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_page`,`id_file`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pages_files`
--

LOCK TABLES `tbl_pages_files` WRITE;
/*!40000 ALTER TABLE `tbl_pages_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pages_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url_role` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `flg_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` VALUES (1,'root','Дмитрий','root','6e047c439ea6860ace82c6ab7df718de','32ae28982e674c71fb57a1235f880350','',1),(41,'root','Виталий','vvt','c4510c1b4a0156f462f49aaf99f5538b','f6aded2be46c3e603d22f7702a82a1c8','',1),(42,'administrator','abiton','abiton','5edcdc7a4ef85d271fc951ae3211ab98','d801bf9597fa03eb5a3bf53f5ed3e764','abiton@yandex.ru',1);
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-05 11:13:03
