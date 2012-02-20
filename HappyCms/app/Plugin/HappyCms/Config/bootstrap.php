<?php


require_once ROOT.DS.APP_DIR.'/Plugin/HappyCms/Config/extensions.php';



$extensions = Configure::read('Extensions');

foreach($extensions as $extensionName => &$extension)
{

    if(empty($extension['optgroup']))
    {
    	$extension['optgroup'] = $extensionName;
    }
    if(empty($extension['views']))
    {
        $extension['views']=array();
        
    }

    foreach($extension['views'] as &$view)
    {
    	if(!is_array($view))
    	{
    		$view=array('name'=>$view);
    	}
    	if(empty($view['mainIcon']))
	    {
	    	$view['mainIcon'] = '/media/default/extensionIcon.png';
	    }
    	if(!isset($view['enabled']))
	    {
	    	$view['enabled'] = true;
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



App::uses('Extension','HappyCms.Model');
$ExtensionModel = new Extension();


if(Configure::read('debug')==2 && !empty($refresh_extension))
{

	$db_extensions=$ExtensionModel->find('list');
	$db_extensions=array_keys($db_extensions);
	
	
	$ExtensionModel->load('extensions');
	App::uses('Sanitize', 'Utility');
	foreach($extensions as $extensionName => $extension2)
	{
		if(!in_array($extensionName,$db_extensions))
		{
			try{
				$ExtensionModel->query('
					INSERT INTO '.$ExtensionModel->tablePrefix.$ExtensionModel->table.
					" (`name`,`controller`)".
					"   VALUES ('".Sanitize::escape($extension2['name'])."','".Sanitize::escape($extensionName)."')"
				);
			}
			catch(Exception $e)
			{
				
			}
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
			try{
				$item_id = $ExtensionModel->getNextId();
				$ExtensionModel->query('
						UPDATE '.$ExtensionModel->tablePrefix.$ExtensionModel->table.
						"  SET item_id=".$item_id."  WHERE controller='".Sanitize::escape($extensionName)."'"
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
			catch(Exception $e)
			{
				
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


function formatDate($str)
{
	$time = strtotime($str);

	return date('d/m/Y',$time);

	//return preg_replace('/([0-9]{4})-([0-9]{2})-([0-9]{2})/', '$3/$2/$1', $str);
}
function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment

    $tokens = array (
        31536000 => 'an',
        2592000 => 'mois',
        604800 => 'semaine',
        86400 => 'jour',
        3600 => 'heure',
        60 => 'minute',
        1 => 'seconde'
    );
    App::uses('Inflector','Utility');
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.($numberOfUnits>1?Inflector::pluralize($text):$text);
    }

}
function introText($text,$length)
{
	$text = strip_tags(substr($text, 0, $length+100));
	$intro = substr($text,0,$length);
    $k=0;
     while(substr($text,$length+$k,1)!=' ')
     {
        $intro.=substr($text,$length+$k,1);
        $k++;
        if($k>20) break;
     }
     return $intro; 
}


Configure::write('HappyCms.ControllersNeedRoutes',
array('menus','contents','categories','users','files','extensions','configurations','links','submenus','minisql'));



function requestAllowed($object, $property, $online, $rules, $default = false)
{
    // The default value to return if no rule matching $object/$property can be found
    
    $rules = array($rules['Group.rules'],$rules['rules']);

    $allowed = $default;

    foreach($rules as $rule)
    {
	    // This Regex converts a string of rules like "objectA:actionA,objectB:actionB,..." into the array $matches.
	    preg_match_all('/([^:,]+):([^,:]+)/is', $rule, $matches, PREG_SET_ORDER);
	    foreach ($matches as $match)
	    {
	        list($rawMatch, $allowedObject, $allowedProperty) = $match;
	       
	        $allowedObject = str_replace('*', '.*', $allowedObject);
	        $allowedProperty = str_replace('*', '.*', $allowedProperty);
	       
	       	if (substr($allowedObject, 0, 8)=='Offline|' && !$online)
	        {
	            $allowedObject = substr($allowedObject, 8);
	        }
	        elseif(substr($allowedObject, 0, 8)=='Offline|')
	        {
	        	continue;
	        }

	        if (substr($allowedObject, 0, 1)=='!')
	        {
	            $allowedObject = substr($allowedObject, 1);
	            $negativeCondition = true;
	        }
	        else
	        {
	        	$negativeCondition = false;
	        }
	            
	       
	        if (preg_match('/^'.$allowedObject.'$/i', $object) &&
	            preg_match('/^'.$allowedProperty.'$/i', $property))
	        {
	            if ($negativeCondition)
	                $allowed = false;
	            else
	                $allowed = true;
	        }
	    }        
	}
    return $allowed;
}

?>