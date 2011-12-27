<?php
class ContentBehavior extends ModelBehavior {


	var $extensionName = null;
	var $customFields = array();

/**
 * Setup le behavior
 *
 * @param mixed $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {

		$config = array_merge(array(
			'extensionName'=>'',
			'customFields'=>array()
			),$config);

		$this->settings=$config;
		$this->extensionName = $config['extensionName'];
		$this->customFields = $config['customFields'];

		if(!$model->useTable)
		{
			$model->useTable = Inflector::tableize('contents');
			$model->setSource($model->useTable);
			//$model->table = 'contents';
		}

	}
/**
* Vérifie si le behavior est correctement chargé et sinon le recharge avec les config d'origine
* @return $query modifiée
* @access public
* @param array $query brut
*
*/
	function checkIfItsLoaded(&$model)
	{

		if(empty($this->extensionName) && isset($model->actsAs['Content']))
		{
			$this->setup($model, $model->actsAs['Content']);
		}
	}
/**
* 2 cas :
* - Si tout est contenu dans la table contents : id devient item_id et on remplace certainnes conditions.
* - Si la table est liée à la table contents par item_id : on join la table contents 
* @return $query modifiée
* @access public
* @param array $query brut
*
*/
	function beforeFind(&$model, $query)
	{
		
		$this->checkIfItsLoaded($model);

		App::import('Model','Content');
		$Content = new Content();

		if($model->table == 'contents')//!$model->useTable)
		{

			$query['conditions']['extension'] = $this->extensionName;
			
			if(isset($query['conditions']['id']))
			{
				$query['conditions'][$model->alias.'.item_id'] = $query['conditions']['id'];
				unset($query['conditions']['id']);
			}
			if(isset($query['conditions'][$model->alias.'.id']))
			{
				$query['conditions'][$model->alias.'.item_id'] = $query['conditions'][$model->alias.'.id'];
				unset($query['conditions'][$model->alias.'.id']);
			}
			foreach($query['conditions'] as $key => $condition){
				$this->replaceCustomField($query['conditions'],$key);
			}
			foreach($query['order'] as &$a)
			{
				if(is_array($a))
				{
					foreach($a as $key => $condition){
						$this->replaceCustomField($a,$key);
					}
				}
			}	
			/*foreach($query['limit'] as $key => $condition){
				$this->replaceCustomField($query['limit'],$key);
			}*/

			return $query;
		}


		if(!empty($query['fields']))
		{
			$query['fields']=array_merge((array)$query['fields'],array(
									   'Content.id',
									   'Content.created',
									   'Content.params',
									   'Content.custom_field_1',
									   'Content.custom_field_2',
									   ));
		}
		else{
			$query['fields']='*';
		}
		if(!empty($model->extension))
		{
			$extension = $model->extension;
		}
		else{
			$extension = $model->table;
		}
		$query['joins']=array(array(
			
			'table'=>$Content->tablePrefix.$Content->table,
			'alias'=>'Content',
			'conditions'=>array(
				$model->alias.'.item_id=Content.item_id',
				'Content.language_id'=>Configure::read('Config.id_language'),
				'Content.extension'=>$extension
			)
			
		));
		return $query;
	}
/**
* Cherche dans le clef du tableau ou dans la valeur correspondant si un custom field est présent et si oui le remplace
*
* @access private
* @param array $array
* @param mixed $key
*
*/
	private function replaceCustomField(&$array, &$key)
	{
		if(is_numeric($key))
		{
			if(preg_match('/^([a-zA-Z0-9]+\.)*([a-zA-Z0-9]+)[ =<>]{1}/',$array[$key].' ',$matches))
			{
				if(in_array($matches['2'],$this->customFields))
				{
					$idx = array_search($matches['2'],$this->customFields);
					$array[$key] = preg_replace('/^(([a-zA-Z0-9]+\.)*)([a-zA-Z0-9]+)[ =<>]{1}/','$1custom_field_'.($idx+1),$array[$key].' ');
				}
			}
		}
		else
		{
			if(preg_match('/^([a-zA-Z0-9]+\.)*([a-zA-Z0-9]+)$/',trim($key),$matches))
			{
				if(in_array($matches['2'],$this->customFields))
				{
					$idx = array_search($matches['2'],$this->customFields);
					$field = preg_replace('/^(([a-zA-Z0-9]+\.)*)([a-zA-Z0-9]+)$/','$1custom_field_'.($idx+1),trim($key));
					$array[$field]=$array[$key];
					unset($array[$key]);
				}
			}
		}
/*

		foreach($this->customFields as $customField)
		{
			if(in_array($customField,array_keys($query['conditions'])))
			{
				$query['conditions']['custom_field_'.$idx] = $query['conditions'][$customField];
				unset($query['conditions'][$customField]);
			}

			$idx++;
		}*/
	}

/**
* Remplace les donnée brut de la base contents (en Json) en array associatif. Cette fonction prend en charge le multilingue, c'est à dire que si les données contiennent plusieurs langues, toute les langues vont intégrées au résultat.
*
* @return $results traité
* @access public
* @param array $results contenant les resultats bruts
*
*/
	function afterFind(&$model, $results, $primary)
	{
			
		$this->checkIfItsLoaded($model);

		$alias = 'Content';
		if($model->table == 'contents')
		{
			 	//$dbo = $model->getDatasource();
				//debug( $dbo->getLog(false,false) );
			$alias = $model->alias;
		}
		
		foreach($results as &$result)
		{
			$temp=json_decode($result[$alias]['params'],true);
			if(!empty($result[$alias]['item_id']))
			{
				$temp['id']=$result[$alias]['item_id'];
			}
			$temp['created'] = $result[$alias]['created'];

			// Custom fields  ---

			$idx=1;
			foreach($this->customFields as $customField)
			{
				if(!empty($result[$alias]['custom_field_'.$idx]))
				{
					$temp[$customField] = $result[$alias]['custom_field_'.$idx];
				}
				if(empty($temp[$customField]))
				{
					$temp[$customField] = '';
				}
				$idx++;
			}


			$result[$alias]=$temp;
			$result[$alias][Configure::read('Config.language')]=$temp;

			if($model->findQueryType=='list' && !empty($result['Content']['title']))
			{
				$result['Menu']['item_id']=$result['Content']['title'];
			}
		}
		
		return $results;
	}

/**
* Sauvegarde un élément et retourne false. Cette fonction prend en charge le multilingue, c'est à dire que si les données contiennent plusieurs langues, toute les langues vont être sauvegardées.
*
* @return false si les données sont brut, true si les données ont été traiter par beforeSave()
* @access public
*
*
*/
	function beforeSave(&$model)
	{
		$alias = 'Content';
		if($model->table == 'contents')
		{
			$alias = $model->alias;
		}
		else
		{
			if(empty($model->data[$alias]))
			{
				//debug($model->data);
				//return true to do the basic save method
				return true;
			}
		}
		$data = $model->data[$alias];
		
		if(isset($data['params']) && !is_array( $data['params'] ))
		{
			return true;
		}
		


		$this->checkIfItsLoaded($model);


        //$extension = $data['Content']['_extension'];
        $extension = $this->extensionName;

        $newEntry = false;
		if(empty($data['id']))
        {
        	App::import('Model','Extension');
        	$Extension = new Extension();
        	$Extension->load($this->extensionName);
            $data['id']=$Extension->getNextId(true);
            $newEntry = true;
        }
        if(empty($data['all']))
        {
            $data['all']=array();
        }

        $item_id = $data['id'];
 

        foreach(Configure::read('Config.id_languages') as $lang=>$lang_id):
        
            if(empty($data[$lang]))
            {
                continue;
            }
            $params =  array_merge((array)$data['all'],(array)$data[$lang]);
            
            if(isset($params['alias']) && empty($params['alias']) && isset($params['title']) )
            {
                $params['alias']=$params['title'];
            }
            if(isset($params['alias']))
            {
                $params['alias']=Inflector::slug($params['alias'],'-');
            }
            
            //save custom field separatly
            $idx=1;
            $data['custom_field_1']='';
            $data['custom_field_2']='';

			foreach($this->customFields as $customField)
			{
				if(!empty($params[$customField]))
				{
					$data['custom_field_'.$idx] = $params[$customField];
				}
				$idx++;
			}


            
            $params = json_encode($params);
            $data['params'] = $params;
            
            if(empty($params))
            {
                $params = '{"empty":true}';
            }
            
            
             if($newEntry)    
             {
             	$model->create();
             	$model->save(array($alias => array(
             					'id'=>null,
								'extension'=>$extension,
	                            'language_id'=>(int)$lang_id,
	                           	'item_id'=>(int)$item_id,
	                           	'params'=>$params,
                        		'custom_field_1'=>$data['custom_field_1'],
                        		'custom_field_2'=>$data['custom_field_2']
                                            )));                             
            		
            
             }  
             else
             {
             	$tempItem = $model->updateAll(  
	             	array(
						$alias.'.params'=>'"'.mysql_real_escape_string($params).'"',
                        $alias.'.custom_field_1'=>'"'.mysql_real_escape_string($data['custom_field_1']).'"',
                        $alias.'.custom_field_2'=>'"'.mysql_real_escape_string($data['custom_field_2']).'"'
					),
					array(
						$alias.'.extension'=>$extension,
                        $alias.'.language_id'=>(int)$lang_id,
                        $alias.'.item_id'=>(int)$item_id
                    )
                  );
             }

            /*$tempParams = json_decode($tempItem[$alias]['params'],true);
            if(!empty($tempItem))
               {
                    $ret['Content']=array_merge($ret['Content'],(array)$tempItem['Content']);
                    $ret['Content']=array_merge($ret['Content'],(array)$tempParams);
               }
            $ret['Content'][$lang]=$tempParams;
            */

            /*$cat = array();
            $id=$this->id;
            if(!empty($data['Category'][$lang]))
            {
                $this->query('DELETE FROM '.$this->tablePrefix.'categories_contents  WHERE content_id = '.$id);
                foreach($data['Category'][$lang] as $cat_id=>$ok)
                {
                    if($ok)
                    {
                       $this->query('INSERT INTO '.$this->tablePrefix.'categories_contents (content_id, category_id) VALUE(
                            '.$id.',
                            '.$cat_id.'
                        )');
                    }
                }
            }*/
            
    endforeach;
        

		return false;
	}


	function beforeDelete(&$model, $cascade = true)
	{
		//$count = $model->find("count", array(
		//"conditions" => array("product_category_id" => $this->id)
		//));
		//if ($count == 0) {
		//	return true;
		//} else {
		if($model->table == 'contents')
			return false;

		return true;
		//}
	}

}