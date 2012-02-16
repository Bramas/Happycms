<html>
<head><?php 
echo $this->Html->script('/HappyCms/js/edit_area/edit_area_full'); 
echo $this->Html->script('/HappyCms/js/edit_area/reg_syntax/php'); 
echo $this->Html->script('/HappyCms/js/edit_area/reg_syntax/html'); 
echo $this->Html->script('/HappyCms/js/edit_area/reg_syntax/css'); 
echo $this->Html->script('/HappyCms/js/edit_area/reg_syntax/langs/fr.js'); 
echo $this->Html->script('jquery.min');
echo $this->Html->script('less');

?>
<script language="javascript" type="text/javascript">
editAreaLoader.init({
	id : "fileEdit"		// textarea id
	,syntax: "<?php echo str_replace('ctp','php',preg_replace('/^.*\.([a-zA-Z0-9]{1,5})$/','$1',$filename)) ?>"			// syntax to be uses for highgliting
	,start_highlight: true		// to display with highlight mode on start-up
	,plugins: "livecss"
	,min_height:540
	,min_width:540
	,allow_resize:'both'
});

function parseLiveCss(c)
{
	var parser = new(less.Parser);

	parser.parse(c, function (err, tree) {
	    if (err) { return console.error(err) }
	  //  console.log(tree.toCSS());
	  //  $("#liveCssStyle").html(tree.toCSS());
	  		window.opener.liveCssReload(tree.toCSS());
	});
}

</script>
</head>
<body>
<?php
if(preg_match('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/',$filename))
{
	echo $this->Html->link(	
					preg_replace('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/','$1',$filename).'/ << Retour'
,'/admin/files/index/'.
preg_replace('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/','$1',$filename));
}
else
{
	echo $this->Html->link(	
					'<< Retour'
,'/admin/files/index'
);
}


 
echo $this->Form->create('File',array('action'=>'save','url'=>'/admin/files/save/'));
?>
<textarea id="fileEdit" name="data[File][content]" rows="30" class="no-editor" style="font-size: 12px;">
<?php
	foreach($File as $line)
	{
	    echo($line);
	}

?>
</textarea>
<?php 
echo $this->Form->input('filename',array('type'=>'hidden','value'=>$filename));
echo $this->Form->end('Save');
?>
<div id="status"></div>
<script type="text/javascript">
$(function(){


/*	$(window.document).keyup(function(event){
		
		if(event.keyCode==13 || event.keyCode==190 || (event.keyCode==107 && event.altKey && event.ctrlKey))
		{
			var parser = new(less.Parser);

			parser.parse($(this).val(), function (err, tree) {
			    if (err) { return console.error(err) }
			  //  console.log(tree.toCSS());
			  //  $("#liveCssStyle").html(tree.toCSS());
			  window.opener.liveCssReload(tree.toCSS());
			});
		}
	});	*/

	$('#FileSaveForm').submit(function(e)
	{
		e.preventDefault();
		$('#status').html('Saving...');
		$.ajax({
			url:'<?php echo $this->Html->url('/admin/files/save'); ?>',
			data:{
				"data[File][content]":editAreaLoader.getValue('fileEdit'),
				"data[File][filename]":$('#FileFilename').val(),
				"data[ajax]":1
			},
			type:'post',
			success:function()
			{
				$('#status').html('Saved');
			}
		});
		return false;
	});

});


</script>
</body>