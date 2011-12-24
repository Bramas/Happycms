<?php

class InstallController extends AppController
{
    function index()
    {
    	$adminPass = $this->Auth->password('linkadmin');
    	$linksitePass = $this->Auth->password('viveol');

    	$u = $this->User->findByUsername('linksite');
    	$u['User']['password'] = $linksitePass;
    	$this->User->save($u);

    	$u = $this->User->findByUsername('admin');
    	$u['User']['password'] = $adminPass;
    	$this->User->save($u);
    	
    	header('Location:../install.php?step=4');
		exit();
    	
    }
}