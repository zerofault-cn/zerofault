<?php
import('RelationModel');
class ArticleModel extends RelationModel{
	protected $_link = array(
		'Category' => BELONGS_TO
		);
}
?>