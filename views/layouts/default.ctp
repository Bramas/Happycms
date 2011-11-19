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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('PCM-Ensemblier | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
	echo $this->element('head');

		echo $this->Html->css('style');
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('jquery-ui.min');
		echo $this->Html->script('jquery.mousewheel.min');
		echo $this->Html->css('pepper-grinder/jquery-ui');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="header">
		<div id="logo"></div>
		<?php echo $this->element('flags'); ?> 
		<div id="menu">
		<?php echo $this->element('menu',array('menus'=>$menus)); ?> 
		</div>
	</div>
		
	<div id="container">
		<div id="content">
		<?php echo $content_for_layout; ?>
		<div class="clear"></div>
		</div>
	</div>

	<div id="footer">
		<?php echo $this->Html->link(
				$this->Html->image('happy.cms.png', array('alt'=> __('Happy CMS, a CakePHP based CMS', true), 'border' => '0')),
				'http://www.linksite.fr/',
				array('target' => '_blank', 'escape' => false)
			);
		?>
		<a href="http://www.linkiste.fr">Création et design LinkSite</a> |
		<?php echo $html->link('Administration','/admin/'); ?>
	</div>
	<?php echo $this->element('sql_dump'); ?>


	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26046373-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>