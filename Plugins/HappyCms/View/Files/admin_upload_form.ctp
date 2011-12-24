<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Plupload</title>

<style type="text/css">
	body {
		font-family:Verdana, Geneva, sans-serif;
		font-size:13px;
		color:#333;
		background:url(bg.jpg);
	}
</style>

<?php  echo $this->Html->css('admin_style'); ?>
<?php  echo $this->Html->css('admin_happy'); 
		echo $this->Html->css('pepper-grinder/jquery-ui');

echo $this->Html->script('jquery.min');
		echo $this->Html->script('jquery-ui.min'); ?>
<?php  echo $this->Html->script('plupload/js/plupload.full.js'); ?>

<!-- <script type="text/javascript"  src="http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js"></script> -->

</head>
<body>
<div id="explorer">
	
</div>
<div class="clear"></div>
<?php 


	?>
<div class="input file">
	<div id="file-<?php echo $name.'-'.$lang ?>">
		<div id="pickfiles-container">
			<div id="runtimeError">Chargement...</div>
		    <div class="a pickfiles" id="pickfiles" href="javascript:;"><?php echo $this->Html->image('/img/boxupload32.png'); ?>
				<a id="file-<?php echo $name.'-'.$lang ?>-pickfiles" >A partir de mon ordinateur</a>
		    </div> 
		    <div  class="a distantfiled"><?php echo $this->Html->image('/img/Slideshow.png'); ?>
		    	<a  id="file-<?php echo $name.'-'.$lang ?>-distantfiled" >Images existantes</a>
		    </div>
		    <!--<a id="uploadfiles" href="javascript:;">[Upload files]</a>
		    <a id="hideForm" href="javascript:;">hide</a>-->
		</div>
		<div id="result">
			<div class="image">
		    	
		    </div>
		</div>
		<div class="actions"><span class="action delete">delete</span></div>
		<div class="clear"></div>
		<div id="loader">
			
		</div>
		<div id="finishList">
			
		</div>
		<div class="clear"></div>
	</div>
</div>


<script type="text/javascript">
var multiple = <?php echo $multiple?'true':'false'; ?>; 
var filename = '<?php echo $default; ?>';
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles',
	container: 'pickfiles-container',
	max_file_size : '6mb',
	url : '<?php echo $this->Html->url('/admin/',true); ?>'+'/contents/upload?extension=<?php echo $extension ?>'+
               
                '&fieldname=<?php echo $name ?>'+
                '&contentid=1'+
                '&lang=<?php echo $lang ?>'+
                '&',
    chunk_size:'300kb',
	//resize : {width : 320, height : 240, quality : 90},
	flash_swf_url : '<?php echo $this->Html->url('/js/plupload/js/plupload.flash.swf',true); ?>',
	silverlight_xap_url : '<?php echo $this->Html->url('/js/plupload/js/plupload.silverlight.xap',true); ?>',
	filters : [
		{title : "Image files", extensions : "jpg,gif,png"},
		{title : "Zip files", extensions : "zip"}
	]
});

function reloadUploader()
{
	$('#pickfiles-container .a').show();
	$('.image').html('');
	$('#loader').html('');
	$('.actions').hide();
	uploader.refresh();
	$('#explorer').html('').show();
}
function hideUploader()
{
	if(multiple)
	{
		return;
	}
	$('#pickfiles-container .a').hide();
}
function displayImage(filename)
{
	if(multiple)
	{
		return;
	}

	$('.image').html(
		    '<img src="<?php echo $this->Html->url('/files/uploads/'.$extension); ?>'+
                    '/'+filename+'_0x100"/>');
    $('.actions').show();
    //alert(filename);

	hideUploader();
	$('#explorer').hide();
}

$('.actions').hide();










uploader.bind('Init', function(up, params) {
	$('#runtimeError').html("");//<div>Current runtime: " + params.runtime + "</div>";
});

uploader.bind('FilesAdded', function(up, files) {
	for (var i in files) {
		$('#loader').append('<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <div class="bar"><div></div><b></b></div></div>');
	}
	//up.refresh();
	//hideUploader();
	setTimeout(function(){ 
		uploader.start();
	 },100);
});

uploader.bind('UploadFile', function(up, file) {
		//hideUploader();
});

uploader.bind('UploadProgress', function(up, file) {
	hideUploader();
	$('#'+file.id+' b').html('<span>' + file.percent + "%</span>");
	$('#'+file.id+' div.bar div').css('width',file.percent*3);
});
uploader.bind('Error', function(up, err) {
            
		switch(err.code)
        {
            case plupload.FILE_SIZE_ERROR:
                alert('Le fichier est trop volumineux');
                break;
            default:
                    $('#runtimeError').append("<div>Error: " + err.code +
                        ", Message: " + err.message +
                        (err.file ? ", File: " + err.file.name : "") +
                        "</div>"
                );
            break;
        }
	up.refresh(); // Reposition Flash/Silverlight
});

$('#uploadfiles').click(function() {
	uploader.start();
	return false;
});
uploader.bind('FileUploaded', function(up, file,resp) {
	jresp = JSON.parse(resp.response);
	filename = jresp.realName;
	try{
		window.parent.HpUploadComplete('<?php echo $name ?>','<?php echo $lang ?>','<?php echo $domId ?>',jresp.realName);
	}
	catch(e)
	{
		$('#runtimeError').append("<div>Error: wrong cross-frame call</div>"
                );
		return;
	}
	displayImage(jresp.realName);
	$('#'+file.id).appendTo('#finishList');

});

$('#hideForm').click(function() {
	hideUploader();
	return false;
});


<?php 

if(!empty($default))
{
	?>

	displayImage('<?php echo $default ?>');
	hideUploader();

	<?php
}

?>
if(!multiple)
$('.actions .delete').click(function(){
	try{
    	parent.HpDeleteUpload('<?php echo $name ?>','<?php echo $lang ?>','<?php echo $domId ?>',filename);
	}
	catch(e)
	{
		
	}
	reloadUploader();
});

uploader.init();







/*explorer*/
function myCont(context,hand){
           return function()
           {
                hand.apply(context);
           }
    }
   var SiteBaseAdmin = '<?php echo $this->Html->url('/admin/',true); ?>'
function CExplorer()
{
    
    this.base = '<?php echo $this->Html->url('/',true); ?>',//'http://www.pcm-ensemblier.com/';
    this.containerId = null;
    this.extensionName = null;
    
   /* */
   this.close = function()
    {
       //$('#explorer').dialog('close');
    }
    this.open = function()
    {
        //   $('#'+Explorer.containerId+' div.plupload, #'+Explorer.containerId).css('z-index','999');
       //$('#explorer').dialog({
       //    modal:true
       //});
       $('#explorer').html('<div class="wait">Chargement</div>');
       $.post(SiteBaseAdmin+'/contents/files/'+this.extensionName,
              function(data){
                $('#explorer').html(data);
                
                $('#explorer .item').click(function(){
                    
                    filename=$(this).find('.title').html();
                        
                       displayImage(filename);
                        try{
							window.parent.HpUploadComplete('<?php echo $name ?>','<?php echo $lang ?>','<?php echo $domId ?>',filename);
						}
						catch(e)
						{
							$('#runtimeError').append("<div>Error: wrong cross-frame call</div>"
					                );
							return;
						}
                        
                        Explorer.close();
                });
                
                
              },
              'text');
        
    };
    
};
var Explorer = new CExplorer();

$('#pickfiles-container .distantfiled a ').click(myCont(this,function()
{
    Explorer.containerId = 'pickfiles-container';
    Explorer.extensionName = '<?php echo $extension; ?>';
    Explorer.open();
    return false;
    
}));
    

</script>

<?php

/*
?>

<div id="container">
    <div id="filelist">No runtime found.</div>
    <br />
    <a id="pickfiles" href="javascript:;">[Select files]</a> 
    <a id="uploadfiles" href="javascript:;">[Upload files]</a>
</div>


<script type="text/javascript">
// Custom example logic
function $(id) {
	return document.getElementById(id);	
}


var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,browserplus',
	browse_button : 'pickfiles',
	container: 'container',
	max_file_size : '10mb',
	url : '<?php echo $this->Html->url('/js/pluplad/examples/',true); ?>upload.php',
	resize : {width : 320, height : 240, quality : 90},
	flash_swf_url : '<?php echo $this->Html->url('/js/pluplad',true); ?>/js/plupload.flash.swf',
	silverlight_xap_url : '<?php echo $this->Html->url('/js/pluplad',true); ?>/js/plupload.silverlight.xap',
	filters : [
		{title : "Image files", extensions : "jpg,gif,png"},
		{title : "Zip files", extensions : "zip"}
	]
});

uploader.bind('Init', function(up, params) {
	$('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
});

uploader.bind('FilesAdded', function(up, files) {
	for (var i in files) {
		$('filelist').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
	}
});

uploader.bind('UploadProgress', function(up, file) {
	$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
});

$('uploadfiles').onclick = function() {
	uploader.start();
	return false;
};

uploader.init();
</script>
<?php */
?>
</body>
</html>