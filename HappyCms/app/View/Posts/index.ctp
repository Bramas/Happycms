<div id="Posts" class="row" >
    <div class="span15 offset1">
<?php
    App::uses('Inflector', 'Utility');
	foreach($Posts as $post)
	{
		echo '<div class="postItem">';
		echo '<div class="image">'.$this->Html->image('/files/uploads/posts/'.$post['Post']['img'].'_250x120').'</div>';
		echo '<h3>'.$post['Post']['title'].'</h3>';
		echo '<div class="content">'.$post['Post']['text'].'</div>';
		echo '<div class="readMore">'.
		$this->Html->link(
			'Lire la suite',
			array(
				'controller'=>'posts',
				'action'=>'view',
				$post['Post']['id'].'-'.Inflector::slug($post['Post']['title'],'-')
			)
		).
		'</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}

?>
</div>
</div>