<?php echo $this->Html->script('jquery.masonry.min'); ?>
<div class="row">
	<div class="offset1"><?php

		echo '<div id="photos" class="photos">';

		foreach($Gallery['img'] as $photo)
		{
			echo '<div class="item">'.
			$this->Html->image($photo.'_200x0').
			'</div>';
		}

		echo '</div>';
		?>
	</div>
</div>

<script type="text/javascript">
var $container = $('#photos');

$container.imagesLoaded( function(){
  $container.masonry({
    itemSelector : '.item',
  	isAnimated: true
  });
});

</script>