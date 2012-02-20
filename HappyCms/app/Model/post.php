<?php



class Post extends AppModel

{
	
	var $useTable = false;

	//var $useTable="contents";

	var $actsAs = array('Content'=>array(

			'extensionName'=>'posts'

		));





}