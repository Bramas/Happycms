<div id="tinyShow">
	
<h3>Insérer l'image</h3>




<?php echo $this->Form->create('Media',array('url'=>'/media/manager/tiny_show')); ?>
	<?php echo $this->Form->input('alt',array('label'=>"Nom de l'image","value"=>$alt)); ?>
	<?php echo $this->Form->input('src',array('type'=>"hidden","value"=>$src)); ?>
<?php echo $this->Form->input('format',array('legend'=>"Taille de l'image","options"=>array(
		"150x0" => 'Petite <img style="max-width:50px" src="'.$src.'_50x0">',
		"250x0" => 'Moyenne <img style="max-width:75px" src="'.$src.'_75x0">',
		"500x0" => 'Grande <img style="max-width:150px" src="'.$src.'_150x0">'
	),'type'=>'radio','value'=>$format)); ?>
	<?php echo $this->Form->input('style',array('legend'=>"Alignement","options"=>array(
		"float: left;" => "Aligner à gauche",
		"display: block; margin-left: auto; margin-right: auto;" => "Aligner au centre",
		"float: right;" => "Aligner à droite"
	),'type'=>'radio','value'=>$style)); ?>
<?php echo $this->Form->end('Insérer dans ma page'); ?>

</div>

