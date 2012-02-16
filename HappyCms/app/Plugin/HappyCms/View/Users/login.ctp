<?php
echo $this->Form->create('User');//,array("action"=>"login",'url'=>'/admin/users/login/'));
echo $this->Form->input('username' ,array('label'=>''));
echo $this->Form->input('password' ,array('type'=>'password','label'=>''));
echo $this->Form->end('Connexion');
?>
<script type="text/javascript">
 /*   $('#UserUsername').focus(function(){
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
    });*/
</script>