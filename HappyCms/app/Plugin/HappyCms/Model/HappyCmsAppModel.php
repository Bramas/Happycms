<?php
App::uses('AppModel','Model');
class HappyCmsAppModel extends AppModel
{
	function getLastQuery()
	{
	    $dbo = $this->getDatasource();
	    $logs = $dbo->getLog();

	    return $logs;
	}

}