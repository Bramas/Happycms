<?php

class Home extends AppModel
{
	var $useTable=false;
	var $actsAs = array(
				'HappyCms.Content'=>array(
					'extensionName'=>'home'
					)
				);
}