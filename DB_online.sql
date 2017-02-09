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
  `pro_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '在线创作产品id',
  `serial` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `cate` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '样片类型：1电视剧，2电影，3微电影，4广告，5宣传片，6专题片，7汇报片，8主题片，9纪录片，10晚会，11淘宝视频，12婚纱摄影，13节日聚会，14个人短片，',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `uname` varchar(50) NOT NULL COMMENT '用户名称，便于搜索',
  `format` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '输出格式：1网络版640*480，2标清720*576，3小高清1280*720，4高清1920*1080',
  `money1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应支付金额，单位元',
  `money2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已支付金额，单位元',
  `weal` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已支付福利，单位元',
  `thumb` varchar(255) NOT NULL COMMENT '缩略图',
  `linkType` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '视频链接类型：1Flash代码，2html代码，3通用代码，4其他网址链接',
  `link` varchar(255) NOT NULL COMMENT '视频链接',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订单状态：1待定价，待打款，款不对或过期，已付款处理中，已处理待评价，评价不好，好评并返利',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '前台列表是否显示：1不显示，2显示，默认2',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表 orders';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pro_frame`
--

DROP TABLE IF EXISTS `pro_frame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pro_frame` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pro_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `layerid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '动画设置id',
  `tf_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对应模板关键帧id',
  `attr` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '属性选择：1水平距离，2垂直距离，3透明度，4旋转，5缩放',
  `per` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '动画点，单位%',
  `val` int(11) NOT NULL DEFAULT '0' COMMENT '属性值，单位（1、2=>px，3、5=>无，4=>deg）',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='产品关键帧表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_frame`
--

LOCK TABLES `pro_frame` WRITE;
/*!40000 ALTER TABLE `pro_frame` DISABLE KEYS */;
INSERT INTO `pro_frame` VALUES (1,1,1,1,1,0,0,1486624529,0),(2,1,1,8,1,100,500,1486624529,0),(3,1,1,9,3,0,0,1486624529,0),(4,1,1,10,3,100,100,1486624529,0);
/*!40000 ALTER TABLE `pro_frame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pro_layer`
--

DROP TABLE IF EXISTS `pro_layer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pro_layer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '动画层名称',
  `a_name` varchar(30) NOT NULL COMMENT '动画名称，系统自动添加，layer_+用户id_+产品id_+10000随机值',
  `pro_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `tl_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对应模板动画层id',
  `timelong` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '动画时长，单位秒(s)',
  `delay` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '开始延时秒数，单位秒s',
  `con` varchar(255) NOT NULL COMMENT '图层内容：iscon内容类型(1文字，2图片)，text文字，img图片链接',
  `attr` varchar(1000) NOT NULL,
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '动画中是否显示：1不显示，2显示',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='在线创作动画层表：在线写的动画';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_layer`
--

LOCK TABLES `pro_layer` WRITE;
/*!40000 ALTER TABLE `pro_layer` DISABLE KEYS */;
INSERT INTO `pro_layer` VALUES (1,'动画测试','layer_1_1_7571',1,1,5.00,0.00,'','a:13:{s:5:\"width\";s:3:\"300\";s:6:\"height\";s:3:\"100\";s:8:\"isborder\";s:1:\"1\";s:7:\"border1\";s:1:\"1\";s:7:\"border2\";s:1:\"3\";s:7:\"border3\";s:7:\"#ff0000\";s:4:\"isbg\";s:1:\"1\";s:2:\"bg\";s:7:\"#ffffff\";s:7:\"iscolor\";s:1:\"1\";s:5:\"color\";s:7:\"#ff0000\";s:8:\"fontsize\";s:2:\"16\";s:7:\"isbigbg\";s:1:\"0\";s:5:\"bigbg\";s:7:\"#9a9a9a\";}',2,1486624529,0);
/*!40000 ALTER TABLE `pro_layer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '视频名称',
  `cate` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '样片类型：1电视剧，2电影，3微电影，4广告，5宣传片，6专题片，7汇报片，8主题片，9纪录片，10晚会，11淘宝视频，12婚纱摄影，13个人短片，',
  `tempid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板id',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提供者：需求用户，设计师，公司',
  `uname` varchar(20) NOT NULL COMMENT '用户名称',
  `intro` varchar(1000) NOT NULL COMMENT '视频简介',
  `thumb` varchar(255) NOT NULL COMMENT '缩略图',
  `linkType` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '视频链接类型：1Flash代码，2html代码，3通用代码，4其他网址链接',
  `link` varchar(255) NOT NULL COMMENT '预览视频链接',
  `attr` varchar(255) NOT NULL COMMENT '背景，颜色值',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '前台列表是否显示：0所有，1不显示，2显示',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='在线视频表：在线写的模板';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'模板测试',1,1,1,'jiuge','测试测试','http://online.jiugewenhua.com/uploads/images/2017-02-08/589ab3f13d0cc.jpg',2,'<embed src=\"http://player.pptv.com/v/khZ089VnXpzicfeU.swf\" quality=\"high\" width=\"480\" height=\"400\" bgcolor=\"#000\" align=\"middle\" allowScriptAccess=\"always\" allownetworking=\"all\" allowfullscreen=\"true\" type=\"application/x-shockwave-flash\" wmode=\"direct\" />','',2,1486624529,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='模板关键帧表';
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
  `attr` varchar(1000) NOT NULL COMMENT '样式属性：大背景bigbg，宽width，高height，边框(isborder0无，1有；border1厚度；border3颜色)，背景色bg，文字颜色fontcolor，文字大小fontsize，',
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
INSERT INTO `temp_pro` VALUES (1,'模板测试','AE_20170107101552725',1,'测试测试','http://online.jiugewenhua.com/uploads/images/2017-02-08/589ab3f13d0cc.jpg',2,'<embed src=\"http://player.pptv.com/v/khZ089VnXpzicfeU.swf\" quality=\"high\" width=\"480\" height=\"400\" bgcolor=\"#000\" align=\"middle\" allowScriptAccess=\"always\" allownetworking=\"all\" allowfullscreen=\"true\" type=\"application/x-shockwave-flash\" wmode=\"direct\" />','',2,1483755352,1486533617);
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

-- Dump completed on 2017-02-09 21:23:41
