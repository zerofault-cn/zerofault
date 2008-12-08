 <?php
/**
* LeftnavAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');

class LeftnavAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中
        // 给forward增加参数(在进行页面跳转时使用)
        // $actionMap->addForwardParam('key_test','value_test','name_test');
        // 返回的forward是一个数组
        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');   
		session_start();
		$user = $_SESSION['user'];
		$response['user'] = $user;
		$u = new User();
		$u->GetByID($user['id']);
		
		$script = "var TREE_ITEMS = [\n";
		$script .= "\t['博客网', 'main.php?do=usermain',\n";
		
		$dao = DAO::CreateInstance();
		if($user['role_id']<=1)
		{
			//所有频道都可以管理
			$sql = "select * from channel where flag>0 order by id desc limit 0, 50";
		}
		else 
		{

			//只能管理具有权限的频道
			$channel_ids = $u->GetChannelIDs();
			$channel_num = count($channel_ids);
			$ids = "";
			for($i=0;$i<$channel_num;$i++)
			{
				$ids .= $channel_ids[$i]['channel_id'];
				if($i<($channel_num-1))
					$ids .= ", ";
			}
			$sql = "select * from channel where id in (" . $ids . ") order by id desc limit 0, 50";
		}
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		$script .= "\t\t['频道内容管理', null,\n";
		for($i=0;$i<$rows_num;$i++)
		{
			$script .= "\t\t\t['" . $rows[$i]['name'] . "', 'main.php?do=subject_list&channel_name=" . $rows[$i]['dir_name'] . "&channel_id=" . $rows[$i]['id'] . "',\n";
			if(($rows[$i]['dir_name'])=='group')
			{
				$script .= "\t\t\t['群组活动管理', 'main.php?do=group_party_list&channel_name=" . $rows[$i]['dir_name'] . "&channel_id=" . $rows[$i]['id'] . "',],\n";
			}
			$script .= "\t\t\t['投稿器附加管理', 'main.php?do=contribute_attach_list&channel_name=" . $rows[$i]['dir_name'] . "&channel_id=" . $rows[$i]['id'] . "',],\n";
			$script .= "\t\t\t['RSS内容源附加管理', 'main.php?do=feed_attach_list&channel_name=" . $rows[$i]['dir_name'] . "&channel_id=" . $rows[$i]['id'] . "',],\n";
			$script .= "\t\t\t['flash头图管理', 'main.php?do=flash_list&channel_name=" . $rows[$i]['dir_name'] . "&channel_id=" . $rows[$i]['id'] . "',],\n";
			
			//主站特殊格式flash管理交于zhuzhan用户管理，其他用户不予访问
			if( 45 == $rows[$i]['id'] && 99 == $user['id'] )
			{
				$script .= "\t\t\t['特殊格式flash管理', 'main.php?do=flash_list_new&channel_name=" . $rows[$i]['dir_name'] . "&channel_id=" . $rows[$i]['id'] . "',],\n";
			}
			else if( 45 != $rows[$i]['id'] )
			{
				$script .= "\t\t\t['特殊格式flash管理', 'main.php?do=flash_list_new&channel_name=" . $rows[$i]['dir_name'] . "&channel_id=" . $rows[$i]['id'] . "',],\n";
			}

			$script .= "\t\t\t['图片中心管理', 'main.php?do=photo_list&channel_name=" . $rows[$i]['dir_name'] . "&channel_id=" . $rows[$i]['id'] . "',],\n";
			$script .= "\t\t\t['模版复制', 'main.php?do=template_copy&channel_name=" . $rows[$i]['dir_name']  . "',],\n";
			
			/*
			$script .= "\t\t\t['include管理', 'main.php?do=include_list&channel_name=" . $rows[$i]['dir_name']  . "',],\n";
			*/
			$script .= $this->getSubChannel($rows[$i]['dir_name'], 0, 1);
			$script .= "\t\t\t],\n";
		}
		
		$script .= "\t\t],\n";
		
		//投稿器列表开始
		//add by zhuming at 20070418
		$script .="['投稿器内容管理', null,
			['所有频道', 'main.php?do=contribute_article_list&feed_id=0',],
			['娱乐', 'main.php?do=contribute_article_list&feed_id=68',],
			['体育', 'main.php?do=contribute_article_list&feed_id=69',],
			['女性', 'main.php?do=contribute_article_list&feed_id=70',],
			['科技', 'main.php?do=contribute_article_list&feed_id=71',],
			['经济', 'main.php?do=contribute_article_list&feed_id=72',],
			['文化', 'main.php?do=contribute_article_list&feed_id=73',],
			['生活', 'main.php?do=contribute_article_list&feed_id=74',],
			['情感', 'main.php?do=contribute_article_list&feed_id=76',],
			['教育', 'main.php?do=contribute_article_list&feed_id=77',],
			['传媒', 'main.php?do=contribute_article_list&feed_id=78',],
			['笑话', 'main.php?do=contribute_article_list&feed_id=79',],
			['健康', 'main.php?do=contribute_article_list&feed_id=80',],
			['社会', 'main.php?do=contribute_article_list&feed_id=81',],
			['文学', 'main.php?do=contribute_article_list&feed_id=82',],
			['军事', 'main.php?do=contribute_article_list&feed_id=83',],
			['奥运', 'main.php?do=contribute_article_list&feed_id=84',],
			['旅游', 'main.php?do=contribute_article_list&feed_id=85',],
			['数码·游戏', 'main.php?do=contribute_article_list&feed_id=86',],
			['图片', 'main.php?do=contribute_article_list&feed_id=87',],
			['视频', 'main.php?do=contribute_article_list&feed_id=88',],
			['时尚', 'main.php?do=contribute_article_list&feed_id=96',],
			['自建投稿器', null,
				['新闻线索', 'main.php?do=contribute_article_list&feed_id=6',],
				['生活频道-美食', 'main.php?do=contribute_article_list&feed_id=7',],
				['情侣博客文章推荐', 'main.php?do=contribute_article_list&feed_id=8',],
				['美女博客情感发泄', 'main.php?do=contribute_article_list&feed_id=9',],
				['产品体验', 'main.php?do=contribute_article_list&feed_id=10',],
				['美女文章推荐', 'main.php?do=contribute_article_list&feed_id=11',],
				['情感诉说', 'main.php?do=contribute_article_list&feed_id=12',],
				['妈妈宝宝秀', 'main.php?do=contribute_article_list&feed_id=13',],
				['网友推荐群组', 'main.php?do=contribute_article_list&feed_id=14',],
				['两性生活', 'main.php?do=contribute_article_list&feed_id=15',],
				['生活频道-休闲', 'main.php?do=contribute_article_list&feed_id=16',],
				['生活频道-消费', 'main.php?do=contribute_article_list&feed_id=17',],
				['生活频道-家居', 'main.php?do=contribute_article_list&feed_id=18',],
				['生活频道-宠物', 'main.php?do=contribute_article_list&feed_id=19',],
				['生活频道-星座', 'main.php?do=contribute_article_list&feed_id=20',],
				['SHOW大年', 'main.php?do=contribute_article_list&feed_id=21',],
				['博客专题', 'main.php?do=contribute_article_list&feed_id=22',],
				['世界杯-黄健翔事件', 'main.php?do=contribute_article_list&feed_id=89',],
				['走进西藏', 'main.php?do=contribute_article_list&feed_id=90',],
				['博客大集市', 'main.php?do=contribute_article_list&feed_id=91',],
				['健身之旅', 'main.php?do=contribute_article_list&feed_id=92',],
				['唐山大地震30年', 'main.php?do=contribute_article_list&feed_id=93',],
				['动漫', 'main.php?do=contribute_article_list&feed_id=94',],
				['[关爱女孩行动]征文', 'main.php?do=contribute_article_list&feed_id=95',],
				['奥德赛-紫色风暴体验正文', 'main.php?do=contribute_article_list&feed_id=97',],
				['博客群组互动话题', 'main.php?do=contribute_article_list&feed_id=98',],
				['新闻线索', 'main.php?do=contribute_article_list&feed_id=99',],
				['ASUS六面娇娃评选活动', 'main.php?do=contribute_article_list&feed_id=100',],
				['美凝访谈', 'main.php?do=contribute_article_list&feed_id=101',],
				['汽车频道', 'main.php?do=contribute_article_list&feed_id=102',],
				['企业', 'main.php?do=contribute_article_list&feed_id=104',],
			],
		],";
		/*
		$dao_contribute = DAO::CreateInstanceEmpty();
		if(!$dao_contribute->Connect('contribute', 'root', '10y9c2U5', '221.238.254.205'))
			die("connect error");
		$script .= "\t\t['投稿器内容管理', null,\n";
		$script .= "\t\t\t['所有频道', 'main.php?do=contribute_article_list&feed_id=0',],\n";
		$sql="select * from channel where sys_flag=1";
		$sys_channel=$dao_contribute->GetPlan($sql);
		for($i=0;$i<count($sys_channel);$i++)
		{
			$id=$sys_channel[$i]['id'];
			$name=$sys_channel[$i]['name'];
			$count=$sys_channel[$i]['article_count'];
			$script .= "\t\t\t['" . conv($name) . "', 'main.php?do=contribute_article_list&feed_id=" . $id. "',],\n";
		}
		$script .= "\t\t\t['自建投稿器', null,\n";
		$sql="select * from channel where sys_flag=0";
		$user_channel=$dao_contribute->GetPlan($sql);
		for($i=0;$i<count($user_channel);$i++)
		{
			$id=$user_channel[$i]['id'];
			$name=$user_channel[$i]['name'];
			$count=$user_channel[$i]['article_count'];
			$script .= "\t\t\t\t['" . conv($name) . "', 'main.php?do=contribute_article_list&feed_id=" . $id. "',],\n";
		}
		$script .= "\t\t\t],\n";
		$script .= "\t\t],\n";
		//投稿器列表结束
		*/
		/*
		//RSS Control Begin
		$dao_rss = DAO::CreateInstanceEmpty();
		if(!$dao_rss->Connect(RSS_DB_SCHEMA, RSS_DB_USERNAME, RSS_DB_PASSWORD, RSS_DB_HOST))
			die("connect error");
			
		// add user begin  modify by chengfeng 20060322 ,need  circle
		$script .= "\t\t['RSS内容管理', null,\n";
		$script .= "\t\t\t['精华内容', 'main.php?do=rss_article_list',],\n";
		$script .= "\t\t\t['所有订阅内容', 'main.php?do=root_feed_article_list',],\n";

		$rss_user_id = explode(',',$u->_rss_user_id);
		for ($k=0;$k<count($rss_user_id);$k++){
			$sql = "select * from feed_label where owner_id=" . trim($rss_user_id[$k]) . " and folder_id=0";
			$feeds = $dao_rss->GetPlan($sql);
			$feeds_num = count($feeds); 
			if (!empty($rss_user_id[$k])){		
				$script .= "\t\t\t['".trim($rss_user_id[$k])."', null,\n";
				$script .= "\t\t\t\t['默认分类', null,\n";
				for($i=0;$i<$feeds_num;$i++)
				{
					$feeds[$i]['title'] = str_replace('\'', '’', $feeds[$i]['title']);
					$script .= "\t\t\t\t\t['" . $feeds[$i]['title'] . "', 'main.php?do=feed_article_list&feed_id=" . $feeds[$i]['feed_id'] . "',],\n";
				}
				$script .= "\t\t\t\t],\n";
		
				$sql_folder = "select * from feed_label_folder where owner_id=" . trim($rss_user_id[$k]);
				$folders = $dao_rss->GetPlan($sql_folder);
				$folders_num = count($folders); 
				for($i=0;$i<$folders_num;$i++)
				{
					$script .= "\t\t\t\t['" . $folders[$i]['name'] .  "', null,\n";
					$sql = "select * from feed_label where owner_id=" . trim($rss_user_id[$k]) . " and folder_id=" . $folders[$i]['id'];
					$feeds = $dao_rss->GetPlan($sql);
					$feeds_num = count($feeds); 
					for($j=0;$j<$feeds_num;$j++)
					{
						$feeds[$j]['title'] = str_replace('\'', '’', $feeds[$j]['title']);
						$script .= "\t\t\t\t\t['" . $feeds[$j]['title'] . "', 'main.php?do=feed_article_list&feed_id=" . $feeds[$j]['feed_id'] . "',],\n";
					}
					$script .= "\t\t\t\t],\n";
				}
				$script .= "\t\t\t],\n";
				
			}
		}  unset($k); // 释放k
		// add user end  modify by chengfeng 20060322 
		$script .= "\t\t],\n";
		//RSS Control End
		*/
		if($user['role_id']<=1)
		{
			$script .= "\t\t['系统管理', null,\n";
			$script .= "\t\t\t['用户管理', 'main.php?do=user_list',	],\n";
			$script .= "\t\t\t['频道管理', 'main.php?do=channel_list',	],\n";
			$script .= "\t\t\t['定时管理', 'main.php?do=crontab_list',	],\n";
			$script .= "\t\t\t['合作媒体管理', 'main.php?do=coop_media_list',	],\n";
			$script .= "\t\t\t['错误日志', 'main.php?do=error_log_read',	],\n";
			$script .= "\t\t\t['定期执行日志', 'main.php?do=cron_log_read',	],\n";
			$script .= "\t\t\t['工作量统计', 'stat/tongji.php',	],\n";
			$script .= "\t\t],\n";
		}
		$script .= "\t\t['个人功能', null,\n";
		$script .= "\t\t\t['修改密码', 'main.php?do=user_modify_password',	],\n";
		$script .= "\t\t\t['修改RSS用户ID', 'main.php?do=rss_uid_modify',	],\n";
		$script .= "\t\t\t['工作统计', 'main.php?do=usermain',	],\n";
		$script .= "\t\t\t['退出系统', 'main.php?do=logout',	],\n";
		$script .= "\t\t],\n";
		$script .= "\t],\n";
		$script .= "];\n";
		$response['script'] = $script;
	}
	
	/**
	* @access private
	* @abstract 获递归取子栏目树状图代码
	*/
	function getSubChannel($dir_name, $parent_id=0, $level=1)
	{
		$db_name = "cms_" . $dir_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db_name);
		$sql = "select * from subject where parent_id=" . $parent_id . " and sort=" . $level . " order by id desc limit 0, 50";
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		$level++;
		$script = "";
		
		for($i=0;$i<$rows_num;$i++)
		{
			if ($rows[$i]['name']=="flash图片管理")
			{
			$script .= "\t\t\t['" . $rows[$i]['name'] . "', 'main.php?do=photo_list&channel_name=" . $dir_name . "&subject_id=" . $rows[$i]['id'] . "',\n";
			$script .= $this->getSubChannel($dir_name, $rows[$i]['id'], $level);
			$script .= "\t\t\t],\n";
			}else{
			$script .= "\t\t\t['" . $rows[$i]['name'] . "', 'main.php?do=article_list&channel_name=" . $dir_name . "&subject_id=" . $rows[$i]['id'] . "',\n";
			$script .= $this->getSubChannel($dir_name, $rows[$i]['id'], $level);
			$script .= "\t\t\t],\n";
			}
		}
		return $script;
	}
}
function conv($str)
{
	return mb_convert_encoding($str,"utf-8","utf-8,gbk,gb2312");
}
?>