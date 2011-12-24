<div id="Posts">
<?php
    App::uses('Inflector', 'Utility');
	foreach($Posts as $post)
	{
		echo '<div class="postItem">';
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
	}

?>
</div>