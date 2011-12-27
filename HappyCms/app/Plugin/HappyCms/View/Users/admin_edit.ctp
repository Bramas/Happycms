<?php

echo '<div>Identifiant : '.$User['username'].'</div>';

?>
<br />

	<ul>					
<li id="new-password-modal-link">
        <a href="#">
                
                <span>Modifier mon mot de passe</span>
        </a>
</li>

<li class="fade_hover tooltip" title="End current session">
        <?php echo $this->Html->link(
                '<span>Déconnexion</span>',
                array('controller'=>'users',
                      'action'=>'logout'),
                array('escape'=>false)); ?>

</li>
</ul>


<div id="new-password-dialog" title="Modification du mot de passe">  
            <h2>Modifier mon mot de passe</h2>
            <p><?php
echo $this->Form->create('User',array('url'=>'/admin/users/modify_password','id'=>'new-password-form'));

echo $this->element('form_token');

echo $this->Form->input('User.password',array('label'=>'Ancien mot de passe :'));
echo $this->Form->input('User.newpassword',array('type'=>'password','label'=>'Nouveau mot de passe :'));
echo $this->Form->input('User.newpassword2',array('type'=>'password','label'=>'Vérification du Nouveau mot de passe :'));
//echo $this->Form->submit('Modifier');
echo $this->Form->end();
?></p>
</div>
<script type="text/javascript">
jQuery( "#new-password-dialog" ).hide();
jQuery( "#new-password-modal-link").click(function(){
jQuery( "#new-password-dialog" ).dialog({
			//autoOpen: false,
			height: 400,
			width: 380,
			modal: true,
			buttons: {
				"Confirmer": function()
                                    {
                                        jQuery('#new-password-form').submit();
                                    }
                                }
                                
                                
                        });
});
</script>