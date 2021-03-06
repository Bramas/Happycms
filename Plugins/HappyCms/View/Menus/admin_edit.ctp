<?php

echo $this->element('admin_create_form_item',array('formOptions'=>array('id'=>'ContentPageSaveForm','class'=>'ui-corner-all')));

?>
<span class="page-title"><?php echo $this->request->data['Content']['title']; ?></span>
<div class="form hidden">
<?php


//echo $this->Form->create('Menu', array('action' => 'save' , "admin" => "true"));
//echo $this->Form->input('Menu.parent_id', array('type'=>'select','options'=>$menu_parent,'label'=>'Menu parent : '));

//foreach(Configure::read('Config.id_languages') as $lang=>$lang_id)
{
    echo $this->Form->input('title', array('label'=>'Titre : ','class'=>'ui-corner-all'));
}
?>
<div class="other-input">
    <?php
    echo $this->Form->input('alias', array('label'=>'Alias : ','class'=>'ui-corner-all qtip','title'=>'Correspond au texte qui s\'affiche dans la barre d\'adresse du navigateur'));
    ?>
</div>

<?php

echo $this->Form->submit('Annuler', array('class'=>'cancel','type'=>'button'));
echo $this->Form->submit('Enregistrer');

?>
<div class="clear"> </div>
</div>
<span class="actions"><span class="edit">edit</span></span>

<?php

echo $this->Form->end();
?>


<script type="text/javascript">
    
    $(function(){
        
        $('#ContentPageSaveForm .actions .edit, #ContentPageSaveForm .page-title').click(function(){
            
                $('#ContentPageSaveForm .actions .edit').hide();
                $('#ContentPageSaveForm .page-title').hide();
                $('#ContentPageSaveForm .form').show();
                $('#ContentPageSaveForm .form .other-input, #ContentPageSaveForm .form .submit').hide().slideDown();
                $('#ContentPageSaveForm .form #ContentTitle').focus();
                
            });
        
        $('#ContentPageSaveForm .submit input.cancel').click(function(){
            
            
                
                $('#ContentPageSaveForm .form .other-input, #ContentPageSaveForm .form .submit').slideUp(function(){
                        $('#ContentPageSaveForm .actions .edit').show();
                        $('.page-title').show();
                        $('#ContentPageSaveForm .form').hide();
                    });
            return false;
        });
        
    });
    
</script>
<div class="separator"></div>


<?php

echo $controller_output['output'];


?>

