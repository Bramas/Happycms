<?php
class ExtensionsController extends AppController
{
    
    var $Hforce_all_languages=true;
    function admin_item_edit($item_id)
    {
        Configure::write('debug', 2);
        $ext = $this->Extension->find('first',array('conditions'=>array('Extension.item_id'=>$item_id)));
	

  //  $db =& ConnectionManager::getDataSource($this->Extension->useDbConfig);
//debug($db->_queriesLog);
       $out=$this->requestAction('/admin/contents/load_form/'.$ext['Extension']['controller'].'/params_edit/',
				 array('named'=>array(
                            'lang_form'=>$this->_requestedLanguage,
                            'first_call'=>false,
							'data'=>$this->data,
                            'model_name'=>$this->Hmodel_name)));
                $this->set('controllerOut',$out);
    }
    
     function admin_save()
    {
	
        $content = parent::admin_save();
        //debug($content);
        /*
        $this->data['Category']['item_id']= $content['Content']['item_id'];
        
        if(empty($this->data['Content']['id']))
        {
            $r = $this->Category->save(array('Category'=>$this->data['Category']
                    ));
            $id=$this->Category->id;
        }
        else{
            $r = $this->Category->find('first',array('conditions'=>array('Content.item_id'=>$this->data['Content']['id'])
                    ));
            $id=$r['Category']['id'];
        }
        */
        $ret = '';
        foreach(Configure::read('Config.id_languages') as $lang=>$lang_id)
        {
            if(!empty($content['Content'][$lang]))
            {
                
                $ret.='"'.$lang.'":'.json_encode($content['Content'][$lang]).',';
            }
        }
        
            $ret.='"item_id":'.$content['Content']['item_id'];
    
    
       if(!empty($this->data['ajax']))
       {
	    echo '{"data":{'.$ret.'}}';
	    exit();
       }
       else
       {
	    $this->redirect($_SERVER['HTTP_REFERER']);
	    exit();
       }
    }
    
}