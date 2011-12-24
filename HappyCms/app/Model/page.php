<?php
class Page extends AppModel
{
	var $useTable = false;
	var $actsAs = array('Happycms.Content'=>array(
			'extensionName'=>'pages'
		));
}