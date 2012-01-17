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
		margin:0;
		padding:0;
	}
</style>

<?php  echo $this->Html->css('/HappyCms/css/admin_style'); ?>
<?php  echo $this->Html->css('/HappyCms/css/admin_happy'); 
		echo $this->Html->css('/HappyCms/css/pepper-grinder/jquery-ui');

echo $this->Html->script('jquery.min');
		echo $this->Html->script('jquery-ui.min'); ?>
<?php  echo $this->Html->script('plupload/js/plupload.full.js'); ?>

<!-- <script type="text/javascript"  src="http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js"></script> -->
<script type="text/javascript">
	
function tabshow()
{
		if(!INITIATE)
		{
			
			window.location.reload(true);

		}
	/*	alert(Explorer?'lol':'pas');
		

		alert('1.2');
		Explorer.containerId = 'pickfiles-container';
		alert('1.3');
Explorer.extensionName = '<?php echo $extension; ?>';
		alert('2');
Explorer.open();
		alert('3');
*/


};


function sendFileToParentFrame(name,url,id)
{
	try
	{
		window.parent.onFileUploaded(name,url,id,'<?php echo $domId; ?>');
	}
	catch(e)
	{
		
	}
}

</script>




</head>
<body id="bodyId">

<?php 


	?>
<div class="input file">
	<div id="file">
		<div id="pickfiles-container">
			<div id="runtimeError">Chargement...</div>
		    <div class="a pickfiles" id="pickfiles" href="javascript:;"><?php echo $this->Html->image('/img/boxupload32.png'); ?>
				<a>Choisir un fichier sur mon ordinateur</a>
		    </div> 
		    <!--<a id="uploadfiles" href="javascript:;">[Upload files]</a>
		    <a id="hideForm" href="javascript:;">hide</a>-->
		</div>
		<div id="result">
			<div class="image">
		    	
		    </div>
		</div>
		<div id="loader">
			
		</div>
		<div id="finishList">
			
		</div>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
	/*
	$('body').append($('<div>test</div>').click(function(){
		alert('lol1');
		window.parent.testFrame();

	}));*/

</script>
<script type="text/javascript">
var filesNumberLimit = <?php echo $filesNumberLimit; ?>; 
var filename = '';
INITIATE = true;

if(!window.getComputedStyle(document.getElementById("bodyId"), null)){
	INITIATE = false;
}
else
{

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles',
	container: 'pickfiles-container',
	max_file_size : '20mb',
	url : '<?php echo $this->Html->url(array('plugin'=>'media','controller'=>'manager','action'=>'upload','admin'=>true)); ?>'+'?'+
                'contextId=<?php echo $contextId; ?>'+
                '&contextExtension=<?php echo $contextExtension; ?>'+
                '&',
    chunk_size:'100kb',
	//resize : {width : 320, height : 240, quality : 90},
	flash_swf_url : '<?php echo $this->Html->url('/js/plupload/js/plupload.flash.swf',true); ?>',
	silverlight_xap_url : '<?php echo $this->Html->url('/js/plupload/js/plupload.silverlight.xap',true); ?>',
	filters : [
		{title : "Image files", extensions : "jpg,jpeg,gif,png,bmp"},
		{title : "Zip files", extensions : "zip"},
		{title : "Pdf files", extensions : "pdf"},
		{title : "Doc files", extensions : "odt,doc,docx"}
	]
});






uploader.bind('Init',function(up, params) {
	$('#runtimeError').html("");//<div>Current runtime: " + params.runtime + "</div>";
});

uploader.bind('FilesAdded', function(up, files) {
	for (var i in files) {
		$('#loader').append('<div id="' + files[i].id + '">'
		 //+ files[i].name + ' (' + plupload.formatSize(files[i].size) + ') '
		 +'<div class="bar"><div></div><b></b></div></div>');
	}
	//up.refresh();
	//hideUploader();
	setTimeout(function(){ 
		uploader.start();
	 },100);
});

uploader.bind('UploadFile', function(up, file) {
		
});

uploader.bind('UploadProgress', function(up, file) {
	
	$('#'+file.id+' b').html('<span>' + file.percent + "%</span>");
	$('#'+file.id+' div.bar div').css('width',file.percent*3);
});
uploader.bind('Error', function(up, err) {
            
		switch(err.code)
        {
            case plupload.FILE_SIZE_ERROR:
                alert('Le fichier est trop volumineux');
                break;
            case plupload.FILE_EXTENSION_ERROR:
                alert('Le type du fichier n\'est pas accepté.');
                break;
            case plupload.IMAGE_FORMAT_ERROR:
                alert('Le Format de l\'image n\'est pas bon.');
                break;
            case plupload.IMAGE_MEMORY_ERROR:
                alert('L\'image utilise trop de mémoire.');
                break;
            case plupload.IMAGE_DIMENSIONS_ERROR:
                alert('Les dimensions de l\'image ne sont pas acceptées.');
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
	//try{
		sendFileToParentFrame(jresp.realName,jresp.url,jresp.id);

	/*	window.parent.HpUploadComplete('<?php
		// echo $name 
		?>','<?php
		 //echo $lang
		  ?>','<?php
		   //echo $domId 
		   ?>',jresp.realName);*/
	/*}
	catch(e)
	{
		$('#runtimeError').append("<div>Error: wrong cross-frame call</div>"
                );
		return;
	}*/

	$('#'+file.id).appendTo('#finishList');

});




uploader.init();




   
}

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