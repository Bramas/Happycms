<div class="grid_3 push_5"><?php
echo $form->create('User',array("action"=>"login"));
echo $form->input('username' ,array('value'=>'Identifiant','label'=>''));
echo $form->input('password' ,array('value'=>'password','type'=>'password','label'=>''));
echo $form->end('Connexion');
?></div>
<script type="text/javascript">
    $('#UserUsername').focus(function(){
        if($(this).val()=='Identifiant')
        {
            $(this).val('');
        }
    });
    $('#UserUsername').blur(function(){
        if($(this).val()=='')
        {
            $(this).val('Identifiant');
        }
    });
    
    $('#UserPassword').focus(function(){
        if($(this).val()=='password')
        {
            $(this).val('');
        }
    });
    $('#UserPassword').blur(function(){
        if($(this).val()=='')
        {
            $(this).val('password');
        }
    });
</script>