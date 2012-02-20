<?php
class HappyShell extends AppShell {
    public function main() {
    	$extensionName =  null;
    	$useTable = 'content';
    	$customField1 = $customField2 = $customField3 = null;
    	$customField = 'N';
    	do{
	    	$extensionName = $this->in('Name Of the Extension?',null,$extensionName);
	    	$controllerName = ucfirst($extensionName).'Controller';
	    	$controllerName = $this->in('Name Of the Controller?',null ,$controllerName);

	    	App::uses('Inflector','Utility');
	    	$modelName = ucfirst(Inflector::singularize($extensionName));
	    	$modelName = $this->in('Name Of the Model?',null ,$modelName);
	    	$useTable = $this->in('The model use his own table or the Content table?',array('custom','auto','content'),$useTable);
	    	
	    	$customField = $this->in('Any Custom Field?',array('O','N'),$customField);
	    	$customField = preg_match('/o/i', $customField )?true:false;

	    	if($customField)
	    	{
	    		for($i=1;$i<=3;$i++)
	    		{
	    			${'customField'.$i} = $this->in('Custom Field '.$i.' ?',null,${'customField'.$i});
	    		}
	    	}



	    	$this->out('');
	    	$this->out('Extension : '.$extensionName);
	    	$this->out('Controller : '.$controllerName);
	    	$this->out('Model : '.$modelName);
	    	$this->out('CustomField : '.($customField?'Oui':'Non'));
	    	if($customField)
	    		for($i=1;$i<=3;$i++)
	    			!empty(${'customField'.$i})?$this->out('Custom Field '.$i.' : '.${'customField'.$i}):'';

	    	$this->out('table : '.$useTable,2);
	    	$Ok = $this->in('Ok?',array('O','N') ,'O');
	    	$Ok = preg_match('/n/i', $Ok )?false:true;
	    }while(!$Ok);

	    $useTable = preg_match('/auto/i', $useTable)?'null':'\''.$useTable.'\'';
	    $useTable = preg_match('/content/i', $useTable)?'false':$useTable;

	    $root = $this->in('Root Path?',null,ROOT);

	    $this->hr(1);
	    $this->createFile($root.DS.'app'.DS.'Controller'.DS.$controllerName.'.php', '<?php

class '.$controllerName.' extends AppController
{
    var $uses = array(\''.$modelName.'\');
    var $Hmodel_name = \''.$modelName.'\';

    function admin_item_edit($id)
    {
		$this->request->data = $this->'.$modelName.'->findById($id);
    }
    
    function admin_menu_index()
    {
        $this->request->data = $this->'.$modelName.'->find(\'all\',array(\'order\'=>\''.$modelName.'.created desc\'));
    }
    function admin_save()
    {
        parent::admin_save_();
        $this->Session->setFlash("Données sauvegardées",\'flash_success\');
        if(empty($this->request->data[\'_redirect\']) || $this->request->data[\'_redirect\']==\'default\')
        {
            $this->redirect($_SERVER[\'HTTP_REFERER\']);
        }
        else
        {
            $this->redirect(\'/admin/'.$extensionName.'/menu_index/\');
        }
        exit();
    }

    function getList($start=0,$limit=2)
    {
        $'.$modelName.' = $this->'.$modelName.'->find(\'all\',array(\'order\'=>\''.$modelName.'.created desc\',\'limit\'=>$start.\',\'.$limit));
        return $'.$modelName.';
    }
    
    function index()
    {
        $this->set(\''.$modelName.'\',$this->getList(0,10));
    }

    function searchResult($result)
    {
        if(empty($result[\'published\']))
        {
            return false;
        }
        App::uses(\'Inflector\',\'Utility\');

        return array(
            \'url\'=>array(
                \'controller\'=>\''.$extensionName.'\',
                \'action\'=>\'view\',
                $result[\'id\'].\'-\'.Inflector::slug($result[\'id\'],\'-\')
                ),
            \'title\'=>$result[\'title\'],
            \'content\'=>$result[\'text\']
            );
    }
    public function rss()
    {
        $this->layout = \'empty\';
        $this->set(\''.$modelName.'\',$this->getList(0,10));
    }
   
    function view($slug)
    {
        if(is_numeric($slug))
        {
            $id = $slug;
        }
        elseif(strpos($slug,\'-\')!==false)
        {
            list($id,$slug) = explode(\'-\',$slug);
        }
        else
        {
            exit(\'Contactez l\\\'administrateur\');
        }
        $'.$modelName.' = $this->'.$modelName.'->findById($id);
        if(empty($'.$modelName.'))
        {
            throw new NotFoundException();
        }
        $this->set($'.$modelName.');
        $this->set(\'currentItemId\',$'.$modelName.'[\''.$modelName.'\'][\'id\']);
    }
}

?>');
if($customField && !empty($customField1))
{
	$customField='\''.$customField1.'\''.',';
	if(!empty($customField2)) $customField.='\''.$customField2.'\''.',';
	if(!empty($customField3)) $customField.='\''.$customField3.'\''.',';
	$customField=substr($customField, 0,-1);
}
else
{
	$customField='';
}
$this->createFile($root.DS.'app'.DS.'Model'.DS.$modelName.'.php', '<?php


class '.$modelName.' extends AppModel
{
	var $useTable = '.$useTable.';

	var $actsAs = array(\'Content\'=>array(
			\'extensionName\'=>\''.$extensionName.'\',
			\'customFields\'=>array(
					'.$customField.'
				)
		));
}
?>');

mkdir($root.DS.'app'.DS.'View'.DS.ucfirst($extensionName));
$this->createFile($root.DS.'app'.DS.'View'.DS.ucfirst($extensionName).DS.'admin_menu_index.ctp', '<?php


echo $this->Html->link(\'Ajouter : '.$modelName.'\',array(\'controller\'=>\'contents\',\'action\'=>\'item_edit\',$ExtensionName));

echo $this->element(\'happy/admin_table\',array(
										\'alias\'=>\''.$modelName.'\',
                                        \'columns\'=>array(
                                            \'title\'=>\'Titre\'
                                        )));
');

$this->createFile($root.DS.'app'.DS.'View'.DS.ucfirst($extensionName).DS.'admin_item_edit.ctp', '<?php

echo $this->element(\'admin_create_form_item\',array(\'file\'=>true,\'model\'=>\''.$modelName.'\'));


echo $this->Form->input(\'title\',array(\'label\'=>\'Nom :\',\'type\'=>\'text\'));

/* Add File? */
// echo $this->element(\'happy/fields/file\',array(\'label\'=>\'Image :\',\'name\'=>\'img\'));


echo $this->element(\'admin_end_form_item\');
');

$this->createFile($root.DS.'app'.DS.'View'.DS.ucfirst($extensionName).DS.'index.ctp', '
<div id="'.$modelName.'" class="row" >
    <div class="span15 offset1">
<?php
    App::uses(\'Inflector\', \'Utility\');
	echo \'<div class="items">\';
	foreach($'.$modelName.' as $item)
	{
		echo \'<div class="item">\';
			echo \'<h3>\'.$item[\''.$modelName.'\'][\'title\'].\'</h3>\';
		echo \'</div>\';
		echo \'<div class="clear"></div>\';
	}
	echo \'</div>\';

?>
</div>
</div>
');

$this->createFile($root.DS.'app'.DS.'View'.DS.ucfirst($extensionName).DS.'rss.ctp', '<?php echo \'<?xml version="1.0" encoding="utf-8"?>\'; ?>
<rss version="2.0">
    <channel>
   
        <title><?php echo Configure::read(\'Config.Content.title\'); ?></title>
        <link><?php echo $this->Html->url(\'/\',true); ?></link>
        <description><?php echo Configure::read(\'Config.Content.meta-tag\'); ?></description>
       <?php
        $lengthIntro = 100;
       App::uses(\'Inflector\',\'Utility\');
       foreach($'.$modelName.' as $item)
       {
     
        $link = $this->Html->url(array(\'controller\'=>\''.$extensionName.'\',\'action\'=>\'view\',$item[\''.$modelName.'\'][\'id\'].\'-\'.Inflector::slug($item[\''.$modelName.'\'][\'title\'])),true);

           ?>
        <item>
            <title><?php echo $item[\''.$modelName.'\'][\'title\'] ?></title>
            <link><?php echo $link; ?></link>
            <guid isPermaLink="true"><?php echo $link; ?></guid>
            <pubDate><?php echo date(\'r\',strtotime($item[\''.$modelName.'\'][\'created\'])); ?></pubDate>
        </item>

           <?php
       }

       ?>
    </channel>
</rss>
');

$this->createFile($root.DS.'app'.DS.'View'.DS.ucfirst($extensionName).DS.'view.ctp', '
<div class="row" id="'.$modelName.'">
    <div class="span11 offset1">
            <?php
                echo $'.$modelName.'[\'text\'];
            
            ?>
    </div>
</div>
');

	    $this->out('OK');
    	
    }
}