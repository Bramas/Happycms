<?php

class Category extends AppModel
{
    
    var $actsAs = array('Tree');
    var $displayField = 'item_id';
    var $name = "Category";
    
    var $belongsTo = array('Extension'=>array('foreignKey'=>'extension')
                           );
    var $hasAndBelongsToMany = array('Content');
    
    
}

