<?php
//require_once('../libs/extension.php');
require('extensions.php');

$extensions = Configure::read('Extensions');

foreach($extensions as $extensionName => &$extension)
{

    if(empty($extension['optgroup']))
    {
    	$extension['optgroup'] = $extensionName;
    }
    if(empty($extension['views']))
    {
        $extension['views']=array('index'=>$extension['name']);
        
    }
    else{
        
    }

    foreach($extension['views'] as &$view)
    {
    	if(!is_array($view))
    	{
    		$view=array('name'=>$view);
    	}
    	if(empty($view['optgroup']))
	    {
	    	$view['optgroup'] = $extension['optgroup'];
	    }
    }

}
Configure::write('Extensions',$extensions);
//debug($extensions);

Configure::write('Config.multilanguage',false);


Configure::write('Config.languages',array('fre'));
Configure::write('Config.id_languages',array('fre'=>1));
Configure::write('Config.name_languages',array('fre'=>'Français'));

Configure::write('Config.language', 'fre');
Configure::write('Config.id_language', 1);

Configure::write('Model.default_use',array('Menu','Content','Extension'));


Configure::write('Menu',array('id'=>0,'parent_id'=>0));



App::import('Model','Extension');
$ExtensionModel=new Extension();


if(Configure::read('debug')==2 && !empty($debug_extension))
{

	$db_extensions=$ExtensionModel->find('list');
	$db_extensions=array_keys($db_extensions);
	
	$ExtensionModel->load('extensions');

	foreach($extensions as $extensionName => $extension2)
	{
		if(!in_array($extensionName,$db_extensions))
		{
				$ExtensionModel->query('
					INSERT INTO '.$ExtensionModel->tablePrefix.$ExtensionModel->table.
					" (`name`,`controller`)".
					"   VALUES ('".mysql_real_escape_string($extension2['name'])."','".mysql_real_escape_string($extensionName)."')"
				);
				/*$ExtensionModel->save(array('Extension'=>array(
					'name'=>$extension['name'],
					'controller'=>$extensionName,

				),
				'updated' => false));*/
				//debug('save'.$extensionName);
		}
		$temp = $ExtensionModel->findByController($extensionName);
		if(empty($temp['Extension']['item_id']))
		{
			$item_id = $ExtensionModel->getNextId();
			$ExtensionModel->query('
					UPDATE '.$ExtensionModel->tablePrefix.$ExtensionModel->table.
					"  SET item_id=".$item_id."  WHERE controller='".mysql_real_escape_string($extensionName)."'"
				);
			foreach(Configure::read('Config.id_languages') as $lang=>$lang_id)
			{
				$ExtensionModel->Content->create();
				$ExtensionModel->Content->save(array('Content'=>array(
													'item_id'=>$item_id,
													'extension'=>'extensions',
													'params'=>'{}',
													'language_id'=>$lang_id
				)));
			}
		}

	}
}

$conf = $ExtensionModel->find('first',array('conditions'=>array(
                                                                 'controller'=>'configurations',
                                                                 'Content.language_id'=>Configure::read('Config.id_language'))));
        
        
$conf = json_decode($conf['Content']['params'],true);
Configure::write('Config.Content',$conf);


function jour($i){
	$jour = array(
			'Dimanche',
			'Lundi',
			'Mardi',
			'Mercredi',
			'Jeudi',
			'Vendredi',
			'Samedi'
		);
	return $jour[$i];
}
function mois($i)
{
	$mois = array(
			'Janvier',
			'Février',
			'Mars',
			'Avril',
			'Mai',
			'Juin',
			'Juillet',
			'Août',
			'Septembre',
			'Octobre',
			'Novrembre',
			'Décembre'
		);
	return $mois[$i];
}


?>