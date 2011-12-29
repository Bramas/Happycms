<script type="text/javascript">
	ExtensionName = "<?php echo $SubExtensionName; ?>";
</script>
<?php

$controller_output['formOptions'] = empty($controller_output['formOptions'])?array():$controller_output['formOptions'];

echo $this->element('admin_create_form_item',array('model'=>'Menu','formOptions'=>$controller_output['formOptions']));

?>
<div class="ContentMenuInfoForm ui-corner-all">
<span title="Cliquez pour <?php

 echo empty($this->request->data['_Menu']['published'])?'publier':'dépublier';

 ?> cette page" lang="<?php echo $HpLangForm; ?>" menu_id="<?php echo $this->request->data["_Menu"]['id']; ?>" class="togglePublished qtip <?php echo empty($this->request->data['_Menu']['published'])?'unpublished':'published'; ?>" 

 >
<script type="text/javascript">
    
    $(function(){
        /*$('#lang-tab-<?php echo $HpLangForm; ?> .togglePublished').click(function(){
            $('#lang-tab-<?php echo $HpLangForm; ?> .togglePublished').addClass('waitpublished');
            $.ajax({
                
                url:'<?php echo $this->Html->url('/admin/menus/togglePublished') ; ?>',
                data:{
                    "data[ajax]":1,
                    "data[_Menu][id]":'<?php echo $this->request->data["_Menu"]['id']; ?>',
                    "data[_Menu][language]":'<?php echo $HpLangForm; ?>'
                },
                type:'POST',
                success:function()
                {
                    $('#lang-tab-<?php echo $HpLangForm; ?> .togglePublished').toggleClass('unpublished').toggleClass('published').removeClass('waitpublished');;
                    $('#_Menu<?php echo ucfirst($HpLangForm); ?>Published').attr('checked', !$('#_Menu<?php echo ucfirst($HpLangForm); ?>Published').attr('checked'));

                    $('span.current>.flags .<?php echo $HpLangForm; ?> span.published, span.current>.flags .<?php echo $HpLangForm; ?> span.unpublished').toggleClass('unpublished').toggleClass('published');
                }

            })
        });*/
        

    });

</script>
</span>
<span class="page-title"><?php echo (empty($this->request->data['_Menu']['title'])?'[title]':$this->request->data['_Menu']['title']); ?></span>
<div class="form hidden">
<?php

    echo $this->Form->input('title', array('label'=>'Titre : ','class'=>'ui-corner-all input-title'));

?>
<div class="other-input">
    <?php
    echo $this->Form->input('alias', array('label'=>'Alias : ','class'=>'ui-corner-all qtip','title'=>'Correspond au texte qui s\'affiche dans la barre d\'adresse du navigateur'));

    ?>
    <div class="input text">
    <label >Page en ligne : </label>
    <?php echo $this->Form->input('published',array('type'=>'checkbox','label'=>false)); ?>
    </div>
    <?php echo $this->Form->input('class',array('type'=>empty($is_linksite)?'hidden':'text')); ?>
</div>

<?php

echo $this->Form->submit('^', array('class'=>'close','type'=>'button'));
?>
<div class="clear"> </div>
</div>
<span class="actions"><span class="edit">edit</span></span>
<script type="text/javascript">
    
    $(function(){
        
        $('.ContentMenuInfoForm .actions .edit, .ContentMenuInfoForm .page-title').click(function(){
            
                $('.ContentMenuInfoForm .actions .edit').hide();
                $('.ContentMenuInfoForm .page-title').hide();
                $('.ContentMenuInfoForm .form').show();
                $('.ContentMenuInfoForm .form .other-input, .ContentMenuInfoForm .form .submit').hide().slideDown();
                $('.ContentMenuInfoForm .form .ContentTitle').focus();
                
            });
        
        $('.ContentMenuInfoForm .submit input.close').click(function(){
            
                $(this).parent().parent().parent().find('.page-title').html($(this).parent().parent().find('.input-title').val());
                
                $('.ContentMenuInfoForm .form .other-input, .ContentMenuInfoForm .form .submit').slideUp(function(){
                        $('.ContentMenuInfoForm .actions .edit').show();
                        $('.page-title').show();
                        $('.ContentMenuInfoForm .form').hide();
                    });
            return false;
        });
        
    });
    
</script>
</div>
<div class="separator"></div>
<?php



echo ($controller_output['output']);



echo $this->element('admin_end_form_item');


?>