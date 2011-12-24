<?php
//foreach($this as $name=>$t)
{
    //if($name!='viewVars')
    //debug($this->request->data);
}
/*
if(empty($this->request->data['Happy']) || empty($this->request->data['Happy']['lang_form']))
{
    $this->request->data['Happy']=array('lang_form'=>Configure::read('Config.language'));
}*/
if(empty($this->request->data['Happy']))
{
    $this->request->data['Happy']=array();
}
$this->request->data['Happy']=array_merge(array(
                                       'lang_form'=>Configure::read('Config.language'),
                                       'first_call'=>false
                                       ),(array)$this->request->data['Happy']);




if(empty($this->request->data['Happy']['model_name']))
{
    $this->request->data['Happy']['model_name']='Content';
}

if(!empty($formOptions))
{
    $formOptions=array_merge(array('action'=>'save'),(array)$formOptions);
}
else{
    $formOptions=array('action'=>'save');
}
$formOptions['url']='/admin/'.$ExtensionName.'/'.$formOptions['action'];

if(!empty($file) || ( !empty($formOptions['type']) && $formOptions['type']=='file' ) )
{
    $formOptions['type']='file';
    $this->fileFormLoaded=true;
    if($this->request->data['Happy']['first_call'])
    {
        
        /*App::import('Helper','Plupload');
        $this->pupload = new PluploadHelper();
        echo $this->Html->script($this->pupload->script());
        echo $this->Html->script('plupload.field');*/
            ?>
        <div id="container">
                <div id="filelist"></div>
        </div>
        
        
        <div id="explorer" style="display:none">

        </div>

        <?php
    }
}


$token_input = '<input name="data[_token]" type="hidden" value="'.$this->Session->read('User.token').'">';

$create = $this->Form->create(isset($modelName)?$modelName:$this->request->data['Happy']['model_name'],$formOptions);

$this->request->data['Happy']['output']['formOptions']=$formOptions;

$this->Form->langField='';

//debug($this->request->data);
if($this->request->data['Happy']['first_call'])
{
    echo $create.$token_input;
}

echo $this->Form->input('_extension',array('type'=>'hidden','value'=>empty($this->request->data['Content']['_extension'])?$ExtensionName:$this->request->data['Content']['_extension']));
echo $this->Form->input('id',array('type'=>'hidden'));
//echo $this->Form->input($this->request->data['Happy']['lang_form'],array('type'=>'hidden','value'=>'1'));

$this->Form->langField=$this->request->data['Happy']['lang_form'];

?>