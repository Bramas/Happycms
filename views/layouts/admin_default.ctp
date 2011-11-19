<?php
header('Content-type: text/html; charset=UTF-8');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Administration : PCM-ensemblier'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('tree');
		echo $this->Html->css('admin_happy');
		echo $this->Html->css('admin_style');
		echo $this->Html->css('pepper-grinder/jquery-ui');
		echo $this->Html->css('checkbox_happy');
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('jquery-ui.min');
		echo $this->Html->script('jquery.qtip.min');
		echo $this->Html->script('nested');
		echo $this->Html->script('jquery.checkbox.min');
		

		echo $scripts_for_layout;
	?>
<script type="text/javascript">
	var SiteBaseAdmin = "<?php echo $html->url('/admin/',true); ?>";
	var SiteBase = "<?php
	
	$url = $html->url('/',true);
	
	echo str_replace(Configure::read('Config.language'),'',$url);
	
	
	?>";
	var $dialog = undefined;
	var AjaxResults = [];
	function closeAjaxDialog(re)
	{
		AjaxResults=re;
		$dialog.dialog('close');
	}
	var Languages= new Array(<?php
	$first = 0;
		foreach(Configure::read('Config.languages') as $l)
		{
			if($first++)
			{
				echo ',';
			}
			echo '"'.$l.'"';
		}
		?>
	);
	
	$(document).ready(function() {
		//$('input:checkbox').checkbox();
	});

</script>
<?php echo $this->Html->script('functions'); ?>
</head>
<body class="admin">
	
	<div id="container">
		<div id="header">
			<div class="logo">
				
			</div>
			
			<div id="site-title">
				<?php echo $html->link('Voir le site internet','/'); ?>
				
			</div>
			<div id="user-box">
				<?php echo $User['username']; ?> 
				
			</div>
			
		</div>
		<div id="sub-header">
			<div  class="admin-main-menu">
				<ul>
					<li><?php echo $html->link('Gérer les Pages','/admin/'); ?></li>
					<li><?php echo $html->link('Configurer le Site', array(
											       'controller'=>'contents',
											       'action'=>'item_edit',
											       'extensions',
											       11));?></li>
					<li><?php echo $html->link('Mon Profil',array(
											       'controller'=>'users',
											       'action'=>'edit',
											       'admin'=>true)); ?></li>

					<?php if(!empty($is_linksite)) 

											echo '<li> '.$html->link('Gestionnaire de fichier',array(
											       'controller'=>'files',
											       'action'=>'index',
											       'admin'=>true)).'</li>'; ?>
				</ul>
			</div>
			<script type="text/javascript">
			$(function(){
				$('#sub-header>div>ul>li>a').button();
				$('#sub-heade>div>ul').buttonset();
						
			});
			</script>				
			<div id="admin-lang">
					<?php echo $this->element('admin_lang'); ?> 
			</div>	
		</div>
		
	</div>
		
	<div id="middle">
		<div id="left">
		
		<?php echo $this->element('admin_tree_menu'); ?>
		</div> 
		<div id="content">
			
			
			
			<?php
			
			
			
			echo $this->Session->flash(); ?>
		<div id="edit-panel">
			<?php echo $content_for_layout; ?>
		</div>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>	
	</div>
	
	<script type="text/javascript">
	
		/*function relativeLeft(now, fx)
		{
			$(this).next().css('width',920-now);
			$(this).next().children().first().css('margin-left',200-now);
		}
		$('#left').mouseover(function()
				{
					$(this).stop().animate(
						{
							width:'400px'
						},
						{
							 step: relativeLeft,
							duration:300
						}
					);
					
				});
		$('#left').mouseout(function()
				{
					$(this).stop().animate(
						{
							width:'200px'
						},
						{
							 step: relativeLeft,
							duration:300
						}
					);
				});
		$('#left').mouseout();
		*/
	</script>
	
	<div id="header_bk">
		
	</div>
	<?php 
	if(!empty($is_linksite))
	echo $this->element('sql_dump'); ?>
</body>
</html>