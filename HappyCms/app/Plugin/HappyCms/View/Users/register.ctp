<div class="row">
<?php
echo $this->Form->create('User');

echo $this->Form->input('username',array('label'=>'Pseudo : '));
echo $this->Form->input('password',array('label'=>'Mot de passe : '));
echo $this->Form->input('confirm_password',array('label'=>'Vérification du mot de passe : ','type'=>'password'));



echo $this->Form->end('Créer un compte');

?>
</div>
