<?php

class User extends AppModel
{
    var $name = "User";
    var $belongsTo = array(
	    'Group'=>array(
	    	'className'=>'HappyCms.Group'
		    )
	    );
    
}

?>