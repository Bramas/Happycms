<?php

class InstallController extends AppController
{
    function index()
    {
    	$adminPass = $this->Auth->password('admin');
    	$superadminPass = $this->Auth->password('superadmin');

    	$u = $this->User->findByUsername('superadmin');
    	$u['User']['password'] = $superadminPass;
    	$this->User->save($u);

    	$u = $this->User->findByUsername('admin');
    	$u['User']['password'] = $adminPass;
    	$this->User->save($u);
    	
    	header('Location:../install.php?step=4');
		exit();
    	
    }
}