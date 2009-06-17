	<div id="searcher">
		<ul>
			<li><a href="/" class="curr">�ҵ���ַ</a></li>
			<li><a href="/note/">�ҵ���ժ</a></li>
			<li><a href="/pic/">�ҵ�ͼƬ</a></li>
			<li><a href="/tag">�ҵı�ǩ</a></li>
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
					<li><a href="/<?=$tag_item->name?>"><?=$tag_item->name?></a><a href="/rss/<?=$tag_item->name?>" class="num" target="_blank"><?=$tag_item->count_link?></a></li>
					<?php endforeach;?>
				</ul>
			</dd>
		</dl>

		<dl class="box" id="myfriends">
			<dt><span>�̶�����</span></dt>
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
			<dl class="item" id="item_<?=$item['key']?>">
				<img class="icon" src="media/htm.gif" />
				<dt>
					<a href="<?=$item['url']?>" target="_blank"><?=$item['title']?></a>
					<?php if($item['private']): ?>
					<img src="media/lock.gif" align="absmiddle" />
					<?php endif; ?>
					<?=$item['addtime']?>
				</dt>
				<dd class="content">
					<?=nl2br($item['content'])?>
				</dd>
				<dd class="tags">
					<?php foreach($item['tag_names'] as $tag_name): ?>
					[<a href="/<?=$tag_name?>" class="tag"><?=$tag_name?></a>]
					<?php endforeach; ?>
					<?php if($_COOKIE['isAdmin']): ?>
					... 
					<a href="/add?key=<?=$item['key']?>" class="edit">�༭</a>/ <a class="del" onClick="$('#del_<?=$item['key']?>').show()">ɾ��</a>
					<span class="edit" id='del_<?=$item['key']?>'><a onClick="submit_del(this)" value="<?=$item['key']?>" class="edit">ȷ��</a> / <a onClick='$("#del_<?=$item['key']?>").hide()' class="edit">ȡ��</a></span>
					<?php endif; ?>
				</dd>
			</dl>
			<?php endforeach; ?>
		</div>

		<div class="page">
<?=$pagination?>
		</div><span>��<?=$total?>����¼</span>

	</div>
