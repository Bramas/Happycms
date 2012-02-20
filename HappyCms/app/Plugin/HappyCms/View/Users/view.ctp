<div class="user-view row">
	<div class="offset1 span 14">
		<?php
		if($User['id'] == $viewUser['User']['id'])
		{
			echo '<div>'.$this->Html->link('Modifier mon compte',array('controller'=>'users','action'=>'edit',$viewUser['User']['id'].'-'.$viewUser['User']['username'])).'</div>';
		}	
			echo '<div class="avatar">'.$this->Html->image('/files/uploads/users/'.$viewUser['User']['avatar'].'_150x150').'</div>';
			echo '<div class="username"><label>Pseudo : </label><span>'.$viewUser['User']['username'].'</span></div>';

		?>
	</div>
</div>