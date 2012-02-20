<div class="user-edit row">
	<div class="offset1 span 14">
		<?php

			echo $this->Form->create('User');



			echo $this->element('happy/fields/file',array('label'=>'Image perso : ','name'=>'avatar','model'=>'User'));


			echo $this->Form->input('username',array('label'=>'Pseudo : ','disabled'=>'disabled'));
			echo $this->Form->input('password',array('label'=>'Mot de passe : ','value'=>'', 'autocomplete'=>'off'));
			echo $this->Form->input('confirm_password',array('label'=>'Vérification du mot de passe : ','type'=>'password','value'=>'', 'autocomplete'=>'off'));


		
			echo $this->Form->end('Enregistrer');

		?>
		
</div>
</div>