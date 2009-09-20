	<div id="searcher">
		<ul>
			<li><a href="?c=view&m=index&type=link">我的网址</a></li>
			<li><a href="" class="curr">我的网摘</a></li>
			<li><a href="?c=view&m=index&type=pic">我的图片</a></li>
			<li><a href="?c=view&m=tag">我的标签</a></li>
		</ul>
		<!-- <form action="/search" method="get">
			<img src="/media/search_b.gif" alt="search button" />
			<input type="text" id="searchBox" maxlength="15" name="s" />
			<input src="/media/search.gif" id="submit" type="image" />
		</form> -->
	</div>

	<div id="col_right">
		<dl class="box" id="mytags">
			<dt><span><a href="/tag">Tag</a></span></dt>
			<dd id="mytag">
				<ul style="display: block;">
					<?php foreach($tag_list as $tag_item): ?>
					<li><a href="?c=view&m=index&tag=<?=$tag_item['name']?>"><?=$tag_item['name']?></a><a href="/rss/<?=$tag_item['name']?>" class="num" target="_blank"><?=$tag_item['count']?></a></li>
					<?php endforeach;?>
				</ul>
			</dd>
		</dl>

		<dl class="box" id="myfriends">
			<dt><span>固定链接</span></dt>
			<dd id="myfriend">
				<ul>
				</ul>
			</dd>
		</dl>

		<div id="myicon">
			<a href="/rss/" target="_blank"><img src="media/rss.gif" alt="rss" class="rss" /></a>
		</div>

	</div>
	<div id="col_middle">
		<div class="page">

		</div>

		<div id="links">
			<?php foreach($result as $item): ?>
			<dl class="item" id="item_<?=$item['id']?>">
				<img class="icon" src="media/htm.gif" />
				<dt>
					<strong><?=$item['title']?></strong>
					<?php if($item['private']): ?>
					<img src="media/lock.gif" align="absmiddle" />
					<?php endif; ?>
					<br />
					<?=$item['addtime']?>
				</dt>
				<dd class="content">
					<?=nl2br($item['content'])?>
				</dd>
				<dd class="tags">
					<?php foreach(explode(',', $item['tag_names']) as $tag_name): ?>
					[<a href="?c=view&m=index&tag=<?=$tag_name?>" class="tag"><?=$tag_name?></a>]
					<?php endforeach; ?>
					<?php if($_COOKIE['isAdmin']): ?>
					... 
					<a href="/add?key=<?=$item['key']?>" class="edit">编辑</a>/ <a class="del" onClick="$('#del_<?=$item['key']?>').show()">删除</a>
					<span class="edit" id='del_<?=$item['key']?>'><a onClick="submit_del(this)" value="<?=$item['key']?>" class="edit">确认</a> / <a onClick='$("#del_<?=$item['key']?>").hide()' class="edit">取消</a></span>
					<?php endif; ?>
				</dd>
			</dl>
			<?php endforeach; ?>
		</div>

		<div class="page">
<?=$pagination?>
		</div><span>共<?=$total?>个记录</span>

	</div>
