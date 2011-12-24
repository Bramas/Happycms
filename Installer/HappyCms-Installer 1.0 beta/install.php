<?php
if(!file_exists('unzip.php'))
{
	exit('Ce fichier doit être supprimé');
}
require_once('unzip.php');

$step = (int)(empty($_GET['step'])?1:$_GET['step']);
$content_for_layout = '';
switch ($step)
{
	default:
	case 1:
		if(!is_dir('app'))
		{
			$l = unzip('happycms.zip','');
			if(is_array($l))
			{
				$content_for_layout = 'le site a correctement été dézippé. <a href="install.php?step=2">Etape suivante></a>';
			}
			elseif(is_string($l))
			{
				$content_for_layout = $l;
			}
			else
			{
				$content_for_layout = 'Une erreur s\'est produite';
			}
		}
		else
		{
			$content_for_layout = 'le site à déjà été dézippé. <a href="install.php?step=2">Etape suivante></a>';
		}
		break;
	case 2:
		
		ob_start();
		?>
<h3>Configuration de la Base de données</h3>
<form method="POST" action="install.php?step=3">
	<div class="input"><label for="inputServer">Serveur</label><input id="inputServer" type="text" name="server" value="localhost"></div>
	<div class="input"><label for="inputDatabase">Nom de la base</label><input id="inputDatabase" type="text" name="database"></div>
	<div class="input"><label for="inputUser">Utilisateur</label><input id="inputUser" type="text" name="user" value="root"></div>
	<div class="input"><label for="inputPassword">Mot de passe</label><input id="inputPassword" type="text" name="password"></div>
	<div class="input"><label for="inputPrefix">Prefixe</label><input id="inputPrefix" type="text" name="prefix"></div>
	<div class="submit"><input type="submit" value="Etape Suivante"></div>
</form>


		<?php


		$content_for_layout = ob_get_clean();

		break;

	case 3:
	$toutEstOk = true;
	$content_for_layout='';
	if(empty($_POST))
	{
		header('Location:install.php?step=2');
		exit();
	}
	$server = $_POST['server'];
	$database = $_POST['database'];
	$user = $_POST['user'];
	$password = $_POST['password'];
	$prefix = $_POST['prefix'];

	$databaseConfig = 
'<?php

class DATABASE_CONFIG {

	var $default = array(
		\'datasource\' => \'Database/Mysql\',
		\'driver\' => \'mysql\',
		\'persistent\' => false,
		\'host\' => \''.$server.'\',
		\'login\' => \''.$user.'\',
		\'password\' => \''.$password.'\',
		\'database\' => \''.$database.'\',
		\'prefix\' => \''.$prefix.'\',
		\'encoding\' => \'utf8\'
	);

}
';
	//ini_set( "display_errors", 0);
	//error_reporting (E_ALL ^ E_NOTICE);
	$handle = fopen("app/config/database.php", "w");
	fwrite($handle, $databaseConfig);
	fclose($handle);
	$content_for_layout .= 'Configuration de la base : OK<br>';

	$co = mysql_connect($server,$user,$password);
	$content_for_layout .= 'Connexion au serveur : '.($co?'OK':'ERREUR').'<br>';
	$bdd = null;
	if($co)
	{
		$bdd=$co;
	}
	else
	{
		$toutEstOk=false;
	}

	$co = mysql_select_db($database,$bdd);
	$content_for_layout .= 'Connexion à la base : '.($co?'OK':'ERREUR').'<br>';
	$toutEstOk = $co && $toutEstOk;

// ------- Security Salt---------------------------
	function random($length,$char = "AZERTYUIOPMLKJHGFDSQNBVCXWabcdefghijklmnpqrstuvwxy0123456789") {
		$string = "";
		for($i=0; $i<$length; $i++) {
			$string .= $char[rand()%strlen($char)];
		}
		return $string;
	}
	srand((double)microtime()*1000000);
	$securitySalt		= random(100);
	$securityCipherSeed	= random(70,'0123456789');

	$contenu=file_get_contents('app/config/core.php');

	$contenu=str_replace('#Security.salt#', $securitySalt, $contenu);
	$contenu=str_replace('#Security.cipherSeed#', $securityCipherSeed, $contenu);

	$text=fopen('app/config/core.php','w+') or die("Fichier manquant");
	fwrite($text,$contenu);
	fclose($text); 


	$content_for_layout .= 'Génération des clefs de sécurité : OK<br>';

	/* Import Database ******************************/

	$requetes="";
 
	$sql=file("install.sql"); // on charge le fichier SQL
	foreach($sql as $l){ // on le lit
		if (substr(trim($l),0,2)!="--"){ // suppression des commentaires
			$requetes .= $l;
		}
	}
	$importOk = true;
	 $requetes = str_replace('#prefix#',$prefix, $requetes);
	$reqs = explode(";\n",$requetes);// on sépare les requêtes
	foreach($reqs as $req){
		// et on les éxécute
		if (!mysql_query($req,$bdd) && trim($req)!=""){
			die("ERROR : ".$req); // stop si erreur 
			$importOk = false;
		}
	}
	if($importOk)
	{
		$content_for_layout .= 'Importation de la base de donnéé : OK<br>';
	}
	else
	{
		$content_for_layout .= 'Importation de la base de donnéé : ERREUR<br>';
		$toutEstOk = false;
	}

	if($toutEstOk)
	{
		header('Location:install/index');
		exit();
	}
	
	break;
	case 4:


	unlink('install.sql');
	unlink('happycms.zip');
	unlink('unzip.php');
	unlink('.htaccess');
	unlink('app/Controller/InstallController.php');

	rename('_.htaccess','.htaccess');
	
	$content_for_layout='L\'installation est terminée. Veuillez noter vos identifiants nécessaires pour se connecter è l\'administration du site
	<div class="identifiants">
		<div><label>Identifiant : </label>admin</div>
		<div><label>Mot de passe : </label>linkadmin</div>
	</div>
	<a href="'.preg_replace('/\/([^\/]+)$/','',$_SERVER['PHP_SELF']).'">Voir le site</a>
	';




}


include 'install_layout.php';



