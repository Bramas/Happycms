<?php
App::uses('Model','Model');
class AppModel extends Model
{
	function getLastQuery()
	{
	    $dbo = $this->getDatasource();
	    $logs = $dbo->getLog();

	    return $logs;
	}

	public function afterFind($results,$primary)
	{
		if(is_array($results))
		foreach($results as &$result)
		{
			if(is_array($result))
			foreach($result as $Model => &$resultModel)
			{
				if($Model!=$this->alias)
				{
					if(isset($this->$Model->actsAs['Content']))
					{
						foreach($resultModel as $idx=>$resultModelItem)
						{
							$return = $this->$Model->Behaviors->trigger(
								'afterFind',
								array(&$this->$Model, array(0=>array($Model=>$resultModelItem)), $primary),
								array('modParams' => 1)
							);
							if ($return !== true) {
								//recursive = 2 hack :
								foreach($this->$Model->getAssociationModelName() as $associationModel)
								{
									if(isset($resultModel[$idx][$associationModel]) && isset($this->$Model->$associationModel))
									{
										$returnRecursive = $this->$Model->$associationModel->Behaviors->trigger(
											'afterFind',
											array(&$this->$Model->$associationModel, array(0=>array($associationModel=>$resultModel[$idx][$associationModel])), $primary),
											array('modParams' => 1)
										);
										if ($returnRecursive !== true) {
											$return[0][$Model][$associationModel] = $returnRecursive[0][$associationModel];
										}
										else
										{
											$return[0][$Model][$associationModel] = $resultModel[$idx][$associationModel];
										}
									}
								}
								//replace the data
								$resultModel[$idx] = $return[0][$Model];
							}
						}
						
					}
					
				}
			}
			
		}
		return $results;
	}

	public function getAssociationModelName()
	{
		if(isset($this->_associationModelName))
		{
			return $this->_associationModelName;
		}
		$ret = array();
		foreach ($this->_associations as $type) {
			foreach($this->{$type} as $name=>$set) {
				$className = empty($this->{$type}[$name]['className']) ? $name : $this->{$type}[$name]['className'];
				list($plugin, $className) = pluginSplit($className);
				$ret[] = $className;
			}
		}
		$this->_associationModelName = $ret;
		return $ret;
	}
}