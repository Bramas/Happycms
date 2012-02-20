<?php

class User extends AppModel
{
    var $name = "User";
    var $belongsTo = array(
	    'Group'=>array(
	    	'className'=>'HappyCms.Group'
		    )
	    );
	    
    function __construct($id = false, $table = null, $ds = null) {
	    parent::__construct($id, $table, $ds);
	    $this->virtualFields['real'] = sprintf("IF('default'=%s.username,0,1)", $this->alias);
	}
}

?>