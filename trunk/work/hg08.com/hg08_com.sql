
DROP TABLE IF EXISTS `hg_admin`;
CREATE TABLE `hg_admin` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `realname` varchar(255) NOT NULL default '',
  `role` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台管理员';


INSERT INTO `hg_admin` VALUES (1,'admin','32bb79e5a88829bfd6b94085067ace49','超级管理员','','0000-00-00 00:00:00','2012-07-10 14:09:21',1);

DROP TABLE IF EXISTS `hg_admin_role`;
CREATE TABLE `hg_admin_role` (
  `admin_id` mediumint(9) unsigned NOT NULL,
  `role_id` mediumint(9) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;


DROP TABLE IF EXISTS `hg_album`;
CREATE TABLE `hg_album` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `view` int(10) unsigned NOT NULL default '0',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `hg_article`;
CREATE TABLE `hg_article` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` tinyint(3) NOT NULL default '0' COMMENT '类别',
  `title` varchar(255) NOT NULL default '' COMMENT '标题',
  `tags` varchar(255) NOT NULL default '' COMMENT '标签',
  `author` varchar(255) NOT NULL default '' COMMENT '作者',
  `summary` tinytext NOT NULL COMMENT '摘要',
  `content` text NOT NULL COMMENT '内容',
  `sort` smallint(5) NOT NULL default '0' COMMENT '显示排序',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '添加时间',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '修改时间',
  `view` int(11) unsigned NOT NULL default '0' COMMENT '查看次数',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章';


INSERT INTO `hg_article` VALUES (1,1,'公司文化','','','公司文化摘要','公司文化正文',2,'2012-07-09 16:25:22','2012-07-12 11:42:36',46,1);
INSERT INTO `hg_article` VALUES (2,1,'公司全景','','','公司全景摘要','公司全景正文',4,'2012-07-09 16:25:41','2012-07-12 11:42:52',10,1);
INSERT INTO `hg_article` VALUES (3,1,'公司团队','','','','',6,'2012-07-09 16:26:02','2012-07-09 16:26:02',3,1);
INSERT INTO `hg_article` VALUES (4,2,'关于顾客预告片的发布说明！','','','关于顾客预告片的发布说明摘要1','关于顾客预告片的发布说明正文1',8,'2012-07-09 16:27:40','2012-07-12 14:57:17',12,2);
INSERT INTO `hg_article` VALUES (5,2,'关于顾客预告片的发布说明！2','','','关于顾客预告片的发布说明摘要2','关于顾客预告片的发布说明正文2',10,'2012-07-09 16:27:51','2012-07-12 14:57:30',2,-1);
INSERT INTO `hg_article` VALUES (6,2,'关于顾客预告片的发布说明！3','','','','',12,'2012-07-09 16:28:18','2012-07-09 16:28:18',3,2);
INSERT INTO `hg_article` VALUES (7,2,'关于顾客预告片的发布说明！4','','','','',100,'2012-07-10 17:23:37','2012-07-10 17:23:37',3,1);
INSERT INTO `hg_article` VALUES (8,2,'关于顾客预告片的发布说明！5','','','','',100,'2012-07-10 17:29:41','2012-07-10 17:29:41',0,1);
INSERT INTO `hg_article` VALUES (9,2,'关于顾客预告片的发布说明！6','','','','',100,'2012-07-10 17:31:06','2012-07-10 17:31:06',0,1);
INSERT INTO `hg_article` VALUES (10,2,'关于顾客预告片的发布说明！7','','','','',100,'2012-07-10 17:31:23','2012-07-10 17:31:23',2,1);
INSERT INTO `hg_article` VALUES (11,2,'关于顾客预告片的发布说明！8','','','','',100,'2012-07-10 17:31:41','2012-07-10 17:31:41',1,1);


DROP TABLE IF EXISTS `hg_category`;
CREATE TABLE `hg_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '' COMMENT '酒店或文章',
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `sort` smallint(5) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='类别';


INSERT INTO `hg_category` VALUES (1,0,'Article','关于皇宫','about',0,1);
INSERT INTO `hg_category` VALUES (2,0,'Article','最新活动','news',0,1);
INSERT INTO `hg_category` VALUES (3,0,'Photo','顾客特照','',0,1);
INSERT INTO `hg_category` VALUES (4,0,'Album','摄影作品','works',0,1);
INSERT INTO `hg_category` VALUES (5,4,'Album','时尚婚纱','',0,1);
INSERT INTO `hg_category` VALUES (6,4,'Album','个人写真','',0,1);


DROP TABLE IF EXISTS `hg_client`;
CREATE TABLE `hg_client` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `project_id` smallint(5) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `hg_feedback`;
CREATE TABLE `hg_feedback` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `ip` varchar(255) NOT NULL default '',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `replytime` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='留言咨询';


DROP TABLE IF EXISTS `hg_node`;
CREATE TABLE `hg_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `hg_node` VALUES (1,0,'admin','后台管理','后台管理根节点',1,0);
INSERT INTO `hg_node` VALUES (6,1,'System','网站系统设置','',2,0);
INSERT INTO `hg_node` VALUES (7,6,'setting','网站参数设置','',3,0);
INSERT INTO `hg_node` VALUES (8,6,'flink','友情链接管理','',3,0);
INSERT INTO `hg_node` VALUES (9,1,'Index','默认首页','',2,0);
INSERT INTO `hg_node` VALUES (11,9,'index','默认首页','',3,0);
INSERT INTO `hg_node` VALUES (12,1,'Feedback','留言管理','',2,0);


DROP TABLE IF EXISTS `hg_photo`;
CREATE TABLE `hg_photo` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` smallint(5) unsigned NOT NULL default '0',
  `album_id` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `src` varchar(255) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `hg_project`;
CREATE TABLE `hg_project` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `hg_project` VALUES (1,'服务流程','<p>温馨提示一：</p>\r\n<p>感谢您选择皇宫婚纱摄影为您拍摄婚纱照、全家福、艺术套照等，为了给您提供更完美的服务，请您仔细阅读我们的服务流程。</p>\r\n<p>1、付款方式：本公司采用先付款后拍照，请您务必妥善保管好您的预约单，预约单上将清楚纪录您的付款情况，此单视同您的付款收据。若有准备额外消费的预算，可多带一些现金。</p>\r\n<p>2、拍摄前一晚，请提前就寝，睡眠充足，请勿多喝水及喝酒，以免眼睛红肿或精神不佳。</p>\r\n<p>3、安排预约时间后，请准时到店，以免不要之等待；拍摄时，请保持良好心态，遇到问题，可随时沟通。</p>\r\n<p>4、如果您对化妆品有过敏反应，请告诉本店服务人员；如新娘已怀有喜孕，请主动告之工作人员，以便为您提供更细致周到的服务。</p>\r\n<p>5、请依照排定时间日期到达，若有临时变故不能抵达本店，务必请拍照前一天通知本店服务人员。</p>\r\n<p>6、请勿携带其他贵重物品，若有遗失，本店概不负责。</p>\r\n<p>7、请勿携带照相机，录影机等，公司内部及外景禁止使用（同时禁止用手机拍摄）。</p>\r\n<p>8、拍摄当天请勿带任何亲戚朋友参观，因场地有限，更可避免影响拍摄过程及您俩的心情。</p>\r\n<p>9、请保管好单据，若有遗失不补发。</p>\r\n<p>10、在服务过程中，公司将提供部分选择性消费。</p>\r\n<p>11、在您预约完成后，我们会根据您的需要，事先为您安排化妆造型师和摄影师等专业服务人员。如果当天天气是阴天的话，我们就要按调度的安排才能确定是否可以拍摄外景，如果是阴雨天气，我们就可以安排拍摄内景，待天气转好后才能拍摄外景。</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 如有疑问、请询问门市部接待人员</p>',1,1);
INSERT INTO `hg_project` VALUES (2,'拍前提醒','<p>温馨提示二：</p>\r\n<p>1、早上拍摄的新人，请先用早餐，依预定时候到达本公司，请务必带好预约单及全额拍照款男女主角在拍摄当天，须与我们并肩合作，共同创造属于自己的幸福回忆。</p>\r\n<p>2、办理完拍摄手续后，将由本公司专业部流程主管及礼服部服务人员为您安排挑选婚纱礼服，在这个流程中请将您的个人爱好及特殊要求，与我们专业服务人员沟通，对您的服务，我们始终坚持最好！如果您有任何需要可以随时向您身边的工作人员取得联系。</p>\r\n<p>3、公司婚纱礼服是分区的，依预定的套系不同可挑选穿着的区域有所不同，本公司礼服部的工作人员会根据您的脸型、气质及要求为您提供参考意见，协助您选择试穿。</p>\r\n<p>4、拍照婚纱礼服以拍照效果为主，将会由礼服部服务人员为您事先准备，但因数量过多，无法一一修改，服装的尺寸过大或过小先则用别针固定。</p>\r\n<p>6、进入影棚拍摄前，如您对化妆造型或礼服有不尽满意之处，请立即当面明确向我们工作人员沟通，待您认为满意后，再进行拍摄，以有利于达到最佳的拍摄效果。</p>\r\n<p>7、在拍摄当天，所有的化妆、造型、礼服及拍摄等专业服务，均有公司艺术总监负责安排调整，若出现任何不称心之事，都可以向我们的调度进行说明与沟通，我们将及时为您解决。</p>\r\n<p>8、本公司有为您提供加锁的储物柜，请小心保管好钥匙，于拍摄结束后归还，特别提醒您拍摄当天请勿携带贵重物品，本公司不承担赔偿责任。</p>\r\n<p>9、外景拍摄，公司配有专用外景拍摄车辆接送，但不可携带亲友，以免拍摄时影响摄影师调动的情绪。</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp; 如果正遇结婚旺季，拍摄新人较多，全套结婚照拍摄需要一个整天的时间，拍摄过程中等候在所难免，请您耐心等待并保持良好的心情，以期达到最佳的拍摄效果。您在等候过程中，本公司有提供报刊杂志及电视放映，具体情况请询问服务人员，在拍摄过程中，为了追求最完美的效果，为了让您选出最佳的照片及给您提供更多的选择机会，摄影师会适量拍多一点底片，但是我们会根据套系限定拍摄数量，如果您有多买照片的预算，请提前和摄影师沟通。</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如有疑问、请询问门市部接待人员</p>',2,1);
INSERT INTO `hg_project` VALUES (3,'照片校色','<p>温馨提示三:</p>\r\n<p>您的照片正在校色当中。</p>\r\n<p>校色在婚纱艺术摄影是一个非常重要的环节，化妆、造型、美姿、灯光、拍摄等，都只是前期的一个创作过程，如果需要出成品（相片），还必须要把照片旋转调色及修整，调色过程根据我们的业务量的安排，大概需要3-7天时间，您的照片完成校色后我们会短信和电话通知您，和您确认具体选样的日期，您也可以登陆本公司网站客户端随时查询。</p>\r\n<p>温馨提示一：由于每个电子显示器的色彩会有所差异，您在电脑里看见的色彩会略有区别，属于正常现象。</p>\r\n<p>&nbsp;为了让您选出最好的照片，本公司已为您多拍了一定量的照片，未选之照片所有权归本公司所有，将由本公司收回作相关数据及技术统计处理，您可以通过购买小样或加选入册加做版页等方法，取得对未选照片的所有权。公司将视情况给与一定的优惠，并且公司定期推出的特惠套餐，可供您选择。如果您确定有特殊的原因需提前看样，本公司可为您提供加急。</p>\r\n<p>选片注意事项如下：</p>\r\n<p>1、请联系工作人员确定好具体时间，准时前来公司。</p>\r\n<p>2、请勿亲友陪同。</p>\r\n<p>3、为了合理的安排选样的流程，建议您在1.5-2小时内完成，以免影响他人选片时间，谢谢！</p>\r\n<p>4、工作人员有向您推荐新产品的义务，您有自由选择的权利。</p>\r\n<p>5、如果照片拍得很满意，可能您会想多点要点，最好多准备一些预支消费先进。</p>\r\n<p>6、请一次确定好您要的照片，果断决策。</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 如有疑问、请询问门市部接待人员</p>',3,1);


DROP TABLE IF EXISTS `hg_reserve`;
CREATE TABLE `hg_reserve` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `qq` varchar(255) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `remark` text NOT NULL,
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '创建时间',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='预订';



DROP TABLE IF EXISTS `hg_role`;
CREATE TABLE `hg_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


INSERT INTO `hg_role` VALUES (1,'后台管理根角色',1,'所有管理员都必须先赋予此角色');

DROP TABLE IF EXISTS `hg_role_node`;
CREATE TABLE `hg_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;


INSERT INTO `hg_role_node` VALUES (1,1);


