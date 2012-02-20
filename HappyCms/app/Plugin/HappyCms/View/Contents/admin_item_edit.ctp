
<script type="text/javascript">
	var ExtensionName = "<?php echo $ExtensionName; ?>";
</script>
<?php

$this->request->data['Happy']['first_call']=true;
echo $this->element('admin_create_form_item',array_merge(array('action'=>'save'),(array)$formOptions));

$this->Tinymce->script();
$this->Tinymce->editor(array( 'theme' => 'advanced' ,
                        'mode' => "textareas",
                        'theme_advanced_toolbar_location' => "top",
                        'theme_advanced_toolbar_align' =>  "left",
                        'theme_advanced_statusbar_location' =>  "bottom",
                        'theme_advanced_resizing' =>  true,
                        'width' => '100%'
                       ),array('extension'=> $ExtensionName,'id'=> $item_id));


?>
<input name="data[_redirect]" class="_redirect" value="default" class="" type="hidden" />
<div class="head-action">
    <div class="submit-action">
        <?php 
        echo $this->Form->submit('Enregistrer',array('class'=>'save qtip','redirect'=>'default','title'=>'Enregistrer'));
        echo $this->Form->submit('Enregistrer et quitter',array('class'=>'saveAndQuit qtip','redirect'=>'quit','title'=>'Enregistrer et quitter'));

        ?>
    </div>
    <div class="file-edit-action">
        <?php
        
        if(Configure::read('HappyCms.fileEdit.frontView'))
        {
            echo $this->Html->link('Editer la vue','/admin/files/edit/app/View/'.ucfirst(Configure::read('HappyCms.fileEdit.controller')).'/'.Configure::read('HappyCms.fileEdit.frontView').'.ctp',
            array('class'=>'front qtip','title'=>'Editer la vue'));
        }
        if(Configure::read('HappyCms.fileEdit.adminView'))
        {
            echo $this->Html->link('Editer la vue admin','/admin/files/edit/app/View/'.ucfirst(Configure::read('HappyCms.fileEdit.controller')).'/'.Configure::read('HappyCms.fileEdit.adminView').'.ctp',
            array('class'=>'admin qtip','title'=>'Editer la vue admin'));
        }
        $layoutFile = 'default';
        if(Configure::read('HappyCms.fileEdit.layout'))
        {
            $layoutFile = Configure::read('HappyCms.fileEdit.layout');
        }
            echo $this->Html->link('Editer le layout','/admin/files/edit/app/Plugin/HappyCms/View/Layouts/'.$layoutFile.'.ctp',
            array('class'=>'layout qtip','title'=>'Editer le layout'));
        
          ?>
    </div>
</div>
<div id="shared-output">
<?php echo $shared_output; ?>
</div>

<?php
if(Configure::read('Config.multilanguage'))
{


echo '<div id="languages-tabs"><ul>';
$closeButton = empty($this->request->data['Happy']['force_all_languages'])?'<span class="ui-icon ui-icon-close">Remove Tab</span>':'';

foreach($form_languages as $lang=>$lang_name)
{
    echo '<li lang="'.$lang.'"><a href="#lang-tab-'.$lang.'">'.$lang_name.'</a>'.$closeButton.'</li>';
}
    echo '<li id="lang-li-add-language" class="tabaddeur"><a href="#lang-tab-add-language">+</a></li>';
echo '</ul>';

foreach($controller_output as $lang=>$output)
{
    echo '<div id="lang-tab-'.$lang.'">'.
    $output.
    '</div>';
}


echo '<div id="lang-tab-add-language"></div></div>';

}
else
{
    
    $controller_output = current($controller_output);

echo '<div id="lang-tab-'.Configure::read('Config.language').'">'.
    $controller_output.
    '</div>';


}
echo '<div class="submit-action">';
echo $this->Form->submit('Enregistrer',array('class'=>'save','redirect'=>'default'));
echo '</div>';

echo $this->Form->end();

?>

<script type="text/javascript">
$(function(){
    $('#edit-panel>form .submit input').click(function(){
        $('#edit-panel>form ._redirect').val($(this).attr('redirect'));

    });
    $('#edit-panel>form').submit(function()
    {
        $(this).parent().addClass('submited');

    });
});
</script>
<?php if(Configure::read('Config.multilanguage'))
{
    ?>
    <div id="dialog-choose-a-lang">
    
    <form action="">
        <select name="lang" id="">
            <?php
            foreach(Configure::read('Config.name_languages') as $lang=>$lang_name)
            {
                if(array_key_exists($lang,$controller_output))
                {
                    continue;
                }
                
                echo '<option value="'.$lang.'">'.$lang_name.'</option>';
            }
            ?>
        </select>
    </form>
    
</div>
<script type="text/javascript">
    
    $(function(){
        
        


        var languages = {
            <?php
            foreach(Configure::read('Config.name_languages') as $code=>$name)
            {
                echo '"'.$code.'":"'.$name.'",';
            }
            ?>
        }
        
        var $lang_dialog = $( "#dialog-choose-a-lang" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				Add: function() {
					addTab();
					$( this ).dialog( "close" );
				},
				Cancel: function() {
                                        $('#languages-tabs').tabs("select", 0);
					$( this ).dialog( "close" );
				}
			},
			open: function() {
				
			},
			close: function() {
				
			}
		});

        
        
        var $lang_tabs = $('#languages-tabs').tabs({
                tabTemplate: '<li><a  href="#{href}">#{label}</a> <?php echo $closeButton; ?></li>',
                add: function( event, ui ) {
				
				
                                if($(ui.tab).html()=='+')
                                {
                                    $(ui.tab).parent().addClass('tabaddeur');
                                    $(ui.tab).parent().find('span').remove();
                                    $( ui.panel ).append( '<p><div>Recharger la page</div></p>' );
                                }
                                else
                                {
                                    $( ui.panel ).append( '<p><div class="wait">Chargement...</div></p>' );
                                }
			},
                select:function(event,ui){
                    //alert($(ui.tab).html());
                    if($(ui.tab).html()=='+')
                    {
                        
                        $lang_dialog.dialog( "open" );
                        
                    }
                }
            
            });
        if(!$('option',$lang_dialog).length)
        {
            $lang_tabs.tabs('remove',-1);
        }
        function addTab()
        {
            
            
            $lang_tabs.tabs('remove',-1);
            $('#languages-tabs').tabs("add",
                                      "#lang-tab-"+$('option:selected',$lang_dialog).val() ,
                                      $('option:selected',$lang_dialog).html());
            
            $lang_tabs.tabs('select', "#lang-tab-"+$('option:selected',$lang_dialog).val());
            
            $('li', $lang_tabs).last().attr('lang',$('option:selected',$lang_dialog).val());
            
            $.ajax({
                url:"<?php echo $this->Html->url('/admin/contents/item_add_form/'.$ExtensionName.'/',true); ?>"+
                   $('option:selected',$lang_dialog).val()+
                   "<?php echo '/'.$item_id; ?>",
                   
                    success:function(t){
                        $('#lang-tab-'+this).html(t);
                        addEditors();
                        $('.tabs').tabs();
                        $('input:checkbox').checkbox();
                    },
                    context:$('option:selected',$lang_dialog).val()
            });
            
            $('option:selected',$lang_dialog).remove();
            if($('option',$lang_dialog).length)
            $('#languages-tabs').tabs("add", "#lang-tab-add-language" , '+');
        };
        
        $( "#languages-tabs span.ui-icon-close" ).live( "click", function() {
			
                        if($('#languages-tabs>ul>li').length==2)
                        {
                            //if(!confirm('êtes vous sur de tout vouloir supprimer?'))
                           // {
                           //     return;
                            //}
                        }
                        
                        if(!confirm('êtes vous sur de tout vouloir supprimer pour cette langue?'))
                        {
                            return;
                        }
                        
                        var index = $( "li", $lang_tabs ).index( $( this ).parent() );
                        
                        $('select',$lang_dialog).append('<option value="'+$(this).parent().attr('lang')+'">'+languages[$(this).parent().attr('lang')]+'</option>');
                 
                        if($('option',$lang_dialog).length && !$('#languages-tabs>ul>li.tabaddeur').length)
                            $('#languages-tabs').tabs("add", "#lang-tab-add-language" , '+');
                            
                        $.ajax({
                            url:"<?php echo $this->Html->url('/admin/'.$ExtensionName.'/to_trash/'.$item_id.'/',true); ?>"+
                            $(this).parent().attr('lang'),
                            context:index,
                            type:'POST',
                            data:{
                                "data[ajax]":1
                            },
                            success:function(t)
                            {
                               if( $('#languages-tabs>ul>li').length==2)
                                {
                                    location.href="<?php echo $this->Html->url('/admin/',true); ?>";
                                }
                                else
                                {
                                        $('#languages-tabs').tabs("select", 0);
                                        $lang_tabs.tabs( "remove", index );
                                }
                                
                                 
                            }
                        });
                        $( this ).parent().html('<a><div class="wait deleting">Suppression...</div></a>');
                        
                            
                            
                                              
                        
                        
                        
                });
        
        
    });
    
</script>
<?php 
}
    ?>