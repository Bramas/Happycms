<div class="grid_3 push_5"><?php
echo $this->Form->create('User',array("action"=>"login"));
echo $this->Form->input('username' ,array('value'=>'Identifiant','label'=>''));
echo $this->Form->input('password' ,array('value'=>'password','type'=>'password','label'=>''));
echo $this->Form->end('Connexion');
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