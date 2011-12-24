<div class="row">
	<div class="span5">
	    <div id="SearchResultInfos">

	    	<div class="title">Résultat<?php 

	    	$s = count($searchResults)>1?'s':'';
	    	echo $s ?> de la recherche : </span><span class="searchTerm">
	    		<?php echo $searchTerm; ?>
	    	</div>
	    	<div><?php 
	    	echo count($searchResults).' résultat'.$s.' trouvé'.$s.'.' ; ?> .</div>
	    </div>
	    <div id="rechercher"><?php echo $this->element('searchBox'); ?></div>
	</div>  
	<div class="span11">
	<?php

		if(!empty($searchResults))
		{	foreach($searchResults as $result)
			{
				$url = $this->Html->url($result['url'],true);
				?>
				<div class="resultItem">
					<h4><?php echo $this->Html->link($result['title'],$result['url'],array('class'=>'title')) ?></h4>
					<div class="content">
						<?php echo $result['content'] ?>
					</div>
					<?php echo $this->Html->link($url,$result['url'],array('class'=>'url')) ?>

				</div>
				


				<?php
			}
		}
		else
		{
			echo '<div class="no-result">La recherce n\'a retourné aucun résultats.</div>'; 
		}
	?>

	</div>
</div>

