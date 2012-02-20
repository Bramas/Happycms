<?php

class HomeController extends AppController
{
	var $uses = array('Home');
	function admin_index_edit($id)
	{
		$this->request->data = $this->Home->findById($id);
	}
	function admin_index_new()
	{
		$item_id = $this->createItem();
		return $item_id;
	}
	function index($id)
	{

		$Content = $this->Home->findById($id);

		$this->set($Content);
	}
}