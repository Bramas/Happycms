<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"> 
    <head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <title><?php echo $title_for_layout; ?></title> 
    <link rel="stylesheet/less" href="<?php echo $this->Html->url('/css/media.modal.less'); ?>">
	<?php
    echo $this->Html->script('jquery.min');
    echo $this->Html->script('less'); 
    echo $this->Html->script('/media/manager/js/'); 
    ?>
    </head> 
    <body>       
      
 
 
        <div class="container-fluid">
          <?php
          // echo $this->Session->flash();
           ?>
        	<?php echo $content_for_layout; ?>
        </div> 
         

    </body> 
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <?php echo $this->Html->script('admin'); ?>
    <?php echo $scripts_for_layout;?>
</html>