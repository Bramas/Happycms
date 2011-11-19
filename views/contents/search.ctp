<?php echo $this->element('headPage'); ?>


<div id="Page">

    <div id="column-left">
	    <div id="SearchResultInfos">

	    	<span class="title">Résultat<?php 

	    	$s = count($searchResults)>1?'s':'';
	    	echo $s ?> de la recherche : </span><span class="searchTerm">
	    		<?php echo $searchTerm; ?>
	    	</span>
	    	<span><?php 
	    	echo count($searchResults).' résultat'.$s.' trouvé'.$s.'.' ; ?> .</span>
	    </div>
	    <div id="rechercher"><?php echo $this->element('searchBox'); ?></div>
		<?php echo $this->element('accesRapide'); ?>
    </div>  
    <div id="rightPage">

<?php

	if(!empty($searchResults))
	{	foreach($searchResults as $result)
		{
			$url = $html->url($result['url'],true);
			?>
			<div class="resultItem">
				<?php echo $html->link($result['title'],$result['url'],array('class'=>'title')) ?>
				<div class="content">
					<?php echo $result['content'] ?>
				</div>
				<?php echo $html->link($url,$result['url'],array('class'=>'url')) ?>

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

