<?php

class CategoriesController extends AppController
{
    var $uses =  array('Category');
    
    var $Hforce_all_languages=true;
    
    function admin_item_edit($item_id)
    {
        $extension=empty($_GET['extension'])?'':$_GET['extension'];
        $this->set('CategoryExtension',$extension);
        /*$this->data=$this->Category->find('first',array(
            'conditions'=>array(
                'item_id'=>$item_id
            )
        ));*/
        $this->set('options',$this->admin_generate_list($extension));
    }
    
    function admin_threaded($extension,$lang)
    {
        
        $threaded = $this->Category->find('threaded',array(
            'fields'=>array(
                'Category.id',
                'Category.item_id',
                'Category.parent_id',
                'Content.params',
                
            ),
            'conditions'=>array(
                'Category.extension'=>$extension
            ),
             'joins'=>array(
                    array( 
                        'table' => $this->Content->tablePrefix.$this->Content->table, 
                        'alias' => 'Content', 
                        'type' => 'left', 
                        'foreignKey' => false, 
                        'conditions'=> array('Content.item_id = Category.item_id AND Content.extension=\'categories\' AND Content.language_id='.Configure::read('Config.id_languages.'.$lang)) 
                    )
                )
        ));
        //debug($threaded);
        if(empty($threaded))
        {
            $this->Category->save(array('Category'=>array(
                'parent_id'=>null,
                'extension'=>$extension
            )));
            $threaded = $this->Category->find('threaded',array(
                'conditions'=>array(
                    'extension'=>$extension,
                    'parent_id IS NULL'
                )
            ));
        }
        return $threaded;
    }
    
    function admin_generate_list($extension)
    {
        $list = $this->Category->generatetreelist (array(
                    'extension'=>$extension
                ), null, null,  '_', null);
        
       $keys=array();
       foreach($list as $key=>&$l)
        {
            preg_match('/(_*)([^_]{1}.*)/',$l,$matches);
            if(empty($matches[1]) || empty($matches[2]))
            {
                continue;
            }
            $keys[]=$matches[2];
            $l = array('prefix'=>$matches[1],
                       'id'=>$matches[2]
                      );
        }
        //debug($list);
       $content = $this->Content->find('list',array('conditions'=>array(
            'Content.extension'=>'categories',
            'Content.item_id' => $keys,
            'Content.language_id'=>Configure::read('Config.id_language')
        ),'fields' => array('Content.item_id', 'Content.params')
            ));
       
        foreach($list as $key=>&$l)
        {
            if(empty($l))
            {
                $list[$key]="Catégorie racine";
            }
            elseif(!empty($content[$l['id']]))
            {
                $temp = json_decode($content[$l['id']],true);
                
                $l = $l['prefix'].$temp['title'];
            }
            else{
                unset($list[$key]);
            }
            
            
        }
        
       // debug($list);
        
        return $list;
    }
    function admin_to_trash($item_id,$extension)
    {
        $this->Content->deleteAll(array('Content.item_id'=>$item_id,
					'Content.extension'=>'categories'
					));
       
        $cat = $this->Category->find('first',array(
                                                   'conditions'=>array('Category.item_id'=>$item_id,
                                                                                'extension'=>$extension)
					));
        if(!empty($cat['Category']['id']))
            $this->Category->removeFromTree($cat['Category']['id'],true);
        
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    function admin_save()
    {
        $content = parent::admin_save();
        
        $this->data['Category']['item_id']= $content['Content']['item_id'];
        
        if(empty($this->data['Content']['id']))
        {
            $r = $this->Category->save(array('Category'=>$this->data['Category']
                    ));
            $id=$this->Category->id;
        }
        else{
            $r = $this->Category->find('first',array('conditions'=>array('Category.item_id'=>$this->data['Content']['id'])
                    ));
            $id=$r['Category']['id'];
        }
        $ret = '';
        foreach($this->data['Content'] as $lang=>$data)
        {
            if(in_array($lang,Configure::read('Config.languages')))
            {
                $ret.='"'.$lang.'":{"title":"'.$data['title'].'"},';
            }
        }
        
            $ret.='"id":'.$id;
            $ret.=',"item_id":'.$content['Content']['item_id'];
            $ret.=',"parent_id":'.$this->data['Category']['parent_id'];
        echo '{"newCat":{'.$ret.'}}';
        exit();
    }
    function getList($extension)
    {
        $extension = $this->Category->find('threaded',array(
                                                            'fields'=>array('
                                                                            Content.params,
                                                                            `Category`.`id`,
                                                                            `Category`.`extension`,
                                                                            `Category`.`lft`,
                                                                            `Category`.`rght`,
                                                                            `Category`.`parent_id`,
                                                                            `Category`.`item_id`,
                                                                            `Extension`.`name`,
                                                                            `Extension`.`controller`,
                                                                            `Extension`.`item_id`,
                                                                            `Extension`.`current_id`,
                                                                            `Extension`.`category_id`'),
                                                            'conditions'=>array('Category.extension'=>$extension),
                                                            'recursive' => 0,
                                                            'joins'=>array(array(
                                                                'table'=>$this->Content->tablePrefix.$this->Content->table,
                                                                'alias'=>'Content',
                                                                'type'=>'LEFT',
                                                                'conditions'=>array(
                                                                    'Content.extension'=>'categories',
                                                                    'Category.item_id=Content.item_id',
                                                                    'Content.language_id'=>Configure::read('Config.id_language')
                                                                )
                                                            ))
                                                            ));
        return $extension;
    }
    
}