<div class="row">
	<div class="span6 home-posts">
		<div class="headTitle">
			News
			<?php echo $this->Html->link('',array('controller'=>'posts','action'=>'rss'),array('class'=>'rss')); ?>
		</div>
		<?php echo $this->element('list_actus',array('start'=>($Home['une']=='news'?1:0))); ?>
	</div>
	<div class="span6 home-agenda">
		<div class="headTitle">
			Agenda
			<?php echo $this->Html->link('',array('controller'=>'events','action'=>'rss'),array('class'=>'rss')); ?>
		</div>
		<?php echo $this->element('agenda'); ?>
		<h3>Événements passés</h3>
		<div class="archive">
			<?php echo $this->element('agenda',array('archive'=>true,'limit'=>5)); ?>
		</div>
	</div>
	<div class="span4 home-links">
		<div class="headTitle">
			Liens Rapides
		</div>
		<?php

		echo $this->element('list_menus',array('parent_id'=>97));

		?>
		<div class="headTitle">
			Photos
		</div>
		<?php

		echo $this->element('random_photos',array('parent_id'=>97));

		?>

	</div>
</div>