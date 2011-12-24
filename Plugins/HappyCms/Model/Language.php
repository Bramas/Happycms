<?php

class Language extends AppModel
{
    
    var $name = "Language";
    var $hasMany = array(
	    'Content'=>array(
		    'className'=>'HappyCms.Content'
		    )
	    );
}