<?php
function unzip($file, $path='', $effacer_zip=false)
{/*Méthode qui permet de décompresser un fichier zip $file dans un répertoire de destination $path
  et qui retourne un tableau contenant la liste des fichiers extraits
  Si $effacer_zip est égal à true, on efface le fichier zip d'origine $file*/
	
	$tab_liste_fichiers = array(); //Initialisation

	$zip = zip_open($file);
	if (is_resource($zip))
	{
		while ($zip_entry = zip_read($zip)) //Pour chaque fichier contenu dans le fichier zip
		{
			if (zip_entry_filesize($zip_entry) > 0)
			{
				$complete_path = $path.dirname(zip_entry_name($zip_entry));

				/*On supprime les éventuels caractères spéciaux et majuscules*/
				$nom_fichier = zip_entry_name($zip_entry);
				$nom_fichier = strtr($nom_fichier,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");
				//$nom_fichier = strtolower($nom_fichier);
				//$nom_fichier = ereg_replace('[^a-zA-Z0-9.\/_]','-',$nom_fichier);

				/*On ajoute le nom du fichier dans le tableau*/
				array_push($tab_liste_fichiers,$nom_fichier);

				$complete_name = $path.$nom_fichier; //Nom et chemin de destination

				if(!file_exists($complete_path))
				{
					$tmp = '';
					foreach(explode('/',$complete_path) AS $k)
					{
						$tmp .= $k.'/';

						if(!file_exists($tmp))
						{ mkdir($tmp, 0755); }
					}
				}

				/*On extrait le fichier*/
				if (zip_entry_open($zip, $zip_entry, "r"))
				{
					$fd = fopen($complete_name, 'w');

					fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));

					fclose($fd);
					zip_entry_close($zip_entry);
				}
			}
		}
		

		zip_close($zip);

		/*On efface éventuellement le fichier zip d'origine*/
		if ($effacer_zip === true)
		unlink($file);
	}else
		{
			function zipFileErrMsg($errno) {
  // using constant name as a string to make this function PHP4 compatible
				  $zipFileFunctionsErrors = array(
				    'ZIPARCHIVE::ER_MULTIDISK' => 'Multi-disk zip archives not supported.',
				    'ZIPARCHIVE::ER_RENAME' => 'Renaming temporary file failed.',
				    'ZIPARCHIVE::ER_CLOSE' => 'Closing zip archive failed',
				    'ZIPARCHIVE::ER_SEEK' => 'Seek error',
				    'ZIPARCHIVE::ER_READ' => 'Read error',
				    'ZIPARCHIVE::ER_WRITE' => 'Write error',
				    'ZIPARCHIVE::ER_CRC' => 'CRC error',
				    'ZIPARCHIVE::ER_ZIPCLOSED' => 'Containing zip archive was closed',
				    'ZIPARCHIVE::ER_NOENT' => 'No such file.',
				    'ZIPARCHIVE::ER_EXISTS' => 'File already exists',
				    'ZIPARCHIVE::ER_OPEN' => 'Can\'t open file',
				    'ZIPARCHIVE::ER_TMPOPEN' => 'Failure to create temporary file.',
				    'ZIPARCHIVE::ER_ZLIB' => 'Zlib error',
				    'ZIPARCHIVE::ER_MEMORY' => 'Memory allocation failure',
				    'ZIPARCHIVE::ER_CHANGED' => 'Entry has been changed',
				    'ZIPARCHIVE::ER_COMPNOTSUPP' => 'Compression method not supported.',
				    'ZIPARCHIVE::ER_EOF' => 'Premature EOF',
				    'ZIPARCHIVE::ER_INVAL' => 'Invalid argument',
				    'ZIPARCHIVE::ER_NOZIP' => 'Not a zip archive',
				    'ZIPARCHIVE::ER_INTERNAL' => 'Internal error',
				    'ZIPARCHIVE::ER_INCONS' => 'Zip archive inconsistent',
				    'ZIPARCHIVE::ER_REMOVE' => 'Can\'t remove file',
				    'ZIPARCHIVE::ER_DELETED' => 'Entry has been deleted',
				  );
				  $errmsg = 'unknown';
				  foreach ($zipFileFunctionsErrors as $constName => $errorMessage) {
				    if (defined($constName) and constant($constName) === $errno) {
				      return 'Zip File Function error: '.$errorMessage;
				    }
				  }
				  return 'Zip File Function error: unknown';
			}
			return zipFileErrMsg($zip);
		}

	return $tab_liste_fichiers;
}
	
/*

$liste = array();
	
if(!empty($_GET['file']) && isset($_GET['destination']))
{
	
	$liste = unzip($_GET['file'],$_GET['destination']);

	echo 'Le fichier zip contenait '.count($liste).' fichier(s) :<br />';

	foreach ($liste as $nom_fichier)
	{
		echo $nom_fichier.'<br />';
	}
}
else
{
	echo 'pas de "file" ou de "destination"';
}
*/
?>