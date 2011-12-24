
    /*
    function concatObject(obj) {
  str='';
  for(prop in obj)
  {
    str+=prop + " value :"+ obj[prop]+"\n";
  }
  return(str);
}*/
function myCont(context,hand){
           return function()
           {
                hand.apply(context);
           }
    }
function CExplorer()
{
    
    this.base = SiteBase,//'http://www.pcm-ensemblier.com/';
    this.containerId = null;
    this.extensionName = null;
    
   /* */
   this.close = function()
    {
       $('#explorer').dialog('close');
    }
    this.open = function()
    {
           $('#'+Explorer.containerId+' div.plupload, #'+Explorer.containerId+' form').css('z-index','999');
       $('#explorer').dialog({
           modal:true
       });
       $('#explorer').html('<div class="wait">Chargement</div>');
       $.post(SiteBaseAdmin+'/contents/files/'+this.extensionName,
              function(data){
                $('#explorer').html(data);
                
                $('#explorer .item').click(function(){
                    filename=$(this).find('.title').html();
                        $('#'+ Explorer.containerId+' .actions').show();
                        $('#'+ Explorer.containerId+' .image').show();
                        $('#'+ Explorer.containerId+' .wait').hide();
                        $('#'+ Explorer.containerId+' .a').hide();
                      $('#'+Explorer.containerId+' div.plupload, #'+Explorer.containerId+' form').hide();
                        $('#'+ Explorer.containerId+' .image').html(
                                        '<img height="50" src="'+SiteBase+
                                        'files/uploads/'+Explorer.extensionName+'/'+filename+'_0x100"/>');
                        $('#input-'+ Explorer.containerId).val(filename);
                        //filename = $('#input-delete-'+ context.containerId).val();
                        
                        Explorer.close();
                });
                
                
              },
              'text');
        
    };
    
};
var Explorer = new CExplorer();
    
    
    
    
    
    
    
function waitBeforeClose()
{
    return ("Toutes les Images n'ont pas encore été envoyé, êtes vous sur de ne pas vouloir attendre la fin du chargement?");
}
function  reloadFileField(context)
{
    return function(){
        //alert(context.contentId);
    $('#'+ context.containerId+' .actions').hide();
    $('#'+ context.containerId+' .image').hide();
    $('#'+ context.containerId+' .wait').hide();
    $('#'+ context.containerId+' .a').show();
    $('#'+context.containerId+' div.plupload, #'+context.containerId+' form').show().css('width',$('#'+ context.containerId+' a').css('width'));
    $('#'+context.containerId+' div.plupload, #'+context.containerId+' form').css('height',$('#'+ context.containerId+' a').css('height'));
    filename = $('#input-'+ context.containerId).val();
    $('#input-delete-'+ context.containerId).val(filename);
    
    
    $('#input-'+ context.containerId).val('');
        //context = new fileField( context.extensionName, context.name, context.contentId);
    };
}
function fileField(extensionName,name,lang,contentId,fileName,in_filters)
{
    
    this.name = name;
    this.lang = lang;
    this.extensionName = extensionName;
    this.contentId = contentId;
    this.containerId = 'file-'+name+'-'+lang;
    this.base = SiteBase;//'http://www.pcm-ensemblier.com/';

if(fileName==null)
{
    $('#'+ this.containerId+' .actions').hide();
    $('#'+ this.containerId+' .image').hide();
    $('#'+ this.containerId+' .wait').hide();
    $('#'+ this.containerId+' .a').show();
    $('#'+this.containerId+' div.plupload, #'+this.containerId+' form').show().css('width',$('#'+ this.containerId+' a').css('width'));
    $('#'+this.containerId+' div.plupload, #'+this.containerId+' form').css('height',$('#'+ this.containerId+' a').css('height'));
}
else{
    $('#'+ this.containerId+' .actions').show();
    $('#'+ this.containerId+' .image').show();
    $('#'+ this.containerId+' .wait').hide();
    $('#'+ this.containerId+' .a').hide();
    $('#'+this.containerId+' div.plupload, #'+this.containerId+' form').hide();
       
    $('#'+ this.containerId+' .image').html(
		    '<img src="'+this.base+
                    'files/uploads/'+this.extensionName+'/'+fileName+'_0x100"/>');
}
 
    
    
    
    $('#'+ this.containerId+'-distantfiled').click(myCont(this,function()
    {
        Explorer.containerId = this.containerId;
        Explorer.extensionName = this.extensionName;
        Explorer.open();
        
    }));
    
    
    
    
    $('#'+ this.containerId+' .actions .delete').click(reloadFileField(this));
    
    
    
	var uploader = new plupload.Uploader({
                happy:this,
		multiple_queues:true,
		runtimes : 'flash,silverlight,html4',
		browse_button : this.containerId+'-pickfiles',
		container :this.containerId,
		max_file_size : '6mb',
		url : SiteBaseAdmin+'/contents/upload?extension='+
                this.extensionName+
                '&fieldname='+this.name+
                '&contentid='+this.contentId+
                '&lang='+this.lang+
                '&',
		/*url : 'http://127.0.0.1:8888/pcm-ensemblier.com/cakephp/upload_so.php?extension=<?php
                
                echo $ExtensionName.'&fieldname='.$name.'&';
                
                ?>',*/
		flash_swf_url : SiteBase+'/js/plupload/plupload.flash.swf',
		silverlight_xap_url : SiteBase+'/js/plupload/plupload.silverlight.xap',
              filters:in_filters,
		resize : {width : 1600, height : 1600, quality : 90}
	});

	uploader.bind('Init', function(up, params) {
		$('#filelist').html("<div style=\"display:none\">Current runtime: " + params.runtime + "</div>");
	});

	$('#uploadfiles').click(function(e) {
		//uploader.start();
		e.preventDefault();
	});

	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {
            
        
            
		$.each(files, function(i, file) {
                    if(i>0)
                    {
                        up.removeFile(files[i]);
                    }
                    else
                    {
			$('#filelist').append(
				'<div id="' + files[i].id + '">' +
				files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b>' +
			'</div>');
                    }
		});
                $(window).bind('beforeunload',waitBeforeClose);
		$('#'+this.settings.container+' .a').hide();
                $('#'+this.settings.container+' div.plupload, #'+this.settings.container+' form').hide();
		$('#'+this.settings.container+' .wait').show();
		up.refresh(); // Reposition Flash/Silverlight
		this.start();
		//e.preventDefault();
	});

	uploader.bind('UploadProgress', function(up, file) {
		$('#' + file.id + " b").html(file.percent + "%");
	});
	uploader.bind('Error', function(up, err) {
            
		switch(err.code)
                {
                    case plupload.FILE_SIZE_ERROR:
                        alert('Le fichier est trop volumineux');
                        break;
                    default:
                            $('#filelist').append("<div>Error: " + err.code +
                                ", Message: " + err.message +
                                (err.file ? ", File: " + err.file.name : "") +
                                "</div>"
                        );
                    break;
                }
                

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file,resp) {
                $(window).unbind('beforeunload',waitBeforeClose);
            
		jresp = JSON.parse(resp.response);
		
		$('#' + file.id + " b").html("100%");
                $('#'+this.settings.container+' .image').html(
		    '<img src="'+this.settings.happy.base+
                    'files/uploads/'+this.settings.happy.extensionName+'/'+jresp.realName+'_0x100"/>');
		$('#input-'+this.settings.container).val(jresp.realName);
		$('#'+this.settings.container+' .wait').hide();
		$('#'+this.settings.container+' .image').show();
		$('#'+this.settings.container+' .actions').show();
	});
        
};
	
	
