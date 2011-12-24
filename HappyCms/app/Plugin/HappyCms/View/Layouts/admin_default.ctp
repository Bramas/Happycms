<?php
header('Content-type: text/html; charset=UTF-8');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Administration : ');
			echo Configure::read('Config.Content.title');
		 ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('/HappyCms/css/cake.generic');
		echo $this->Html->css('/HappyCms/css/tree');
		echo $this->Html->css('/HappyCms/css/admin_happy');
		echo $this->Html->css('/HappyCms/css/admin_style');
		echo $this->Html->css('/HappyCms/css/pepper-grinder/jquery-ui');
		echo $this->Html->css('/HappyCms/css/checkbox_happy');
		echo $this->Html->script('/HappyCms/js/jquery.min');
		echo $this->Html->script('/HappyCms/js/jquery-ui.min');
		echo $this->Html->script('/HappyCms/js/jquery.qtip.min');
		echo $this->Html->script('/HappyCms/js/nested');
		echo $this->Html->script('/HappyCms/js/jquery.checkbox.min');

		echo $scripts_for_layout;
	?>
<script type="text/javascript">
	var SiteBaseAdmin = "<?php echo $this->Html->url('/admin/',true); ?>";
	var SiteBase = "<?php
	
	$url = $this->Html->url('/',true);
	
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

	function HpUploadComplete(name,lang,domId,filename)
	{
		function randomString(string_length) {
		   var text = "";
		    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		    for( var i=0; i < string_length; i++ )
		        text += possible.charAt(Math.floor(Math.random() * possible.length));

		    return text;

		};
		var r = randomString(10);
	    //single file upload
		  $('input#'+domId).val(filename);

		  //multiple files upload
		 $('div#'+domId+' .empty').clone().val(filename).removeClass('empty').attr('uid',r).appendTo('div#'+domId);
		 var temp = $('div#'+domId+'Img>.empty').clone();
		 temp.removeClass('empty').appendTo('div#'+domId+'Img');
		 temp.attr('uid',r);
		 temp.attr('title',filename);
		 temp=temp.find('img').first();
		 temp.attr('title',filename).attr('src',temp.attr('src')+filename);
		 $('div#'+domId+'Img .clear').remove();
		 $('div#'+domId+'Img').append('<div class="clear"></div>');

	}
	function HpDeleteUpload(name,lang,domId,filename)
	{
	  $('#'+domId+'Delete').val(filename);
	} 
	

</script>
<?php echo $this->Html->script('/HappyCms/js/functions'); ?>
</head>
<body class="admin">
	
	<div id="container">
		<div id="header">
			<div class="logo">
				
			</div>
			
			<div class="banniere">
				
			</div>
			
			
			<div id="user-box">
				<?php echo $User['username']; ?> 
				
			</div>
			
		</div>
		<div id="sub-header">
			<div id="site-title">
				<?php echo $this->Html->link('Voir le site internet','/'); ?>
				
			</div>
			<div  class="admin-main-menu">

				<ul>
					<li><?php echo $this->Html->link('Gérer les Pages','/admin/'); ?></li>
					<li><?php echo $this->Html->link('Configurer le Site', array(
											       'controller'=>'contents',
											       'action'=>'item_edit',
											       'extensions',
											       7));?></li>
					<li><?php echo $this->Html->link('Mon Profil',array(
											       'controller'=>'users',
											       'action'=>'edit',
											       'admin'=>true)); ?></li>

					<?php if(!empty($is_linksite)) 

											echo '<li> '.$this->Html->link('Gestionnaire de fichiers',array(
											       'controller'=>'files',
											       'action'=>'index',
											       'admin'=>true)).'</li>'; ?>
					<?php if(!empty($is_linksite)) 

											echo '<li> '.$this->Html->link('Gestionnaire d\'utilisateurs',array(
											       'controller'=>'users',
											       'action'=>'index',
											       'admin'=>true)).'</li>'; ?>
				</ul>
			</div>
			
		</div>
		
	</div>
		
	<div id="middle">
		<div id="left">
		
		<?php echo $this->element('admin_extensions_menu'); ?>
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
	//if(!empty($is_linksite))
	echo $this->element('sql_dump'); ?>
</body>
</html>