<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 

	echo $this->Html->charset(); ?>
	<title>
		<?php echo Configure::read('Config.Content.title').' | '; ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->element('head');

?>
<link rel="stylesheet/less" href="<?php echo $this->Html->url('/css/bootstrap/bootstrap.less'); ?>">
<?php
		echo $this->Html->css('content');
		echo $this->Html->script('less');
		echo $this->Html->script('jquery.min');
		
		echo $this->Html->script('bootstrap-dropdown');
		echo $this->Html->script('jquery-ui.min');
		echo $this->Html->script('jquery.mousewheel.min');
		echo $this->Html->css('pepper-grinder/jquery-ui');

		echo $scripts_for_layout;

		echo '<link href="'.$this->Html->url('/css/style.css').'" id="styleCss" type="text/css" rel="stylesheet">';
		
	?>
		<script type="text/javascript">
	function liveCssReload(c)
	{
		$('#styleCss').remove();
		 $("#liveCssStyle").html(c);
	}
	</script>
</head>
<?php

echo $this->element('body') ?>

	<div class="topbar">
		<div class="topbar-inner">
		<div class="container">
		<h3><?php
		 echo $this->Html->link(Configure::read('Config.Content.title'),'/'); ?></h3>
			<?php   //echo $this->element('menu',array('menus'=>isset($menus)?$menus:null)); 
				echo $this->element('list_menus');
				echo $this->element('searchBox',array('class'=>'pull-right')); 
			?>
		</div>
	</div>
		
		<?php 
			//echo $this->element('breadcrumb'); 
		?>

		
		
	</div>
		
	<div class="container">
		<div class="page-header">
			<h1>
			<?php 
				echo Configure::read('Menu.title'); ?>
			</h1>
		</div>
		<div class="contentForLayout">
			<?php 

			echo $content_for_layout; ?>
			
			<div class="clear"></div>
		</div>

		<footer>
		<p>
		<?php echo $this->Html->link(
				$this->Html->image('/HappyCms/img/happy.cms.png', array('alt'=> __('Happy CMS, a CakePHP based CMS', true), 'border' => '0')),
				'http://www.linksite.fr/',
				array('target' => '_blank', 'escape' => false)
			);
		?>
		
		<?php 
		echo $this->Html->link('Administration','/admin/'); ?>
		</p>
		</footer>
	</div>

	
	<?php   if(!empty($is_linksite)){
?>
<script type="text/javascript">
	
	$(function(){
		$('.hideSqlDump').click(function(){
		
			$('.cake-sql-log').hide();
			$('.hideSqlDump').hide();

		});
	});

</script>
<span class="hideSqlDump">Cacher le Log SQL</span> - <a onClick="window.open('<?php echo $this->Html->url('/admin/files/liveCss'); ?>','Editer le Css','height=610,width=550,toolbar=0');return false;" href="#">Editer le Css</a>
<?php

		echo $this->element('sql_dump'); 
		?>
		<style type="text/css" id="liveCssStyle"></style>
<?php
	} 
	?>
</body>
</html>