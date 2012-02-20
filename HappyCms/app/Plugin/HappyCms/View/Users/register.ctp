<div class="row">
	<div class="span14 offset1">
<?php
echo $this->Form->create('User');

echo '<h2>Informations de connexion</h2>';
echo $this->Form->input('username',array('label'=>'Pseudo : '));
echo $this->Form->input('password',array('label'=>'Mot de passe : '));
echo $this->Form->input('confirm_password',array('label'=>'Vérification du mot de passe : ','type'=>'password'));


echo '<h2>Informations privées</h2>';


echo $this->Form->input('email',array('label'=>'Email : '));

echo $this->Form->input('nom',array('label'=>'Nom : '));
echo $this->Form->input('prenom',array('label'=>'Prénom : '));

echo $this->Form->input('balise63',array('label'=>'Licencié balise 63 : '));
echo $this->Form->input('licence',array('label'=>'Numéro de Licence : '));
echo $this->Form->input('sport_id',array('label'=>'Numéro de doigt : ','type'=>'text'));

echo $this->Form->end('Créer un compte');

?>
<script type="text/javascript">
$(function(){
	
	$('#UserBalise63')

	function balise63CheckboxChange(t,duree)
	{
		if($(t).is(':checked'))
		{
			$('#UserLicence').parent().slideDown(duree);
			$('#UserSportId').parent().slideDown(duree);
		}
		else
		{
			$('#UserLicence').parent().slideUp(duree);
			$('#UserSportId').parent().slideUp(duree);
		}
	}
	$('#UserBalise63').change(function(){
		balise63CheckboxChange(this,'slow');
		
	});
	balise63CheckboxChange('#UserBalise63',0);

})

</script>

	</div>
</div>	

