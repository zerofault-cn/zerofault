<?php
// ----------- Action Map Configuration -------- //
$ACTION_CONFIGS = array(
    'index'=>array( 
        'path'          =>  'index',
        'type'          =>  'IndexAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'index.tpl', 
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'cron_template_publish'=>array( 
        'path'          =>  'cron_template_publish',
        'type'          =>  'CronTemplatePublishAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'cron_end_level_template_publish'=>array( 
        'path'          =>  'cron_end_level_template_publish',
        'type'          =>  'CronEndLevelTemplatePublishAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'test'=>array( 
        'path'          =>  'test',
        'type'          =>  'TestAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'test.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'error_log_read'=>array( 
        'path'          =>  'error_log_read',
        'type'          =>  'ErrorLogReadAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'error_log_read.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'cron_log_read'=>array( 
        'path'          =>  'cron_log_read',
        'type'          =>  'CronLogReadAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'cron_log_read.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'login'=>array( 
    		'path'=>'login',
	        'type'=>'LoginAction',
	        'validate'=>true,
	        'name'=>'loginForm',
	        'input'=>'login.tpl',
	        'forwards'=>array(
	            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
	            'success'=>array('name'=>'success','path'=>'main.php?do=frame','redirct'=>true),
	            'failure'=>array('name'=>'failure','path'=>'login.tpl'),
	        )
        ),
	'frame'=>array( 
        'path'          =>  'frame',
        'type'          =>  'FrameAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'frame.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'failure'=> array('name'=>'failure','path'=>'main.php?do=login','redirct'=>true)
			)
        ),
    'leftnav'=>array( 
        'path'          =>  'leftnav',
        'type'          =>  'LeftnavAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'leftnav.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'usermain'=>array( 
        'path'          =>  'usermain',
        'type'          =>  'UsermainAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'usermain.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
     'photo_list'=>array( 
        'path'          =>  'photo_list',
        'type'          =>  'PhotoListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'photo_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'photo_add'=>array( 
        'path'          =>  'photo_add',
        'type'          =>  'PhotoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'photo_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'photo_do_add'=>array( 
        'path'          =>  'photo_do_add',
        'type'          =>  'PhotoDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'photo_modify'=>array( 
        'path'          =>  'photo_modify',
        'type'          =>  'PhotoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'photo_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'photo_do_modify'=>array( 
        'path'          =>  'photo_do_modify',
        'type'          =>  'PhotoDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'photo_delete'=>array( 
        'path'          =>  'photo_delete',
        'type'          =>  'PhotoDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'page_num_clear'=>array( 
        'path'          =>  'page_num_clear',
        'type'          =>  'PageNumClear',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'rss_uid_modify'=>array( 
        'path'          =>  'rss_uid_modify',
        'type'          =>  'RSSUserIDModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'rss_uid_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'rss_uid_do_modify'=>array( 
        'path'          =>  'rss_uid_do_modify',
        'type'          =>  'RSSUserIDDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=usermain','redirct'=>true)
			)
        ),
    'rss_article_do_add'=>array( 
        'path'          =>  'rss_article_do_add',
        'type'          =>  'RSSArticleDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'feed_article_list'=>array( 
        'path'          =>  'feed_article_list',
        'type'          =>  'FeedArticleListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'feed_article_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'contribute_article_list'=>array( 
        'path'          =>  'contribute_article_list',
        'type'          =>  'ContributeArticleListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'contribute_article_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'feed_article_transfer'=>array( 
        'path'          =>  'feed_article_transfer',
        'type'          =>  'FeedArticleTransferAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'feed_article_transfer.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'contribute_article_transfer'=>array( 
        'path'          =>  'contribute_article_transfer',
        'type'          =>  'ContributeArticleTransferAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'contribute_article_transfer.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
     'feed_article_do_transfer'=>array( 
        'path'          =>  'feed_article_do_transfer',
        'type'          =>  'FeedArticleDoTransferAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
     'contribute_article_do_transfer'=>array( 
        'path'          =>  'contribute_article_do_transfer',
        'type'          =>  'ContributeArticleDoTransferAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'feed_transfer_record'=>array( 
        'path'          =>  'feed_transfer_record',
        'type'          =>  'FeedTransferRecordAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'feed_transfer_record.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'feed_attach_to_subject'=>array( 
        'path'          =>  'feed_attach_to_subject',
        'type'          =>  'FeedAttachToSubjectAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'feed_attach_to_subject.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'contribute_attach_to_subject'=>array( 
        'path'          =>  'contribute_attach_to_subject',
        'type'          =>  'ContributeAttachToSubjectAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'contribute_attach_to_subject.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'feed_do_attach_to_subject'=>array( 
        'path'          =>  'feed_do_attach_to_subject',
        'type'          =>  'FeedDoAttachToSubjectAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'contribute_do_attach_to_subject'=>array( 
        'path'          =>  'contribute_do_attach_to_subject',
        'type'          =>  'ContributeDoAttachToSubjectAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'feed_attach_list'=>array( 
        'path'          =>  'feed_attach_list',
        'type'          =>  'FeedAttachListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'feed_attach_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'feed_attach_delete'=>array( 
        'path'          =>  'feed_attach_delete',
        'type'          =>  'FeedAttachDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'contribute_attach_list'=>array(
		'path'          =>  'contribute_attach_list',
        'type'          =>  'ContributeAttachListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'contribute_attach_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'flash_list'=>array( 
        'path'          =>  'flash_list',
        'type'          =>  'FlashListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'flash_add'=>array( 
        'path'          =>  'flash_add',
        'type'          =>  'FlashAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'flash_do_add'=>array( 
        'path'          =>  'flash_do_add',
        'type'          =>  'FlashDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'flash_delete'=>array( 
        'path'          =>  'flash_delete',
        'type'          =>  'FlashDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'flash_edit'=>array( 
        'path'          =>  'flash_edit',
        'type'          =>  'FlashEditAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_edit.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'flash_do_edit'=>array( 
        'path'          =>  'flash_do_edit',
        'type'          =>  'FlashDoEditAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
	 'flash_pic_delete'=>array( 
        'path'          =>  'flash_pic_delete',
        'type'          =>  'FlashPicDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
	'flash_pic_add'=>array( 
        'path'          =>  'flash_pic_add',
        'type'          =>  'FlashPicAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_pic_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
	'flash_pic_do_add'=>array( 
        'path'          =>  'flash_pic_do_add',
        'type'          =>  'FlashPicDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'rss_article_list'=>array( 
        'path'          =>  'rss_article_list',
        'type'          =>  'RSSArticleListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'rss_article_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'root_feed_article_list'=>array( 
        'path'          =>  'root_feed_article_list',
        'type'          =>  'RootFeedArticleListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'root_feed_article_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'article_comment_feed_back'=>array( 
        'path'          =>  'article_comment_feed_back',
        'type'          =>  'ArticleCommentFeedBackAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'article_group_list'=>array( 
        'path'          =>  'article_group_list',
        'type'          =>  'ArticleGroupListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_group_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
     'article_group_remove'=>array( 
        'path'          =>  'article_group_remove',
        'type'          =>  'ArticleGroupRemoveAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	 'article_group_add'=>array( 
        'path'          =>  'article_group_add',
        'type'          =>  'ArticleGroupAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_group_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'article_group_do_add'=>array( 
        'path'          =>  'article_group_do_add',
        'type'          =>  'ArticleGroupDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'article_group_modify'=>array( 
        'path'          =>  'article_group_modify',
        'type'          =>  'ArticleGroupModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_group_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'article_group_do_modify'=>array( 
        'path'          =>  'article_group_do_modify',
        'type'          =>  'ArticleGroupDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	 'article_group_delete'=>array( 
        'path'          =>  'article_group_delete',
        'type'          =>  'ArticleGroupDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	
    'article_list'=>array( 
        'path'          =>  'article_list',
        'type'          =>  'ArticleListAction',
        'validate'      =>  true,
        'name'          =>  'articleListForm',
        'input'         =>  'article_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'article_list_for_group'=>array( 
        'path'          =>  'article_list_for_group',
        'type'          =>  'ArticleListAction',
        'validate'      =>  true,
        'name'          =>  'articleListForm',
        'input'         =>  'article_list_for_group.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'group_party_list'=>array( 
        'path'          =>  'group_party_list',
        'type'          =>  'GroupPartyListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'group_party_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'group_party_update'=>array( 
        'path'          =>  'group_party_update',
        'type'          =>  'GroupPartyUpdateAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'rss_article_list_serch'=>array( 
        'path'          =>  'rss_article_list_serch',
        'type'          =>  'RSSArticleListSerchAction',
        'validate'      =>  false,
        'name'          =>  'rssArticleListSerchForm',
        'input'         =>  'rss_article_list_serch.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'rss_article_transfer'=>array( 
        'path'          =>  'rss_article_transfer',
        'type'          =>  'RSSArticleTransferAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'rss_article_transfer.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
     'rss_article_do_transfer'=>array( 
        'path'          =>  'rss_article_do_add',
        'type'          =>  'RSSArticleDoTransferAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
	'rss_article_copy'=>array( 
        'path'          =>  'rss_article_copy',
        'type'          =>  'RSSArticleCopyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'rss_article_copy.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
     'rss_article_do_copy'=>array( 
        'path'          =>  'rss_article_do_copy',
        'type'          =>  'RSSArticleDoCopyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'article_add'=>array( 
        'path'          =>  'article_add',
        'type'          =>  'ArticleAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'article_add_for_group'=>array( 
        'path'          =>  'article_add_for_group',
        'type'          =>  'ArticleAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_add_for_group.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
     'subject_select'=>array( 
        'path'          =>  'subject_select',
        'type'          =>  'SubjectSelectAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'subject_select.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),    
    'article_do_add'=>array( 
        'path'          =>  'article_do_add',
        'type'          =>  'ArticleDoAddAction',
        'validate'      =>  true,
        'name'          =>  'articleDoAddForm',
        'input'         =>  'article_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=article_list','redirct'=>true),
	        'failure'=> array('name'=>'failure','path'=>'article_add.tpl'),
			)
        ),
	'article_do_add1'=>array( 
        'path'          =>  'article_do_add1',
        'type'          =>  'ArticleDoAddAction1',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=article_list','redirct'=>true),
	        'failure'=> array('name'=>'failure','path'=>'article_add.tpl'),
			)
        ),

  'article_modify'=>array( 
        'path'          =>  'article_modify',
        'type'          =>  'ArticleModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
  'article_modify_for_group'=>array( 
        'path'          =>  'article_modify_for_group',
        'type'          =>  'ArticleModifyForGroupAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_modify_for_group.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),  'article_do_modify'=>array( 
        'path'          =>  'article_do_modify',
        'type'          =>  'ArticleDoModifyAction',
        'validate'      =>  true,
        'name'          =>  'articleDoModifyForm',
        'input'         =>  'article_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=article_list','redirct'=>true),
	        'failure'=>array('name'=>'failure','path'=>'article_modify.tpl'),
			)
        ),
	'article_delete'=>array( 
        'path'          =>  'article_delete',
        'type'          =>  'ArticleDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'login'=> array('name'=>'login','path'=>'main.php?do=login','redirct'=>true),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=article_list','redirct'=>true),
			)
        ),
    'rel_article_delete'=>array( 
        'path'          =>  'rel_article_delete',
        'type'          =>  'RelArticleDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'article_delete_group'=>array( 
        'path'          =>  'article_delete_group',
        'type'          =>  'ArticleDeleteGroupAction',
        'validate'      =>  true,
        'name'          =>  'articleDeleteGroupForm',
        'input'         =>  'delete_group.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'login'=>   array('name'=>'login','path'=>'main.php?do=login','redirct'=>true),
            'sysError'=>array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
	'article_time_modify'=>array( 
        'path'          =>  'article_time_modify',
        'type'          =>  'ArticleTimeModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_time_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'article_time_do_modify'=>array( 
        'path'          =>  'article_time_do_modify',
        'type'          =>  'ArticleTimeDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'coop_media_list'=>array( 
        'path'          =>  'coop_media_list',
        'type'          =>  'CoopMediaListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'coop_media_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'coop_media_add'=>array( 
        'path'          =>  'coop_media_add',
        'type'          =>  'CoopMediaAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'coop_media_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'coop_media_do_add'=>array( 
        'path'          =>  'coop_media_do_add',
        'type'          =>  'CoopMediaDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=coop_media_list','redirct'=>true)
			)
        ),
	'coop_media_modify'=>array( 
        'path'          =>  'coop_media_modify',
        'type'          =>  'CoopMediaModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'coop_media_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'coop_media_do_modify'=>array( 
        'path'          =>  'coop_media_do_modify',
        'type'          =>  'CoopMediaDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=coop_media_list','redirct'=>true)
			)
        ),
	'coop_media_delete'=>array( 
        'path'          =>  'coop_media_delete',
        'type'          =>  'CoopMediaDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=coop_media_list','redirct'=>true)
			)
        ),
	// xml manage begin
	'rss_blogmark_list'=>array( 
        'path'          =>  'rss_blogmark_list',
        'type'          =>  'RssBlogmarkListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=rss_blogmark_list','redirct'=>true),
            'failure'=>array('name'=>'failure','path'=>'main.php?do=login','redirct'=>true)
			)
		),
	'rss_bbs_list'=>array( 
        'path'          =>  'rss_bbs_list',
        'type'          =>  'RssBbsListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=rss_bbs_list','redirct'=>true),
            'failure'=>array('name'=>'failure','path'=>'main.php?do=login','redirct'=>true)
			)
		),
	'rss_rss_list'=>array( 
        'path'          =>  'rss_rss_list',
        'type'          =>  'RssRssListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=rss_rss_list','redirct'=>true),
            'failure'=>array('name'=>'failure','path'=>'main.php?do=login','redirct'=>true)
			)
		),
	// xml manage end
	'crontab_list'=>array( 
        'path'          =>  'crontab_list',
        'type'          =>  'CrontabListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'crontab_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'crontab_modify'=>array( 
        'path'          =>  'crontab_modify',
        'type'          =>  'CrontabModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'crontab_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'crontab_do_modify'=>array( 
        'path'          =>  'crontab_do_modify',
        'type'          =>  'CrontabDoModifyAction',
        'validate'      =>  true,
        'name'          =>  'crontabDoModifyForm',
        'input'         =>  'crontab_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=crontab_list','redirct'=>true),
	        'failure'=>array('name'=>'failure','path'=>'crontab_modify.tpl'),
			)
        ),
    'include_list'=>array( 
        'path'          =>  'include_list',
        'type'          =>  'IncludeListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'include_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'include_modify'=>array( 
        'path'          =>  'include_modify',
        'type'          =>  'IncludeModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'include_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'include_do_modify'=>array( 
        'path'          =>  'include_do_modify',
        'type'          =>  'IncludeDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=include_list','redirct'=>true)
			)
        ),
    'include_add'=>array( 
        'path'          =>  'include_add',
        'type'          =>  'IncludeAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'include_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'include_do_add'=>array( 
        'path'          =>  'include_do_add',
        'type'          =>  'IncludeDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=include_list','redirct'=>true)
			)
        ),
	'include_delete'=>array( 
        'path'          =>  'include_delete',
        'type'          =>  'IncludeDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=include_list','redirct'=>true)
			)
        ),
    'special_add'=>array( 
        'path'          =>  'special_add',
        'type'          =>  'SpecialAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'special_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'special_list'=>array( 
        'path'          =>  'special_list',
        'type'          =>  'SpecialListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'special_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'subject_list'=>array( 
        'path'          =>  'subject_list',
        'type'          =>  'SubjectListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'subject_list_new.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'subject_serch_do'=>array( 
        'path'          =>  'subject_serch_do',
        'type'          =>  'SubjectSerchDoAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'subject_serch_do.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ), 
    'subject_add'=>array( 
        'path'          =>  'subject_add',
        'type'          =>  'SubjectAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'subject_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'subject_do_add'=>array( 
        'path'          =>  'subject_do_add',
        'type'          =>  'SubjectDoAddAction',
        'validate'      =>  true,
        'name'          =>  'subjectDoAddForm',
        'input'         =>  'subject_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=subject_list','redirct'=>true),
	        'failure'=>array('name'=>'failure','path'=>'subject_add.tpl'),
			)
        ),
	'subject_modify'=>array( 
        'path'          =>  'subject_modify',
        'type'          =>  'SubjectModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'subject_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'subject_do_modify'=>array( 
        'path'          =>  'subject_do_modify',
        'type'          =>  'SubjectDoModifyAction',
        'validate'      =>  true,
        'name'          =>  'subjectDoModifyForm',
        'input'         =>  'subject_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=subject_list','redirct'=>true),
	        'failure'=>array('name'=>'failure','path'=>'subject_modify.tpl'),
			)
        ),
	'subject_delete'=>array( 
        'path'          =>  'subject_delete',
        'type'          =>  'SubjectDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=subject_list','redirct'=>true)
			)
        ),

    'user_list'=>array( 
        'path'          =>  'user_list',
        'type'          =>  'UserListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'user_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'user_add'=>array( 
        'path'          =>  'user_add',
        'type'          =>  'UserAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'user_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'user_do_add'=>array( 
        'path'          =>  'user_do_add',
        'type'          =>  'UserDoAddAction',
        'validate'      =>  true,
        'name'          =>  'userDoAddForm',
        'input'         =>  'user_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'success'=> array('name'=>'success','path'=>'main.php?do=user_list','redirct'=>true),
        	'failure'=> array('name'=>'failure','path'=>'user_add.tpl'),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'user_modify'=>array( 
        'path'          =>  'user_modify',
        'type'          =>  'UserModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'user_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'user_do_modify'=>array( 
        'path'          =>  'user_do_modify',
        'type'          =>  'UserDoModifyAction',
        'validate'      =>  true,
        'name'          =>  'userDoModifyForm',
        'input'         =>  'user_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'success'=> array('name'=>'success','path'=>'main.php?do=user_list','redirct'=>true),
        	'failure'=> array('name'=>'failure','path'=>'user_modify.tpl'),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'user_delete'=>array( 
        'path'          =>  'user_delete',
        'type'          =>  'UserDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'success'=> array('name'=>'success','path'=>'main.php?do=user_list','redirct'=>true),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'channel_list'=>array( 
        'path'          =>  'channel_list',
        'type'          =>  'ChannelListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'channel_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'channel_add'=>array( 
        'path'          =>  'channel_add',
        'type'          =>  'ChannelAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'channel_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'channel_do_add'=>array( 
        'path'          =>  'channel_do_add',
        'type'          =>  'ChannelDoAddAction',
        'validate'      =>  true,
        'name'          =>  'channelDoAddForm',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'success'=> array('name'=>'success','path'=>'main.php?do=channel_list','redirct'=>true),
        	'failure'=> array('name'=>'failure','path'=>'channel_add.tpl'),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'channel_delete'=>array( 
        'path'          =>  'channel_delete',
        'type'          =>  'ChannelDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'success'=> array('name'=>'success','path'=>'main.php?do=channel_list','redirct'=>true),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'user_modify_password'=>array( 
        'path'          =>  'user_modify_password',
        'type'          =>  'UserModifyPasswordAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'user_modify_password.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'user_do_modify_password'=>array( 
        'path'          =>  'user_do_modify_password',
        'type'          =>  'UserDoModifyPasswordAction',
        'validate'      =>  true,
        'name'          =>  'userDoModifyPasswordForm',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
       		'success'=> array('name'=>'success','path'=>'main.php?do=usermain','redirct'=>true),
       		'failure'=> array('name'=>'failure','path'=>'user_modify_password.tpl'),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'logout'=>array( 
        'path'          =>  'logout',
        'type'          =>  'LogoutAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'logout.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true)
			)
        ),
	'template_list'=>array( 
        'path'          =>  'template_list',
        'type'          =>  'TemplateListAction',
        'validate'      =>  true,
        'name'          =>  'templateListForm',
        'input'         =>  'template_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'template_add'=>array( 
        'path'          =>  'template_add',
        'type'          =>  'TemplateAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'template_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'template_new_add'=>array( 
        'path'          =>  'template_new_add',
        'type'          =>  'TemplateNewAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'template_new_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'template_do_add'=>array( 
        'path'          =>  'template_do_add',
        'type'          =>  'TemplateDoAddAction',
        'validate'      =>  true,
        'name'          =>  'templateDoAddForm',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'failure'=> array('name'=>'failure','path'=>'template_add.tpl'),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'template_new_do_add'=>array( 
        'path'          =>  'template_new_do_add',
        'type'          =>  'TemplateNewDoAddAction',
        'validate'      =>  true,
        'name'          =>  'templateDoAddForm',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'failure'=> array('name'=>'failure','path'=>'template_new_add.tpl'),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'template_modify'=>array( 
        'path'          =>  'template_modify',
        'type'          =>  'TemplateModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'template_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),	
    'template_modify_Look'=>array( 
        'path'          =>  'template_modify_Look',
        'type'          =>  'TemplateModifyLookAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'template_modify_Look.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),	
    'template_do_modify'=>array( 
        'path'          =>  'template_do_modify',
        'type'          =>  'TemplateDoModifyAction',
        'validate'      =>  true,
        'name'          =>  'templateDoModifyForm',
        'input'         =>  'template_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
	        'failure'=>array('name'=>'failure','path'=>'template_modify.tpl'),
			)
        ),
    'template_edit'=>array( 
        'path'          =>  'template_edit',
        'type'          =>  'TemplateEditAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'template_edit.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),	
    'template_do_edit'=>array( 
        'path'          =>  'template_do_edit',
        'type'          =>  'TemplateDoEditAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'template_delete'=>array( 
        'path'          =>  'template_delete',
        'type'          =>  'TemplateDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'template_publish'=>array( 
        'path'          =>  'template_publish',
        'type'          =>  'TemplatePublishAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'template_preview'=>array( 
        'path'          =>  'template_preview',
        'type'          =>  'TemplatePreviewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'template_copy'=>array( 
        'path'          =>  'template_copy',
        'type'          =>  'TemplateCopyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'template_copy.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'template_do_copy'=>array( 
        'path'          =>  'template_do_copy',
        'type'          =>  'TemplateDoCopyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'template_copy_subject'=>array( 
        'path'          =>  'template_copy_subject',
        'type'          =>  'TemplateCopySubjectAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'template_copy_subject.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'template_local_do_copy'=>array( 
        'path'          =>  'template_local_do_copy',
        'type'          =>  'TemplateLocalDoCopyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'slash_delete'=>array( 
        'path'          =>  'slash_delete',
        'type'          =>  'SlashDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'slash_do_modify'=>array( 
        'path'          =>  'slash_do_modify',
        'type'          =>  'SlashDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'slash_do_edit'=>array( 
        'path'          =>  'slash_do_edit',
        'type'          =>  'SlashDoEditAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'slash_name_modify'=>array( 
        'path'          =>  'slash_name_modify',
        'type'          =>  'SlashNameModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'slash_name_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
     'slash_name_do_modify'=>array( 
        'path'          =>  'slash_name_do_modify',
        'type'          =>  'SlashNameDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_add'=>array( 
        'path'          =>  'addBlock',
        'type'          =>  'BlockAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_new_add'=>array( 
        'path'          =>  'block_new_add',
        'type'          =>  'BlockNewAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block_new_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_new_do_add'=>array( 
        'path'          =>  'block_new_do_add',
        'type'          =>  'BlockNewDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_edit'=>array( 
        'path'          =>  'editBlock',
        'type'          =>  'BlockAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_modify'=>array( 
        'path'          =>  'block_modify',
        'type'          =>  'BlockModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_do_modify'=>array( 
        'path'          =>  'block_do_modify',
        'type'          =>  'BlockDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_delete'=>array( 
        'path'          =>  'block_delete',
        'type'          =>  'BlockDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
 	'block_list'=>array( 
        'path'          =>  'block_list',
        'type'          =>  'BlockListAction',
        'validate'      =>  true,
        'name'          =>  'blockListForm',
        'input'         =>  'block_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_save'=>array( 
        'path'          =>  'saveBlock',
        'type'          =>  'BlockAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block_save.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'block_save.tpl','redirct'=>true),
            'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'tpl_list'=>array( 
        'path'          =>  'listTemplate',
        'type'          =>  'TplAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'tpl_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'tpl_add'=>array( 
        'path'          =>  'addTemplate',
        'type'          =>  'TplAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'tpl.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'tpl_edit'=>array( 
        'path'          =>  'editTemplate',
        'type'          =>  'TplAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'tpl.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true)
			)
        ),	
    'tpl_save'=>array( 
        'path'          =>  'saveTemplate',
        'type'          =>  'TplAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'tpl_save.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true)
			)
        ),
    'tpl_file_list'=>array( 
        'path'          =>  'listTemplateFile',
        'type'          =>  'TplAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'tpl_file_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'tpl_parse'=>array( 
        'path'          =>  'parseTemplate',
        'type'          =>  'TplParseAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'tpl_parse.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
 	'block_list'=>array( 
        'path'          =>  'block_list',
        'type'          =>  'BlockListAction',
        'validate'      =>  true,
        'name'          =>  'blockListForm',
        'input'         =>  'block_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_hotcomment_add'=>array( 
        'path'          =>  'block_hotcomment_add',
        'type'          =>  'BlockHotCommentAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block_hotcomment_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_hotcomment_do_add'=>array( 
        'path'          =>  'block_hotcomment_do_add',
        'type'          =>  'BlockHotCommentDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block_hotcomment_do_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_hotcomment_modify'=>array( 
        'path'          =>  'block_hotcomment_modify',
        'type'          =>  'BlockHotCommentModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block_hotcomment_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_hotcomment_do_modify'=>array( 
        'path'          =>  'block_hotcomment_do_modify',
        'type'          =>  'BlockHotCommentDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_photo_add'=>array( 
        'path'          =>  'block_photo_add',
        'type'          =>  'BlockPhotoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block_photo_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_photo_do_add'=>array( 
        'path'          =>  'block_photo_do_add',
        'type'          =>  'BlockPhotoDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_photo_modify'=>array( 
        'path'          =>  'block_photo_modify',
        'type'          =>  'BlockPhotoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'block_photo_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'block_photo_do_modify'=>array( 
        'path'          =>  'block_photo_do_modify',
        'type'          =>  'BlockPhotoDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'article_rss_title_modify'=>array( 
        'path'          =>  'article_rss_title_modify',
        'type'          =>  'ArticleRssTitleModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_rss_title_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'article_rss_title_do_modify'=>array( 
        'path'          =>  'ArticleRssTitleDoModify',
        'type'          =>  'ArticleRssTitleDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'article_rss_title_do_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'article_rss_group_delete'=>array( 
        'path'          =>  'article_rss_group_delete',
        'type'          =>  'ArticleRssDeleteGroupAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=> array('name'=>'success','path'=>'main.php?do=login','redirct'=>true),
			'failure'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'article_rss_batch_delete'=>array( 
        'path'          =>  'article_rss_batch_delete',
        'type'          =>  'ArticleRssDeleteBatchAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'article_rss_remove_repeat'=>array( 
        'path'          =>  'article_rss_remove_repeat',
        'type'          =>  'ArticleRssRemoveRepeatAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'rss_template_add'=>array( 
        'path'          =>  'rss_template__add',
        'type'          =>  'RSSTemplateAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'rss_template_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
    'rss_template_do_add'=>array( 
        'path'          =>  'rss_template_do_add',
        'type'          =>  'RSSTemplateDoAddAction',
        'validate'      =>  true,
        'name'          =>  'rsstemplateDoAddForm',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
        	'failure'=> array('name'=>'failure','path'=>'rss_template_add.tpl'),
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'header_list'=>array( 
        'path'          =>  'header_list',
        'type'          =>  'HeaderListAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'header_list.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),   
    'header_add'=>array( 
        'path'          =>  'header_add',
        'type'          =>  'HeaderAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'header_add.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'header_do_add'=>array( 
        'path'          =>  'header_do_add',
        'type'          =>  'HeaderDoAddAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=header_list','redirct'=>true)
			)
        ),
	'header_modify'=>array( 
        'path'          =>  'header_modify',
        'type'          =>  'HeaderModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'header_modify.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'header_do_modify'=>array( 
        'path'          =>  'header_do_modify',
        'type'          =>  'HeaderDoModifyAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=header_list','redirct'=>true)
			)
        ),
	'header_delete'=>array( 
        'path'          =>  'header_delete',
        'type'          =>  'HeaderDeleteAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=header_list','redirct'=>true)
			)
        ),	
    'header_publish'=>array( 
        'path'          =>  'header_publish',
        'type'          =>  'HeaderPublishAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'flash_list_new'=>array( 
        'path'          =>  'flash_list_new',
        'type'          =>  'FlashListNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_list_new.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),   
    'flash_add_new'=>array( 
        'path'          =>  'flash_add_new',
        'type'          =>  'FlashAddNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_add_new.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'flash_do_add_new'=>array( 
        'path'          =>  'flash_do_add_new',
        'type'          =>  'FlashDoAddNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=flash_list_new','redirct'=>true)
			)
        ),
    'flash_xml_edit'=>array( 
        'path'          =>  'flash_xml_edit',
        'type'          =>  'FlashXmlEditAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_xml_edit.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'flash_xml_do_edit'=>array( 
        'path'          =>  'flash_xml_do_edit',
        'type'          =>  'FlashXmlDoEditAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
	'flash_delete_new'=>array( 
        'path'          =>  'flash_delete_new',
        'type'          =>  'FlashDeleteNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            'success'=>array('name'=>'success','path'=>'main.php?do=flash_list_new','redirct'=>true)
			)
        ),	
    'flash_pic_add_new'=>array( 
        'path'          =>  'flash_pic_add_new',
        'type'          =>  'FlashPicAddNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_pic_add_new.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true)
			)
        ),
	'flash_pic_do_add_new'=>array( 
        'path'          =>  'flash_pic_do_add_new',
        'type'          =>  'FlashPicDoAddNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
           // 'success'=>array('name'=>'success','path'=>'main.php?do=flash_list_new','redirct'=>true)
			)
        ),
    'flash_edit_new'=>array( 
        'path'          =>  'flash_edit_new',
        'type'          =>  'FlashEditNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flash_edit_new.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
    'flash_do_edit_new'=>array( 
        'path'          =>  'flash_do_edit_new',
        'type'          =>  'FlashDoEditNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
	 'flash_pic_delete_new'=>array( 
        'path'          =>  'flash_pic_delete_new',
        'type'          =>  'FlashPicDeleteNewAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
	'flash_frame'=>array( 
        'path'          =>  'frame',
        'type'          =>  'FlashFrameAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  'flashframe.tpl',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
            //'failure'=> array('name'=>'failure','path'=>'main.php?do=login','redirct'=>true)
			)
        ), 
	'update_spec_tpl'=>array( 
        'path'          =>  'update_spec_tpl',
        'type'          =>  'UpdateSpecTplAction',
        'validate'      =>  false,
        'name'          =>  '',
        'input'         =>  '',
        'cacheTimeLimit'=>  0,
        'forwards'      =>  array(
            'sysError'=> array('name'=>'sysError','path'=>'sysError.html','redirct'=>true),
			)
        ),
);
$FORM_BEANS = array(
    'loginForm'=>array('name'=>'loginForm','type'=>'LoginForm'),
    'articleListForm' =>array('name'=>'articleListForm','type'=>'ArticleListForm'),
    'articleDoAddForm'=>array('name'=>'articleDoAddForm','type'=>'ArticleDoAddForm'),
    'articleDoModifyForm'=>array('name'=>'articleDoModifyForm', 'type'=>'ArticleDoModifyForm'),
    'articleDeleteGroupForm'=>array('name'=>'articleDeleteGroupForm', 'type'=>'ArticleDeleteGroupForm'),
    'coopmediaDoAddForm'=>array('name'=>'coopmediaDoAddForm', 'type'=>'CoopmediaDoAddForm'),
    'coopmediaDoModifyForm'=>array('name'=>'coopmediaDoModifyForm', 'type'=>'CoopmediaDoModifyForm'),
    'crontabDoModifyForm'=>array('name'=>'crontabDoModifyForm','type'=>'CrontabDoModifyForm'),
    'subjectDoAddForm'=>array('name'=>'subjectDoAddForm','type'=>'SubjectDoAddForm'),
    'subjectDoModifyForm'=>array('name'=>'subjectDoModifyForm','type'=>'SubjectDoModifyForm'),
    'userDoAddForm'=>array('name'=>'userDoAddForm','type'=>'UserDoAddForm'),
    'userDoModifyForm'=>array('name'=>'userDoModifyForm','type'=>'UserDoModifyForm'),
    'userDoModifyPasswordForm'=>array('name'=>'userDoModifyPasswordForm','type'=>'UserDoModifyPasswordForm'),
    'channelDoAddForm'=>array('name'=>'channelDoAddForm','type'=>'ChannelDoAddForm'),
    'templateListForm'=>array('name'=>'templateListForm','type'=>'TemplateListForm'),
    'templateDoAddForm'=>array('name'=>'templateDoAddForm','type'=>'TemplateDoAddForm'),
    'templateDoModifyForm'=>array('name'=>'templateDoModifyForm','type'=>'TemplateDoModifyForm'),
	'rsstemplateDoAddForm'=>array('name'=>'rsstemplateDoAddForm','type'=>'RSSTemplateDoAddForm')
    );
?>