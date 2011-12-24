<?php echo $this->Html->script('tiny_mce/tiny_mce_popup.js'); ?>
<script type="text/javascript">
	var win = window.dialogArugments || opener || parent || top;
	win.send_to_editor('<img src="<?php echo $src; ?>_<?php echo $format; ?>" alt="<?php echo $alt; ?>" style="<?php echo $style; ?>">');
	tinyMCEPopup.close();
</script>