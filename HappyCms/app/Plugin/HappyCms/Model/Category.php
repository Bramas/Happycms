<?php

class Category extends AppModel
{
    
    var $actsAs = array('Tree');
    var $displayField = 'item_id';
    var $name = "Category";
    
    var $belongsTo = array(
	    'Extension'=>array(
	    	'className'=>'HappyCms.Extension',
		    'foreignKey'=>'extension'
		    )
                           );
    var $hasAndBelongsToMany = array(
	    'Content'=>array(
	    	'className'=>'HappyCms.Content'
	    	)
	    );
    
    
}

