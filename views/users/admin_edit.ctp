<?php

echo '<div>Identifiant : '.$User['username'].'</div>';

?>
<br />

	<ul>					
<li id="new-password-modal-link">
        <a href="#">
                <img src="./assets/icons/dashboard/54.png" alt="" />
                <span>Modifier mon mot de passe</span>
        </a>
</li>

<li class="fade_hover tooltip" title="End current session">
        <?php echo $html->link('<img src="./assets/icons/dashboard/118.png" alt="" />'.
                '<span>Déconnexion</span>',
                array('controller'=>'users',
                      'action'=>'logout'),
                array('escape'=>false)); ?>

</li>
</ul>


<div id="new-password-dialog" title="Modification du mot de passe">  
            <h2>Modifier mon mot de passe</h2>
            <p><?php
echo $form->create('User',array('action'=>'modify_password','id'=>'new-password-form'));

echo $this->element('form_token');

echo $form->input('User.password',array('label'=>'Ancien mot de passe :'));
echo $form->input('User.newpassword',array('type'=>'password','label'=>'Nouveau mot de passe :'));
echo $form->input('User.newpassword2',array('type'=>'password','label'=>'Vérification du Nouveau mot de passe :'));
//echo $form->submit('Modifier');
echo $form->end();
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