<div class="row">
	<div class="offset1">
		<div class="Galleries">
			<?php
				App::uses('Inflector','Utility');
				foreach($Galleries as $gallery)
				{
					$gallery=$gallery['Gallery'];
					if(!count($gallery['img']))
					{
						continue;
					}
					echo '<div class="item">'.

						'<div class="img">'.$this->Html->image('/files/uploads/galleries/'.current($gallery['img']).'_120x120').'</div>'.
						'<div class="title">'.$gallery['title'].'</div>'.
						'<div class="description">'.introText($gallery['text'],150).'</div>'.
						'<div class="read-more">'.$this->Html->link('Voir l\'album photos',array(
								'controller'=>'galleries',
								'action'=>'view',
								$gallery['id'].'-'.Inflector::slug($gallery['title'])
							)).'</div>'.


					'</div>';
				}

			?>
		</div>
	</div>
</div>	