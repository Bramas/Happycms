

$(function() {
		$( ".tabs" ).tabs();
    $( ".datepicker" ).each(function(){
      var alt = $(this).clone();
      alt.hide();
      $(this).after(alt);
      $(this).attr('name','');
      $(this).datepicker(
      { 
          altFormat: 'yy-mm-dd',
          dateFormat: 'dd/mm/yy',
          altField:alt
      });

      $(this).val($(this).val().replace(/^([^\/]*)-([^\/]*)-([^\/]*)$/,'$3/$2/$1'));

  });


    $('.notification>span').click(function(){
      $(this).parent().fadeOut('slow');
    });


                /*{
                                show:function(){
                                   alert('lol');             
                                }});*/
		//$('input:checkbox').checkbox();
                
                
                $('a.edit-category').live('click',function()
                {
                                $dialog = $('<iframe src="'+SiteBaseAdmin+"/contents/item_edit/categories/"+$(this).attr('item_id')+"?ajax=1&extension="+ExtensionName+'" />');//$('#create_new_category');
                    //$('body').append($dial);
                    $dialog.dialog({
                                width:820,
                                modal:true,
                                close:function()
                                {
                                                AjaxResults = eval('(' + AjaxResults + ')');
                                               if(AjaxResults && AjaxResults.newCat)
                                               {
                                                                for(var idx=0;idx<Languages.length;idx++)
                                                                {
                                                                                
                                                                                $('#languages-tabs #lang-tab-'+Languages[idx]+' .category-'+AjaxResults.newCat.id+'>span.title').html(AjaxResults.newCat[Languages[idx]].title);
                                                                             /*    newli = $('#languages-tabs #lang-tab-'+Languages[idx]+' #empty-category').clone().attr('id','').addClass('category-'+AjaxResults.newCat.id).show();
                                                                              newli.find('ul').first().before(AjaxResults.newCat[Languages[idx]].title);
                                                                              newli.find('input').each(function(){
                                                                                $(this).attr('name',$(this).attr('name').replace('empty-category',AjaxResults.newCat.id));
                                                                              if($(this).val())
                                                                              {
                                                                                $(this).attr('checked','checked');
                                                                              }
                                                                              });
                                                                              
                                                                               $('#languages-tabs #lang-tab-'+Languages[idx]+
                                                                                  ' .happy-category .category-'+AjaxResults.newCat.parent_id+'>ul').append(
                                                                                      //   '<li class="category-'+AjaxResults.newCat.id+'">'+
                                                                                     //    AjaxResults.newCat[Languages[idx]].title+'<ul></ul></li>'
                                                                                     newli
                                                                                );*/
                                                                }
                                               }
                                }
                    });
                    $dialog.css('width','800px');
                    $dialog.css('height','340px');
                /*    $.ajax(
                {
                url:SiteBaseAdmin+"admin/contents/item_edit/categories/?ajax=1&extension="+ExtensionName,
                success:function(t)
                           {
                                $dial.removeClass('wait');
                                $dial.html(t);
                           },
                context:$dial
                }
                           );
            //    */
                    
                    return false;
                });
                
                
                
                $('a.create-category').live('click',function()
                {
               //     var $dial = $('<div class="wait">Chargement...</div>');//$('#create_new_category');
                    $dialog = $('<iframe src="'+SiteBaseAdmin+"/contents/item_edit/categories/?ajax=1&extension="+ExtensionName+'" />');//$('#create_new_category');
                    //$('body').append($dial);
                    $dialog.dialog({
                                width:820,
                                modal:true,
                                close:function()
                                {
                                                AjaxResults = eval('(' + AjaxResults + ')');
                                               if(AjaxResults && AjaxResults.newCat)
                                               {
                                                                for(var idx=0;idx<Languages.length;idx++)
                                                                {
                                                                                 newli = $('#languages-tabs #lang-tab-'+Languages[idx]+' #empty-category').clone().attr('id','').addClass('category-'+AjaxResults.newCat.id).show();
                                                                              newli.find('span.title').first().html(AjaxResults.newCat[Languages[idx]].title);
                                                                              newli.find('input').each(function(){
                                                                                $(this).attr('name',$(this).attr('name').replace('empty-category',AjaxResults.newCat.id));
                                                                              if($(this).val())
                                                                              {
                                                                                $(this).attr('checked','checked');
                                                                              }
                                                                              });
                                                                              newli.find('span.actions span.action a').each(function(){
                                                                                                if($(this).attr('item_id'))
                                                                                                {
                                                                                                                $(this).attr('item_id',$(this).attr('item_id').replace('empty-category',AjaxResults.newCat.item_id));
                                                                                                }
                                                                                                                $(this).attr('href',$(this).attr('href').replace('empty-category',AjaxResults.newCat.item_id));
                                                                                });
                                                                              
                                                                               $('#languages-tabs #lang-tab-'+Languages[idx]+
                                                                                  ' .happy-category .category-'+AjaxResults.newCat.parent_id+'>ul').append(
                                                                                      //   '<li class="category-'+AjaxResults.newCat.id+'">'+
                                                                                     //    AjaxResults.newCat[Languages[idx]].title+'<ul></ul></li>'
                                                                                     newli
                                                                                );
                                                                }
                                               }
                                }
                    });
                    $dialog.css('width','800px');
                    $dialog.css('height','340px');
                /*    $.ajax(
                {
                url:SiteBaseAdmin+"admin/contents/item_edit/categories/?ajax=1&extension="+ExtensionName,
                success:function(t)
                           {
                                $dial.removeClass('wait');
                                $dial.html(t);
                           },
                context:$dial
                }
                           );
            //    */
                    
                    return false;
                });
                
                
                $('.happy-params-edit').click(function(){
                               if(!$(this).attr('item_id'))
                               {
                                return false;
                               }
                               $dialog = $('<iframe src="'+SiteBaseAdmin+'/contents/item_edit/extensions/'+$(this).attr('item_id')+'?ajax=1" />');//$('#create_new_category');
                               
                    //$('body').append($dial);
                    $dialog.dialog({
                                width:820,
                                modal:true,
                                close:function()
                                {
                                                AjaxResults = eval('(' + AjaxResults + ')');
                                               if(AjaxResults && AjaxResults.data)
                                               {
                                                                for(var idx=0;idx<Languages.length;idx++)
                                                                {
                                                                                $('#languages-tabs #lang-tab-'+Languages[idx]+' .param-page_intro').html(
                                                                                AjaxResults.data[Languages[idx]].page_intro
                                                                                );
                                                                }
                                               }
                                                
                                }
                    });
                    
                    $dialog.css('width','800px');
                    $dialog.css('height','340px');
                    return false;
                });
                
                
                $('.happy-displayMore').each(function(){
                                h=150;
                                if($(this).attr('happy-height'))
                                {
                                                h=$(this).attr('happy-height');
                                                
                                }
                                
                                if($(this).height()>h)
                                {
                                                $(this).attr('happy-height',h);
                                                $(this).attr('happy-realHeight',$(this).height());
                                                //$(this).removeClass('happy-displayMore');
                                                
                                                $(this).css('height',h+'px');
                                                a=$('<a>Afficher plus</a>');
                                                b=$('<a>Cacher</a>');
                                                b.hide();
                                                d=$('<span>... </span> ');
                                                d.append(a);
                                                d.append(b);
                                                $(this).after(d);
                                                a.click(function(){
                                                              $(this).parent().prev().animate({
                                                                height:$(this).parent().prev().attr('happy-realHeight')+'px'
                                                              },
                                                              800);
                                                              $(this).hide();
                                                              $(this).next().css('display','inline');
                                                });
                                                b.click(function(){
                                                              $(this).parent().prev().animate({
                                                                height:$(this).parent().prev().attr('happy-height')+'px'
                                                              },
                                                              800);
                                                              $(this).hide();
                                                              $(this).prev().show();
                                                });
                                }
                                
                });



        $('.togglePublished').click(function(){
          var lang = $(this).attr('lang');
          var menu_id = $(this).attr('menu_id');

            if($('#lang-tab-'+lang+' .togglePublished').attr('menu_id')==menu_id)
            {
              $('#lang-tab-'+lang+' .togglePublished').addClass('waitpublished');
            }

            $('#menus .menu-item-id-'+menu_id+'>div>span>.flags .'+lang+' span').addClass('waitpublished');

            $.ajax({
                
                url:SiteBaseAdmin+'/menus/togglePublished',
                data:{
                    "data[ajax]":1,
                    "data[_Menu][id]":menu_id,
                    "data[_Menu][language]":lang
                },
                type:'POST',
                success:function()
                {
                  $('#menus .menu-item-id-'+menu_id+'>div>span>.flags .'+lang+' span').removeClass('waitpublished');
                  if($('#lang-tab-'+lang+' .togglePublished').attr('menu_id')==menu_id)
                  {
                    $('#lang-tab-'+lang+' .togglePublished').toggleClass('unpublished').toggleClass('published').removeClass('waitpublished');;
                    $('#_Menu'+lang.charAt(0).toUpperCase() + lang.slice(1)+'Published').attr('checked', !$('#_Menu<?php echo ucfirst($HpLangForm); ?>Published').attr('checked'));
                  }
                    
                    $('#menus .menu-item-id-'+menu_id+'>div>span>.flags .'+lang+' span.published, #menus .menu-item-id-'+menu_id+'>div>span>.flags .'+lang+' span.unpublished').toggleClass('unpublished').toggleClass('published');
                }

            })
            return false;
        });
             
             
             
             
             
             
             /**
             * UPLOAD 
             */
             
             
    function reloadIframe()
    {
      $('iframe').load();
    }
    $( "#languages-tabs, .tabs" ).bind( "tabsshow",reloadIframe);  

    $('form').submit(function(){
          
          $(this).find('input.empty').remove();


    });

    $('.filesImagesContainter .item .actions .delete').live('click',function(){
        var e = $(this).parent().parent().parent().attr('extension');
        var dom = $(this).parent().parent().parent().attr('domid');
        var uid = $(this).parent().parent().attr('uid');
        var f = $(this).parent().parent().attr('title');
        $(this).parent().parent().hide();
        $(this).parent().parent().parent().append('<input name="data[Delete]['+e+'][]" type="hidden" value="'+f+'" />');
        $('#'+dom+' input[uid="'+uid+'"]').remove();
        
        //alert($('#'+dom+' input[uid="'+uid+'"]').length);
    })

               
	});
/*
function HpUploadComplete(name,lang,domId,filename)
{
  //single file upload
  $('input#'+domId).val(filename);

  //multiple files upload
  $('div#'+domId.' .empty').clone().val(filename).removeClass('empty');
  alert($('div#'+domId.' .empty').attr('class'));
}
function HpDeleteUpload(name,lang,domId,filename)
{
  $('#'+domId+'Delete').val(filename);
} */

