<?php
header('Content-type: text/html; charset=UTF-8');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('CakePHP: the rapid development php framework:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('tree');
		echo $this->Html->css('admin_style');
		echo $this->Html->css('pepper-grinder/jquery-ui');
		echo $this->Html->css('checkbox_happy');
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('functions');
		echo $this->Html->script('jquery-ui.min');
		echo $this->Html->script('jquery.qtip.min');
		echo $this->Html->script('nested');
		echo $this->Html->script('jquery.checkbox.min');

		echo $scripts_for_layout;
	?>
<script type="text/javascript">
	var SiteBase = "<?php echo $html->url('/admin/',true); ?>";
</script>
</head>
<body class="admin ajax">
	
	<div id="container">
		
	<div id="middle">
		
		<div id="content">
			
			
			
			<?php
			
			
			
			echo $this->Session->flash(); ?>
		<div id="edit-panel">
			<?php echo $content_for_layout; ?>
		</div>

		</div>
		
	</div>
	<script type="text/javascript">
            

           
            $('#edit-panel>form').submit(function(){
                 var dataForm={};
                $('#edit-panel>form input').each(function(){
                    dataForm[$(this).attr('name')]=$(this).attr('value');
                });
		$('#edit-panel>form textarea').each(function(){
                   
		    var ed = tinyMCE.get($(this).attr('id'));
//alert(tinyMCE);
			// Do you ajax call here, window.setTimeout fakes ajax call
			if(ed!=undefined)
			{
				dataForm[$(this).attr('name')]=ed.getContent();
				
			}
			else
			{
				alert($(this).attr('id'));	
			}
                });
                $('#edit-panel>form select').each(function(){
                    dataForm[$(this).attr('name')]=$(this).find('option:selected').attr('value');
                   
                });
                dataForm["data[ajax]"]=1;
		
                $.ajax({
                    url:$(this).attr('action'),
                    data:dataForm,
                    type:'POST',
                    success:function(t)
                    {
                            window.parent.closeAjaxDialog(t);
                    }
                    
                })
                
                $('body').html('<div class="wait">Chargement</div>');
                return false;
            });
            
            
        </script>
	
	<?php //if($is_linksite)
	//echo $this->element('sql_dump'); ?>
</body>
</html>