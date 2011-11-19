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
		echo $this->Html->meta('icon');

		echo $this->Html->css('login');
		echo $this->Html->script('jquery.min');

		echo $scripts_for_layout;
	?>
</head>
<body class="offline">
    <div id="logoSite"></div>
	<div id="container">
		
            <?php echo $this->element('flags'); ?>
            <div id="offline-message"><?php 
$c = Configure::read('Config.Content');
echo empty($c['offline-message'])?'':$c['offline-message'];
?></div>
            <div id="link-to-admin"><?php echo $html->link(__('Connexion Administrateur',true),array('controller'=>'users','action'=>'login',1)); ?></div>
		<div id="logoHappy"></div>
		<div id="logoLS"></div>
	
	</div>
	
	<?php // echo $this->element('sql_dump');
	?>
</body>
</html>