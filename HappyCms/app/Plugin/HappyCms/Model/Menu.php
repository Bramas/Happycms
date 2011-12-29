<?php

class Menu extends HappycmsAppModel
{
    var $name = "Menu";
    var $alias = "Menu";
    var $actsAs = array('Tree','HappyCms.Content'=>array('extensionName'=>'menus'));
    var $belongsTo = array(
      'Extension'=>array(
        'foreignKey'=>'extension',
        'className'=>'Happycms.Extension'
      )
    );
    var $displayField = 'item_id'; 
    var $extension='menus';
    function save( $data = NULL, $validate = true, $fieldList = array ( ) )
    {
        
     /*   if(empty($data['Menu']))
        {
            return parent::save( $data , $validate , $fieldList );
        }
        if(empty($data['Menu']['id']))
        {
            if(empty($data['Menu']['lang_available']))
            {
                $data['Menu']['lang_available']=array();
            }
            $data['Menu']['lang_available'] = json_encode($data['Menu']['lang_available']);
        }
        elseif(!empty($data['Menu']['lang_available']))
        {
            if(!is_array($data['Menu']['lang_available']))
            {
                $data['Menu']['lang_available']=json_decode($data['Menu']['lang_available']);
            }
            $menu = $this->findById($data['Menu']['id']);
            $menu['Menu']['lang_available']=array_merge($menu['Menu']['lang_available'],$data['Menu']['lang_available']);
            $data['Menu']['lang_available'] = json_encode($data['Menu']['lang_available']);
        }
     */
        
      $ret = parent::save( $data , $validate , $fieldList );
        
        
        return $ret ;
        
    }
    function findById($id)
    {
        $menu = parent::findById($id);
        //$menu['Menu']['lang_available']=json_decode($menu['Menu']['lang_available'],true);
        return $menu;
    }
   /*=>array('foreignKey' => 'parent_id',
                                       'order'=>array('ordering'=>'ASC')
                                      ));

   var $belongsTo = array('Menu' => array('className' => 'Menu',
                             'foreignKey'    => 'parent_id')
                          );  
   */
   
   function addLang($id,$lang)
   {
        $this->save(array('Menu'=>array(
            'id'=>$id,
            'lang_available'=>$lang
        )));
   }
}

?>