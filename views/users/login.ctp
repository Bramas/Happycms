<?php
echo $form->create('User',array("action"=>"login"));
echo $form->input('username' ,array('label'=>'Pseudo :'));
echo $form->input('password' ,array('label'=>'Mot de passe :'));
echo $form->end('Connexion');
?>