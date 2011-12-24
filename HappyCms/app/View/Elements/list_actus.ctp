<?php

$posts = $this->requestAction('/posts/getList/0/10');
echo '<ul>';
$lengthIntro = 120;
foreach($posts as $post)
{
	$class='';
	if(!empty($currentItemId) && $currentItemId == $post['Post']['id'])
	{
		$class='current';
	}

	$intro = substr($post['Post']['text'],0,$lengthIntro);
     
    $k=0;
    while(substr($post['Post']['text'],$lengthIntro+$k,1)!=' ')
    {
       $intro.=substr($post['Post']['text'],$lengthIntro+$k,1);
       $k++;
       if($k>20) break;
    }
	if(strlen($post['Post']['text'])>$lengthIntro)
	{
	 	$intro.='...';
	}



	echo '<li class="'.$class.'">'.$this->Html->link(
		$post['Post']['title'],
		array(
			'controller'=>'posts',
			'action'=>'view',
			$post['Post']['id'].'-'.Inflector::slug($post['Post']['title'],'-')
			));
	echo 	'<div class="description">'.
				
				'<div class="date">'.formatDate($post['Post']['created']).'</div>'.
				'<div class="intro">'.$intro.'</div>'.

			'</div>'.		
			'</li>';
}
echo '</ul>';

