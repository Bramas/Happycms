<?php
/**
 * LayoutHelper
 * This Helper provides a few functions that can be used to assist the layout.
 * 
 * @author Robert Conner <rtconner>
 */

class HappyHelper extends AppHelper {
	
	var $__blockName = null;
	var $helpers = array('Html');
	var $Form = null;
	/**
	 * Start a block of output to display in layout
	 *
	 * @param  string $name Will be prepended to form {$name}_for_layout variable
	 */
	function item_edit_shared() {
			if(!$this->Form)
			{
				App::import('Helper','Form');
				App::import('Helper','Html');
				$this->Form=new FormHelper();
				$this->Form->Html=new HtmlHelper();
			}
	
		if(!is_null($this->__blockName))
			trigger_error('HappyHelper::item_edit_shared - Blocks cannot overlap');

		$this->__blockName = 'shared_output';
		$view =& ClassRegistry::getObject('view');
		$this->Form->create($view->data['Happy']['model_name'],array('action'=>'shared'));
		
		//$this->Form->langField='all';
		//$view->langField='all';
		
		ob_start();
		return null;
	}
	
	/**
	 * Ends a block of output to display in layout
	 */
	function end() {
		$buffer = @ob_get_contents();
		@ob_end_clean();
		
		$view =& ClassRegistry::getObject('view');
		if(empty($view->data['Happy']['output']))
		{
			$view->data['Happy']['output']=array();
		}
		
		$view->data['Happy']['output'][$this->__blockName]=$buffer;
		
		
		$this->Form->end();
		$this->__blockName = null;
	}
	/**
	*	return the html link to edit the params of the extension
	*
	**/
	function link_params_edit()
	{
		$view =&ClassRegistry::getObject('view');
		
		return $this->Html->link('<span class="happy-params-edit" item_id="'.$view->data['Happy']['Extension']['Extension']['item_id'].'">edit</span>','#',array('escape'=>false));
	}
	

	function link_to_menu($id,$text=null,$options=array())
	{
		//debug($id);
		App::import('Helper','Html');
		App::import('Model','Menu');

		$Html = new HtmlHelper();
		$Menu = new Menu();
		
		$Menu->Behaviors->attach('Content');
		$menu = $Menu->findById((int)$id);
		if(!empty($menu))
		{

			$text=empty($text)?$menu['Content']['title']:$text; 
			$url = array(
										'controller' =>$menu['Extension']['controller'],
										'action'     =>$menu['Menu']['view'] ,
										'slug'       =>$menu['Content']['alias'],
										'default'    =>$menu['Menu']['default'],
										$menu['Menu']['params']
					);
		}
		else
		{
			$url='#';
		}
		return $Html->link($text,$url,$options);
	}

	function menu_options()
	{
		

	}


	
}

?>