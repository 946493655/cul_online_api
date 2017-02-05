-- MySQL dump 10.13  Distrib 5.6.27, for Linux (i686)
--
-- Host: localhost    Database: cul_online
-- ------------------------------------------------------
-- Server version	5.6.27

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
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '在线创作产品id',
  `serial` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `genre` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型：1有在线模板，2只有离线模板，3无模板',
  `cate` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '样片类型：1电视剧，2电影，3微电影，4广告，5宣传片，6专题片，7汇报片，8主题片，9纪录片，10晚会，11淘宝视频，12婚纱摄影，13节日聚会，14个人短片，',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `uname` varchar(50) NOT NULL COMMENT '用户名称，便于搜索',
  `format` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '输出格式：',
  `money1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应支付金额，单位元',
  `money2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已支付金额，单位元',
  `weal` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已支付福利，单位元',
  `record` varchar(3000) NOT NULL COMMENT '更新的记录，序列化存储：\r\n动画设置的添加layerAdd、更新layerEdit；\r\n关键帧的添加layerAttrAdd、更新layerAttrEdit；\r\n内容得添加conAdd、更新conEdit；\r\n属性样式更新attrEdit；',
  `thumb` varchar(255) NOT NULL COMMENT '缩略图',
  `linkType` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '视频链接类型：1Flash代码，2html代码，3通用代码，4其他网址链接',
  `link` varchar(255) NOT NULL COMMENT '视频链接',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订单状态：1待定价，待打款，款不对或过期，已付款处理中，已处理待评价，评价不好，好评并返利',
  `isshow` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '前台列表是否显示：1不显示，2显示，默认2',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='订单表 orders';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,10,'201610051408034436',1,1,1,'jiuge',1,0,0,0,'','',1,'2',7,2,1475647683,1475805230),(7,10,'201610160928136080',2,1,1,'jiuge',1,0,0,0,'更换图片','',1,'0',2,2,1476581293,0),(10,14,'201610171742188306',3,1,1,'jiuge',1,0,0,0,'fbfgbnfgnhgfn','',1,'0',2,2,1476697338,0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pro_attr`
--

DROP TABLE IF EXISTS `pro_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pro_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品表id，关联bs_products',
  `layerid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '动画设置id',
  `name` varchar(255) NOT NULL COMMENT '样式简称',
  `style_name` varchar(20) NOT NULL COMMENT '类样式名称，加个前缀好区分==》改为自动添加，用户ID+产品id+属性id',
  `genre` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '属性类型：1图层开始，pos图层定位，2dh动画层',
  `padding` varchar(15) NOT NULL COMMENT '内边距，单位px：\r\n类型，0无，1(上下左右)，2(上下、左右)，3(上、下、左、右)；\r\npadType，pad1，pad2，pad3，pad4，pad5，pad6，pad7，',
  `size` varchar(10) NOT NULL COMMENT '宽度，高度，单位px，空则没有，中间逗号隔开',
  `pos` varchar(255) NOT NULL COMMENT '定位方式，左边距离，顶部距离：\r\n定位方式，0没有，1relative相对定位；\r\n左边距离，空则没有，相对定位时有效，单位px；\r\n顶部距离，空则没有，相对定位时有效，单位px',
  `float` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '浮动对齐：0没有，1左对齐，2右对齐',
  `opacity` varchar(5) NOT NULL COMMENT '透明度，格式(判断,值)，中间逗号隔开：判断(0无，1有)，值(透明0-100透明)',
  `border` varchar(50) NOT NULL COMMENT '边框，格式(判断,距离,类型,色值)：判断有无边框(0无1有)，距离单位px，类型选择，色值填写',
  `record` varchar(255) NOT NULL COMMENT '修改过的属性记录，序列化存储，0未修改1已修改：padding，size，pos，float，opacity，border',
  `bg` varchar(20) NOT NULL COMMENT '背景，格式(类型,值)：类型纯色或图片，值色值或pic_id',
  `text` varchar(255) NOT NULL COMMENT '文字属性集合，逗号隔开：\r\ncolor给出几个选项，\r\nfont-size（数值，单位px），\r\ntext-align（left左、中center、右right方式），\r\nline-height（数字，单位px），',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='在线创作div类样式属性表：在线写的属性';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_attr`
--

LOCK TABLES `pro_attr` WRITE;
/*!40000 ALTER TABLE `pro_attr` DISABLE KEYS */;
INSERT INTO `pro_attr` VALUES (1,2,1,'样式11','attr_2_81',1,'','720,405','0,,',1,'0,0','0,,1,1','','','',1474722160,1474872749),(2,2,1,'样式11','attr_2_81',2,'','720,405','1,,405',0,'0,0','0,,1,1','','','',1474723783,1474871935),(3,2,1,'样式11','attr_2_81',3,'',',405','0,,',0,'0,0','0,,1,1','','','',1474808252,1474871954),(25,10,14,'样式11','attr_142555',1,'','720,405','0,,',1,'0,0','0,,1,1','','','',1475032379,0),(26,10,14,'样式11','attr_142555',2,'','720,405','1,,405',0,'0,0','0,,1,1','a:6:{s:4:\"size\";i:0;s:7:\"padding\";i:1;s:6:\"border\";i:1;s:3:\"pos\";i:1;s:5:\"float\";i:0;s:7:\"opacity\";i:1;}','','',1475032379,1475568104),(27,10,14,'样式11','attr_142555',3,'',',405','0,,',0,'0,0','0,,1,1','','','',1475032379,0);
/*!40000 ALTER TABLE `pro_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pro_con`
--

DROP TABLE IF EXISTS `pro_con`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pro_con` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `layerid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '动画设置id',
  `genre` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '发布者身份：1图片，2文字',
  `pic_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片，关联图片表bs_pics',
  `name` varchar(255) NOT NULL COMMENT '文字内容',
  `record` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型、图片、文字修改记录，0未修改1已修改',
  `is_add` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否也会添加的：0系统添加，1用户首次添加，2用户修改',
  `sort` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '排序字段，值越大越靠前，默认10',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示：0不显示，1显示',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='在线创作的图片文字表 bs_products_con';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_con`
--

LOCK TABLES `pro_con` WRITE;
/*!40000 ALTER TABLE `pro_con` DISABLE KEYS */;
INSERT INTO `pro_con` VALUES (1,2,1,1,1,'12345',0,0,10,1,1474525576,1474808731),(23,10,14,1,1,'12345',0,0,10,1,1475032379,0);
/*!40000 ALTER TABLE `pro_con` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pro_layer`
--

DROP TABLE IF EXISTS `pro_layer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pro_layer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '动画层名称',
  `productid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `a_name` varchar(255) NOT NULL COMMENT '动画名称，系统自动添加，act_+用户id_+产品id_+动画id',
  `timelong` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '动画时长，单位秒(s)',
  `func` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '速度曲线：linear匀速，ease默认慢快慢，ease-in低速开始，ease-out低速结束，ease-in-out低速开始和结束，cubic-bezier(n,n,n,n)贝塞尔函数自定义',
  `delay` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '开始延时秒数，单位秒s',
  `record` varchar(100) NOT NULL COMMENT '修改的记录，序列化存储，0未修改1已修改：timelong，func，delay',
  `is_add` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否也会添加的：0系统添加，1用户首次添加，2用户修改',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='在线创作动画层表：在线写的动画';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_layer`
--

LOCK TABLES `pro_layer` WRITE;
/*!40000 ALTER TABLE `pro_layer` DISABLE KEYS */;
INSERT INTO `pro_layer` VALUES (1,'动画设置11',2,'layer_2_9930',2.00,1,0.00,'',0,1474714196,1474881677),(14,'动画设置22',10,'layer_2_9930',3.00,1,0.00,'a:3:{s:5:\"delay\";i:0;s:8:\"timelong\";i:0;s:4:\"func\";i:0;}',2,1475032379,1475560153);
/*!40000 ALTER TABLE `pro_layer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pro_layer_attr`
--

DROP TABLE IF EXISTS `pro_layer_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pro_layer_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `layerid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '动画id，关联动画表bs_products_layer',
  `attrSel` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '属性选择：1=》高度，宽度，左边距，顶边距，透明度',
  `per` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '动画点，单位%',
  `val` smallint(5) NOT NULL DEFAULT '0' COMMENT '属性值',
  `record` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '修改的记录，0未修改1已修改',
  `is_add` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否也会添加的：0系统添加，1用户首次添加，2用户修改',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='在线创作动画层表：在线写的动画';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_layer_attr`
--

LOCK TABLES `pro_layer_attr` WRITE;
/*!40000 ALTER TABLE `pro_layer_attr` DISABLE KEYS */;
INSERT INTO `pro_layer_attr` VALUES (1,2,1,4,0,405,0,0,1474720357,1474884651),(2,2,1,5,70,100,0,0,1474886792,1474941851),(3,2,1,4,20,0,0,0,1474940463,0),(4,2,1,3,70,0,0,0,1474940585,1474940990),(5,2,1,4,100,0,0,0,1474941119,0),(6,2,1,3,100,-200,0,0,1474941905,0),(7,2,1,5,100,0,0,0,1474942102,0),(43,10,14,4,0,405,0,0,1475032379,0),(44,10,14,5,70,100,0,0,1475032379,0),(45,10,14,4,20,0,0,0,1475032379,0),(46,10,14,3,70,0,1,0,1475032379,0),(47,10,14,4,100,0,0,0,1475032379,0),(48,10,14,3,100,-200,0,0,1475032379,0),(49,10,14,5,100,0,0,0,1475032379,0);
/*!40000 ALTER TABLE `pro_layer_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '视频名称',
  `serial` varchar(20) NOT NULL COMMENT '编号，唯一标识：年月日时分秒+随机值',
  `cate` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '样片类型：1电视剧，2电影，3微电影，4广告，5宣传片，6专题片，7汇报片，8主题片，9纪录片，10晚会，11淘宝视频，12婚纱摄影，13个人短片，',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提供者：需求用户，设计师，公司',
  `uname` varchar(20) NOT NULL COMMENT '用户名称',
  `intro` varchar(1000) NOT NULL COMMENT '视频简介',
  `thumb` varchar(255) NOT NULL COMMENT '缩略图',
  `linkType` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '视频链接类型：1Flash代码，2html代码，3通用代码，4其他网址链接',
  `link` varchar(255) NOT NULL COMMENT '预览视频链接',
  `tempid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板id',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '前台列表是否显示：0所有，1不显示，2显示',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='在线视频表：在线写的模板';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (2,'产品333','201609221742345260',1,1,'','而沟通与法规和若干个','http://online.jiugewenhua.com/uploads/images/2017-01-05/586e12342d6be.jpg',4,'https://baidu.com',1,2,20160512,1483608628);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_frame`
--

DROP TABLE IF EXISTS `temp_frame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_frame` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tempid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板id',
  `layerid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '动画设置id',
  `attr` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '属性选择：1水平距离，2垂直距离，3透明度，4旋转，5缩放',
  `per` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '动画点，单位%',
  `val` int(11) NOT NULL DEFAULT '0' COMMENT '属性值，单位（1、2=>px，3、5=>无，4=>deg）',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='产品模板关键帧表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_frame`
--

LOCK TABLES `temp_frame` WRITE;
/*!40000 ALTER TABLE `temp_frame` DISABLE KEYS */;
INSERT INTO `temp_frame` VALUES (1,1,1,1,0,0,1484720633,1485957631),(8,1,1,1,100,500,1486011314,0),(9,1,1,3,0,0,1486207893,0),(10,1,1,3,100,100,1486208359,0);
/*!40000 ALTER TABLE `temp_frame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_layer`
--

DROP TABLE IF EXISTS `temp_layer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_layer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '动画层名称',
  `tempid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板id',
  `a_name` varchar(20) NOT NULL COMMENT '动画名称，系统自动添加，layer_+模板id_+10000随机值',
  `delay` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始延时秒数，单位秒s',
  `timelong` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '动画时长，单位秒(s)',
  `con` varchar(255) NOT NULL COMMENT '图层内容：iscon内容类型(1文字，2图片)，text文字，img图片链接',
  `attr` varchar(1000) NOT NULL COMMENT '样式属性：宽width，高height，边框(isborder0无，1有；border1厚度；border3颜色)，背景色bg，文字颜色fontcolor，文字大小fontsize，大背景bigbg',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '动画中是否显示：1不显示，2显示',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='产品模板动画层表：模板的动画设置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_layer`
--

LOCK TABLES `temp_layer` WRITE;
/*!40000 ALTER TABLE `temp_layer` DISABLE KEYS */;
INSERT INTO `temp_layer` VALUES (1,'动画测试',1,'layer_1_3553',0,5,'','a:13:{s:5:\"width\";s:3:\"300\";s:6:\"height\";s:3:\"100\";s:8:\"isborder\";s:1:\"1\";s:7:\"border1\";s:1:\"1\";s:7:\"border2\";s:1:\"3\";s:7:\"border3\";s:7:\"#ff0000\";s:4:\"isbg\";s:1:\"1\";s:2:\"bg\";s:7:\"#ffffff\";s:7:\"iscolor\";s:1:\"1\";s:5:\"color\";s:7:\"#ff0000\";s:8:\"fontsize\";s:2:\"16\";s:7:\"isbigbg\";s:1:\"0\";s:5:\"bigbg\";s:7:\"#9a9a9a\";}',2,1484105370,1486178163);
/*!40000 ALTER TABLE `temp_layer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_pro`
--

DROP TABLE IF EXISTS `temp_pro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_pro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '视频名称',
  `serial` varchar(20) NOT NULL COMMENT '模板编号',
  `cate` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '样片类型：1电视剧，2电影，3微电影，4广告，5宣传片，6专题片，7汇报片，8主题片，9纪录片，10晚会，11淘宝视频，12婚纱摄影，13个人短片，',
  `intro` varchar(1000) NOT NULL COMMENT '视频简介',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `linkType` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '视频链接类型：1Flash代码，2html代码，3通用代码，4其他网址链接',
  `link` varchar(255) NOT NULL COMMENT '预览视频链接',
  `attr` varchar(255) NOT NULL COMMENT '背景，颜色值',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否显示：1不显示，2显示',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='在线创作模板';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_pro`
--

LOCK TABLES `temp_pro` WRITE;
/*!40000 ALTER TABLE `temp_pro` DISABLE KEYS */;
INSERT INTO `temp_pro` VALUES (1,'模板测试','AE_20170107101552725',1,'测试测试','http://online.jiugewenhua.com/uploads/images/2017-02-05/589719c94c081.jpg',4,'https://le.com','',2,1483755352,1486298781);
/*!40000 ALTER TABLE `temp_pro` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-05 22:23:21
