<?php echo $this->element('headPage');

//debug($breadcrumps); ?>


<div id="Page">

    <div id="column-left">
	    <div id="menuCat">
	    	<?php echo $this->element('list_actus'); ?>
	    </div>
	    <div id="rechercher"><?php echo $this->element('searchBox'); ?></div>
		<?php echo $this->element('accesRapide'); ?>
        <?php echo $this->element('agenda'); ?>

    </div>  
    <div id="rightPage">
    <h1 class="mainTitle"><?php echo $Content['title']; ?></h1>

    <?php


echo $Content['text'];
    
    ?>

    </div>
</div>



