<?php
class ContentBehavior extends ModelBehavior {


	var $extensionName = array();
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

		$this->settings[$model->alias]=$config;
		$this->extensionName[$model->alias] = $config['extensionName'];
		$this->customFields[$model->alias] = array();
		$idx = 0;
		foreach($config['customFields'] as $c)
		{
			$idx++;
			$this->customFields[$model->alias][$c]='custom_field_'.$idx;
		}
		$this->customFields[$model->alias]['published']='published';

		if(!$model->useTable)
		{
			$model->useTable = Inflector::tableize('contents');
			$model->setSource($model->useTable);
			//$model->table = 'contents';
			if(!empty($model->belongsTo))
			{
				foreach($model->belongsTo as $ModelName=>$set)
				{
					if(in_array($set['foreignKey'],array_keys($this->customFields[$model->alias])))
					{
						$model->belongsTo[$ModelName]['foreignKey'] = $this->customFields[$model->alias][$set['foreignKey']];
					}
					if(isset($model->$ModelName->hasMany[$model->alias]['foreignKey']))
					{
						$model->$ModelName->hasMany[$model->alias]['foreignKey'] = $model->belongsTo[$ModelName]['foreignKey'];
						$model->$ModelName->hasMany[$model->alias]['conditions'] = array($model->alias.'.extension'=>$this->extensionName[$model->alias]);
					}
				}
			}
			if(!empty($model->hasMany))
			{
				foreach($model->hasMany as $ModelName=>$setMany)
				{
					if(isset($model->$ModelName->belongsTo[$model->alias]))
					{
						$model->$ModelName->belongsTo[$model->alias]['conditions'] = array($model->alias.'.extension'=>$this->extensionName[$model->alias]);
					}
				}
			}
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
		if(isset($model->actsAs['Content']) && (empty($this->extensionName[$model->alias]) || $this->extensionName[$model->alias] != $model->actsAs['Content']['extensionName']))
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
			$this->primaryKey = $model->primaryKey;
			$model->primaryKey = 'item_id';
			$query['conditions'][$model->alias.'.extension'] = $this->extensionName[$model->alias];
			
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
				$this->replaceCustomField($model,$query['conditions'],$key);
			}
			foreach($query['order'] as &$a)
			{
				if(is_array($a))
				{
					foreach($a as $key => $condition){
						$this->replaceCustomField($model,$a,$key);
					}
				}
			}	
			/*foreach($query['limit'] as $key => $condition){
				$this->replaceCustomField($query['limit'],$key);
			}*/
			foreach($query['order'] as $key => $condition){
				$this->replaceCustomField($model,$query['order'],$key);
			}
			return $query;
		}


		if(!empty($query['fields']))
		{
			if(!is_array($query['fields']))
			{
				if(preg_match('/MAX(.*)/i',$query['fields']))
				{
					return $query;
				}
			}
			else
			{
				$temp = array_keys($query['fields']);

				if(preg_match('/MAX(.*)/i',$query['fields'][0]) || preg_match('/MAX(.*)/i',$temp[0]))
				{
					return $query;
				}
			}
			
			$query['fields']=array_merge((array)$query['fields'],array(
									   'Content.id',
									   'Content.created',
									   'Content.item_id',
									   'Content.params',
									   'Content.custom_field_1',
									   'Content.custom_field_2',
									   ));
				
			if(in_array($model->alias.'.'.$model->displayField,$query['fields']))
			{
				unset($query['fields'][array_search($model->alias.'.'.$model->displayField,$query['fields'])]);
			}
			
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
			'type'=>'left outer',
			'conditions'=>array(
				$model->alias.'.id=Content.item_id',
				'Content.language_id'=>Configure::read('Config.id_language'),
				'Content.extension'=>$extension
			)
			
		));
		if(!empty($query['conditions']) && is_array($query['conditions']))
		foreach($query['conditions'] as $key => $condition){
			$this->replaceCustomField($model,$query['conditions'],$key);
		}
		if(!empty($query['order']) && is_array($query['order']))
		foreach($query['order'] as &$a)
		{
			if(is_array($a))
			{
				foreach($a as $key => $condition){
					$this->replaceCustomField($model,$a,$key);
				}
			}
		}
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
	private function replaceCustomField(&$model, &$array, &$key)
	{
		$alias = $model->table=='contents'?$model->alias:'Content';
		if(is_numeric($key))
		{
			if(preg_match('/^([a-zA-Z0-9]+\.)*([a-zA-Z0-9]+)[ =<>]{1}/',$array[$key].' ',$matches))
			{
				if(!empty($this->customFields[$model->alias][$matches['2']]))
				{
					$array[$key] = preg_replace('/^(([a-zA-Z0-9]+\.)*)([a-zA-Z0-9]+)[ =<>]{1}/',$alias.'.'.$this->customFields[$model->alias][$matches['2']],$array[$key].' ');
				}
			}
		}
		else
		{
			//debug($array);
			//debug($key);
			if(preg_match('/^([a-zA-Z0-9]+\.)*([a-zA-Z0-9]+)$/',trim($key),$matches))
			{
				if(!empty($this->customFields[$model->alias][$matches['2']]))
				{
					$field = preg_replace('/^(([a-zA-Z0-9]+\.)*)([a-zA-Z0-9]+)$/',$alias.'.'.$this->customFields[$model->alias][$matches['2']],trim($key));
					$array[$field]=$array[$key];
					unset($array[$key]);
				}
			}
		}
/*

		foreach($this->customFields[$model->alias] as $customField)
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
			$model->primaryKey = $this->primaryKey;
			 	//$dbo = $model->getDatasource();
				//debug( $dbo->getLog(false,false) );
			$alias = $model->alias;
		}
		foreach($results as &$result)
		{
			if(empty($result[$alias]))
			{
				continue;
			}
			if(is_null($result[$alias]['params']))
			{
				if($model->table!='contents')
				{
					unset($result['Content']);
				}
				continue;
			}

			$temp=json_decode($result[$alias]['params'],true);
			if(!empty($result[$alias]['item_id']))
			{
				$temp['id']=$result[$alias]['item_id'];
			}
			$temp['created'] = $result[$alias]['created'];

			// Custom fields  ---

			foreach($this->customFields[$model->alias] as $customField=>$newField)
			{
				if(isset($result[$alias][$customField]))
				{
					$temp[$newField] = $result[$alias][$customField];
				}
				if(!isset($temp[$newField]))
				{
					$temp[$newField] = '';
				}
			}

			if(empty($result[$model->alias]))
			{
				$result[$model->alias]=array();
			}
			if($model->table=='contents')
			{
				$result[$model->alias] = $temp;
			}
			else
			{
				$result[$model->alias] = array_merge($temp,$result[$model->alias]);
			}

			$result[$model->alias][Configure::read('Config.language')]=$temp;

			if($model->findQueryType=='list' && !empty($result['Content']['title']))
			{
				$result[$model->alias]['view']=$result['Content']['title'];
			}
			if($model->table!='contents')
			{
				unset($result['Content']);
			}
		}
		
		/*if(empty($results))
		{

			return $this->findBrut();
		}*/
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
		

		$this->checkIfItsLoaded($model);
		$alias = 'Content';
		if($model->table == 'contents')
		{
			$alias = $model->alias;
			$data = $model->data[$alias];
			$ContentModel = $model;
		}
		else
		{
			$data = $model->data[$model->alias];
        	App::import('Content','Happycms.Model');
        	$ContentModel = new Content();			
		}
           
		if(isset($data['params']) && count($data)==count($data,COUNT_RECURSIVE) && !is_array( $data['params'] ))
		{
			return true;
		}




        //$extension = $data['Content']['_extension'];
        $extension = $this->extensionName[$model->alias];
        $newEntry = false;
		if(empty($data['id']))
        {
        	App::uses('Extension','HappyCms.Model');
        	$Extension = new Extension();
        	$Extension->load($this->extensionName[$model->alias]);
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

			foreach($this->customFields[$model->alias] as $customField=>$newField)
			{
				if(isset($params[$customField]))
				{
					$data[$lang][$newField] = $params[$customField];
				}
			}


            
            $params = json_encode($params);
            $data['params'] = $params;
            
            
            
             if($newEntry)    
             {
             	$finalData = array(
             					'id'=>null,
								'extension'=>$extension,
	                            'language_id'=>(int)$lang_id,
	                           	'item_id'=>(int)$item_id,
	                           	'params'=>$params,
	                           	'created'=>null
                                            );
                foreach($this->customFields[$model->alias] as $customField=>$newField)
                {
                	if(isset($data[$lang][$newField]))
                	{
	                	$finalData[$newField] = $data[$lang][$newField];
	                }
                }   
             	$ContentModel->create();
             	$ContentModel->save(array($alias => $finalData));                             
            		
            
             }  
             else
             {
            	App::uses('Sanitize', 'Utility');
             	$finalData = array(
						$alias.'.params'=>'"'.Sanitize::escape($params).'"'
					);
                foreach($this->customFields[$model->alias] as $customField=>$newField)
                {
                	if(isset($data[$lang][$newField]))
                	{
                		$finalData[$alias.'.'.$newField] = '"'.Sanitize::escape($data[$lang][$newField]).'"';
                	}
                }   
             	$tempItem = $ContentModel->updateAll(  
             		$finalData
	             	,
					array(
						$alias.'.extension'=>$extension,
                        $alias.'.language_id'=>(int)$lang_id,
                        $alias.'.item_id'=>(int)$item_id
                    )
                  );

				//exit(debug($finalData));
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

        if($model->table!='contents')
		{
			return true;
		}

		return false;
	}
	function afterSave(&$model, $created)
	{
		if($model->table!='contents' && $created)
		{
			App::import('Content','Happycms.Model');
        	$ContentModel = new Content();
        	foreach(Configure::read('Config.id_languages') as $lang_id)
        	{
        		$ContentModel->create();
	        	$ContentModel->save(array('Content' => array(
        			'item_id'=>$model->getLastInsertID(),
        			'extension'=>$this->extensionName[$model->alias],
        			'language_id'=>$lang_id
	        	)));
	        }
		}
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
		{
			$model->deleteAll(array($model->alias.'.item_id'=>$model->id,
						$model->alias.'.extension'=>$this->extensionName[$model->alias]
					));
			return false;
		}	

		return true;
		//}
	}

}