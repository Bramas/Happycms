<?php

class Content extends AppModel
{
    
    
    var $name = "Content";
    
    var $displayField = 'params';
    var $belongsTo = array(
        'Extension'=>array(
            'className'=>'HappyCms.Extension',
            'foreignKey'=>'extension'),
        'Language'=>array(
            'className'=>'HappyCms.Language',
            )
                           );
    var $hasAndBelongsToMany = array('Category');
    
    function save( $data = NULL, $validate = true, $fieldList = array ( ) )
    {
        if(empty($data['Content']['params']))
        {
            $data['Content']['params'] = '{"empty":true}';
        }
        return parent::save( $data , $validate , $fieldList );
    }
    
    function saveItem( $data = NULL, $validate = true, $fieldList = array ( ) )
    {
        
        if(empty($data['Content']['id']))
        {
            $data['Content']['id']=$this->Extension->getNextId(true);
        }
        if(empty($data['Content']['all']))
        {
            $data['Content']['all']=array();
        }
        $item_id = $data['Content']['id'];
        $extension = $data['Content']['_extension'];
        $ret['Content'] = array();
        foreach(Configure::read('Config.id_languages') as $lang=>$lang_id):
        
            if(empty($data['Content'][$lang]))
            {
                continue;
            }
            $params =  array_merge((array)$data['Content']['all'],(array)$data['Content'][$lang]);
            
            if(isset($params['alias']) && empty($params['alias']) && isset($params['title']) )
            {
                $params['alias']=$params['title'];
            }
            if(isset($params['alias']))
            {
                $params['alias']=Inflector::slug($params['alias'],'-');
            }
            
            
            $params = json_encode($params);
            $data['Content']['params'] = $params;
            //debug($data['Content']['params'])
            
            if(empty($params))
            {
                $params = '{"empty":true}';
            }
            
            $item = parent::find('first',array('conditions'=>array('extension'=>$extension,
                                                                                     'language_id'=>(int)$lang_id,
                                                                                     'Content.item_id'=>(int)$item_id)));
            $id = (empty($item)?null:$item['Content']['id']);
            $tempItem = parent::save( array('Content'=>array(
                                                        'id'=>$id,
                                                        'extension'=>$extension,
                                                        'language_id'=>(int)$lang_id,
                                                        'item_id'=>(int)$item_id,
                                                        'params'=>$params)) , $validate , $fieldList );
            $tempParams = json_decode($tempItem['Content']['params'],true);
            if(!empty($tempItem))
               {
                    $ret['Content']=array_merge($ret['Content'],(array)$tempItem['Content']);
                    $ret['Content']=array_merge($ret['Content'],(array)$tempParams);
               }
            $ret['Content'][$lang]=$tempParams;
            
            $cat = array();
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
            }
            
    endforeach;
        /**
         *
         * set if the menu can appear for this lang
         * */
        if(!empty($data['Menu']) && !empty($data['Menu']['lang_available']))
        {
            if(is_numeric($data['Menu']['lang_available']))
            {
                $menu = $this->Extension->Menu->findById($data['Menu']['lang_available']);
                if(empty($menu['Menu']['lang_available']))
                {
                    $menu['Menu']['lang_available']=array();
                }
                if(empty($menu['Menu']['lang_available']['all']) && empty($menu['Menu']['lang_available'][Configure::read('Config.language')]))
                {
                    
                    $menu['Menu']['lang_available'][Configure::read('Config.language')]=true;
                    
                    $this->Extension->Menu->save($menu);
                }
            }
        }
        
        
        
        
        /*$current = $this->findById($this->id);
        $this->Extension->findById($current['Content']['module_id')*/
        
        return $ret;
        
    }
    
    /**
     * get an item witch belongs to the selected module.
     *
     * @param int $module_id the id of the module
     * @param int $item_id the id of the item
     * @param boolean $assoc if true the result is an associated array
     * @return The item
     * */
    function item($extension,$item_id,$options=true)
    {
        $ret = array();
        if(is_bool($options))
        {
            $assoc=$options;
            $options=array();
        }
        elseif(isset($options['assoc']))
        {
            $assoc=$options['assoc'];
        }else{
            $assoc=true;
        }
        
        if(empty($options['lang']))
        {
            $options['lang']=Configure::read('Config.language');
        }
        if(!is_array($options['lang']))
        {
            $options['lang'] = array($options['lang']);
        }
        $ret['Content-Category']=array();
        foreach(Configure::read('Config.id_languages') as $lang=>$lang_id):
        
        if(!in_array($lang,$options['lang'] ))
        {
            continue;
        }
        
        $item = $this->find('first',array('conditions'=>array('extension'=>$extension,
                                                                                 'language_id'=>(int)$lang_id,
                                                                                 'Content.item_id'=>(int)$item_id)));
       // debug($item);
         if(empty($item))
        {
            continue;
        }
        
        //debug($item);
        if(isset($options['main_lang']) && $options['main_lang']==$lang)
        {
            $ret['Language']=$item['Language'];
        }
        $params = json_decode($item['Content']['params'],$assoc);
        
        if(!$assoc)
        {
            $params->id = $item['Content']['item_id'];
        }
        if(empty($params))
        {
            $ret['Content'][$lang]=array('empty'=>1);
        }
        else{
            $ret['Content'][$lang]=$params;
        }

        if($lang==Configure::read('Config.language'))
        {
            $ret['Content']=array_merge((array)$params,(array)$ret['Content']);
        }
        if(!empty($item['Category']))
        {
            $ret['Content-Category'][$lang]=array();
            foreach($item['Category'] as $cat)
            {
                $ret['Content-Category'][$lang][$cat['id']]=true;
            }
            
        }
        if($assoc)
        {
            if(isset($ret['Content'][$lang]['id']))
            {
                unset($ret['Content'][$lang]['id']);
            }
        }
        $ret['Content']['id'] = $item['Content']['item_id'];
        $ret['Content']['_extension'] = $item['Content']['extension'];
        endforeach;
        
        
        
        return $ret;
                                      
    }
    /**
     * get all items witch belongs to the selected module.
     *
     * @param int $module_id the id of the module
     * @param int $item_id the id of the item
     * @param boolean $assoc if true the result is an associated array
     * @return The items
     * */
    function items($extension,$lang=null,$assoc=true,$options=array())
    {
        $options = array_merge(array('limit'=>'0,1000'),$options);
        $languages = Configure::read('Config.id_languages');
        $languages = array_flip($languages);
        //debug($languages);
        if(empty($lang))
        {
            $lang = Configure::read('Config.id_language');
        }
        if(!is_numeric($lang))
        {
            $lang=Configure::read('Config.id_languages.'.$lang);
        }
        
        $ContentTOtherLanguages[0]=array( 
							'table' => $this->tablePrefix.$this->table, 
							'alias' => 'Content2', 
							'type' => 'left', 
							'conditions'=> array(
							    'Content2.item_id = Content.item_id AND Content2.extension=\''.$extension.'\' '
							) 
						    );
        
        $items = $this->find('all',array(
                                         'fields'=>'`Content`.`id`,
                                                        `Content`.`extension`,
                                                        `Content`.`item_id`,
                                                        `Content`.`language_id`,
                                                        `Content`.`params`,
                                                        `Extension`.`name`,
                                                        `Extension`.`controller`,
                                                        `Extension`.`item_id`,
                                                        `Extension`.`current_id`,
                                                        `Extension`.`category_id`,
                                                        `Language`.`id`,
                                                        `Language`.`name`,
                                                        `Language`.`code`,
                                                        `Content2`.`language_id`
                                                        ',
                                        'limit'=>$options['limit'],
                                         'conditions'=>array('Content.extension'=>$extension,
                                                                                 'Content.language_id'=>(int)$lang),
                                         'joins'=>$ContentTOtherLanguages));

        //debug($lang);
       $already = array();
        //debug($items);
        $categories_id=array();
        $categories_content=array();
        foreach($items as $key=>&$item)
        {
            if(isset($already[$item['Content']['id']]))
            {
                $already[$item['Content']['id']][$languages[$item['Content2']['language_id']]]=true;
                unset($items[$key]);
                continue;
            }
            $params = json_decode($item['Content']['params'],$assoc);
            if(!$assoc)
            {
                $params->id = $item['Content']['id'];
            }
            $params['id'] = $item['Content']['id'];
            $params['item_id'] = $item['Content']['item_id'];
            $item['Content']=$params;
            
            if(!empty($item['Category']))
            {
                foreach($item['Category'] as &$cat)
                {
                    $categories_id[$cat['id']]=$cat['item_id'];
                    if(!isset($categories_content[$cat['item_id']]))
                    {
                        $categories_content[$cat['item_id']]=array();
                    }
                    $categories_content[$cat['item_id']][]=&$cat;
                }
            }
            
            
            $already[$item['Content']['id']]=&$item['Content'];
            $already[$item['Content']['id']][$languages[$item['Content2']['language_id']]]=true;
            unset($item['Content2']);
        }
      //  debug($categories_content);
        if(!empty($categories_id))
        {
            $categories = $this->find('all',array('conditions'=>array('extension'=>'categories',
                                                                                     'language_id'=>(int)$lang,
                                                                                     'Content.item_id'=>array_values($categories_id) )));
            
                        
            foreach($categories as $cat2)
            {
                if(!empty($categories_content[$cat2['Content']['item_id']]))
                {
                    foreach($categories_content[$cat2['Content']['item_id']] as &$c)
                    {
                        $temp=json_decode($cat2['Content']['params'],true);
                        $temp['id']=$c['id'];
                        $temp['parent_id']=$c['parent_id'];
                        $c = $temp;
                       
                    }
                }
            }
        }
        //debug($categories_content);
        //debug($categories);
        return $items;
                                      
    }
    
    /**
     * indicate to the model that we upload a file, if the name of the field already exists, it will be overwrite
     * and the old filename will be return.
     *
     * @param int $id the id of the content
     * @param string $field the name of the field
     * @param string $file the name of the file
     * @return true if ok, the name of the file if 
     * */
    function upload($extension,$lang,$id,$field,$file)
    {
        $ret = true;
        $item = $this->find('first',array('conditions'=>array(
                                                              'Content.item_id'=>intval($id),
                                                              'extension'=>$extension,
                                                              'Language.code'=>$lang)));
        $params = json_decode($item['Content']['params'],true);
        if(!empty($params[$field]))
        {
            $ret = $params[$field];
        }
        $params[$field]=$file;
        $item['Content']['params'] = json_encode($params);
        $this->save($item);
        return $ret;
    }
    
    function filterResults($results)
    {
        foreach($results as &$result)
        {
            foreach($result as $model=>$data)
            {
                if(preg_match('/__/',$model))
                {
                    $models = explode('__',$model);
                    if(!isset($result[$models[0]]))
                    {
                        $result[$models[0]]=array();
                    }
                    $result[$models[0]][$models[1]]=$data;
                }
                if($model=='children')
                {
                    $result['children']=$this->filterResults($result['children']);
                }
            }
        }
        return $results;
    }

}
?>