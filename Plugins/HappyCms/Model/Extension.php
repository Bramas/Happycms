<?php

App::uses('HappyCmsAppModel','HappyCms.Model');

class Extension extends HappyCmsAppModel
{
    var $name = "Extension";
    var $hasMany = array(
      'Menu'=>array(
        'className'=>'HappyCms.Menu',
        'foreignKey'=>'extension'
      )
    );

   var $hasOne = array(
      'Content'=>array(
        'className'=>'HappyCms.Content',
        'foreignKey'=>'',
        'conditions'=>array(
          'Content.extension'=>'extensions',
          'Content.item_id = Extension.item_id'
        )
      )
    );
    
   var $primaryKey = 'controller';
   /* var $hasMany = array('Menu'=>array('foreignKey' => 'parent_id',
                                       'order'=>array('ordering'=>'ASC')
                                      ));
    
   var $belongsTo = array('Menu' => array('className' => 'Menu',
                             'foreignKey'    => 'parent_id')
                          );  
   */
   
   /** name of the extension=name of the controller
     *
     */
   var $HcontrollerName = null;
   
    
    /** current_id of the extension
     *
     */
 //   private $Hcurrent_id=null;
     
     /** params of the extension
     *
     */
    private $Hparams=null;
    
   
   function read($paramsName=null)
    {
        if(empty($paramsName))
        {
            return $this->Hparams;
        }
        if (strpos($paramsName, '.') === false) {
            if(isset($this->Hparams[$paramsName]))
            {
                return $this->Hparams[$paramsName];
            }
            else{
                return null;
            }
        }
        
        $params=$this->Hparams;
        
        $paramsName = explode('.',$paramsName);
        foreach($paramsName as $paramsSubName)
        {
            if(isset($params[$paramsSubName]))
            {
                $params=$params[$paramsSubName];
            }
            else{
                return null;
            }
        }
        return $params;
    }
    
    
    
     function write($paramsName,$value,$save=true)
    {
        if(empty($paramsName))
        {
            if(is_array($value))
            {
                $this->Hparams=$value;
            }
            else{
                trigger_error ( 'params\' root value must be an array', E_USER_WARNING  );
                return false;
            }
        }
        if (strpos($paramsName, '.') === false) {
            //if(isset($this->Hparams[$paramsName]))
            {
                $this->Hparams[$paramsName]=$value;
            }
            //else{
             //   return false;
            //}
        }
        else{
            $idx=0;
            
            ${'temp'.$idx}=&$this->Hparams;
            
            $paramsName = explode('.',$paramsName);
            foreach($paramsName as $paramsSubName)
            {
                
                if(!isset(${'temp'.$idx}[$paramsSubName]))
                {
                    ${'temp'.$idx}[$paramsSubName]=array();
                }
                
                ${'temp'.($idx+1)}=&${'temp'.$idx}[$paramsSubName];
                
                $idx++;
            }
            ${'temp'.$idx} = $value;
            
        }
        if($save)
        {
            return $this->save();
        }
        return true;
    }
    /**
     * return the current_id used for store the item in the content table and save the current_d+1
     *
     * @param boolean $save if set to false the change is not going to be saved
     * @return a valid id
     */
    function getNextId($save=true)
    {
        $current_id=$this->current_id;
        $this->current_id++;
        
        if($save)
        {
            $this->save();
        }
        return $current_id;
    }
    function load($HcontrollerName)
    {
       // if($this->HcontrollerName===null)
        {
            $this->HcontrollerName=$HcontrollerName;
            $dboResult = $this->find('first',array('conditions'=>array('controller'=>$this->HcontrollerName)));
           
            if(empty($dboResult))
            {
                return false;
            }
            
            $this->Hparams=json_decode($dboResult['Content']['params'],true);
            $dboResult=current($dboResult);
            
            $this->current_id=$dboResult['current_id'];
            //$this->id=$dboResult['id']; // there is no more id field
        }
        return true;
        
        
    }
    
    function save()
    {
        //return true;
        if($this->HcontrollerName===null)
        {
            return false;
        }
        parent::save(array(
            'Extension'=>array(
                'controller'=>$this->HcontrollerName,
                'current_id'=>$this->current_id,
                'params'=>json_encode($this->Hparams)
            )
        ));
        
    }
    
   
}

?>